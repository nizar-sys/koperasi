<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengeluaran_m extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	#panggil data kas
	function get_data_kas() {
		$this->db->select('*');
		$this->db->from('nama_kas_tbl');
		$this->db->where('aktif', 'Y');
		$this->db->where('tmpl_pengeluaran', 'Y');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	#panggil data akun
	function get_data_akun() {
		$this->db->select('*');
		$this->db->from('jns_akun');
		$this->db->where('aktif', 'Y');
		$this->db->where('pengeluaran', 'Y');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data simpanan untuk laporan 
	function lap_data_pengeluaran() {
		$kode_transaksi = isset($_REQUEST['kode_transaksi']) ? $_REQUEST['kode_transaksi'] : '';
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_sampai']) ? $_REQUEST['tgl_sampai'] : '';
		$sql = '';
		$sql = " SELECT * FROM tbl_trans_kas WHERE akun='Pengeluaran' ";
		$q = array('kode_transaksi' => $kode_transaksi, 
			'tgl_dari' => $tgl_dari, 
			'tgl_sampai' => $tgl_sampai);
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
				$q['kode_transaksi'] = str_replace('TKK', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				$sql .=" AND id LIKE '".$q['kode_transaksi']."' ";
			} else {			
				if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
					$sql .=" AND DATE(tgl_catat) >= '".$q['tgl_dari']."' ";
					$sql .=" AND DATE(tgl_catat) <= '".$q['tgl_sampai']."' ";
				}
			}
		}
		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			$out = $query->result();
			return $out;
		} else {
			return FALSE;
		}
	}

	//hitung jumlah total 
	function get_jml_pengeluaran() {
		$this->db->select('SUM(jumlah) AS jml_total');
		$this->db->from('tbl_trans_kas');
		$this->db->where('akun','Pengeluaran');
		$query = $this->db->get();
		return $query->row();
	}

	//panggil data simpanan untuk esyui
	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT * FROM tbl_trans_kas WHERE akun='Pengeluaran' ";
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
				$q['kode_transaksi'] = str_replace('TKK', '', $q['kode_transaksi']);
				$q['kode_transaksi'] = $q['kode_transaksi'] * 1;
				$sql .=" AND id LIKE '".$q['kode_transaksi']."' ";
			} else {
				if($q['tgl_dari'] != '' && $q['tgl_sampai'] != '') {
					$sql .=" AND DATE(tgl_catat) >= '".$q['tgl_dari']."' ";
					$sql .=" AND DATE(tgl_catat) <= '".$q['tgl_sampai']."' ";
				}
			}
		}
		$result['count'] = $this->db->query($sql)->num_rows();
		$sql .=" ORDER BY {$sort} {$order} ";
		$sql .=" LIMIT {$offset},{$limit} ";
		$result['data'] = $this->db->query($sql)->result();
		return $result;
	}

	public function create() {
		if(str_replace(',', '', $this->input->post('jumlah')) <= 0) {
			return FALSE;
		}		
		$data = array(			
			'tgl_catat'				=>	$this->input->post('tgl_transaksi'),
			'jumlah'					=>	str_replace(',', '', $this->input->post('jumlah')),
			'keterangan'			=>	$this->input->post('ket'),
			'dk'						=>	'K',
			'akun'					=>	'Pengeluaran',
			'dari_kas_id'			=>	$this->input->post('kas_id'),
			'jns_trans'				=>	$this->input->post('akun_id'),
			'user_name'				=> $this->data['u_name']
		);
		return $this->db->insert('tbl_trans_kas', $data);
	}

	public function update($id)
	{
		if(str_replace(',', '', $this->input->post('jumlah')) <= 0) {
			return FALSE;
		}
		$tanggal_u = date('Y-m-d H:i');
		$this->db->where('id', $id);
		return $this->db->update('tbl_trans_kas',array(
			'tgl_catat'				=>	$this->input->post('tgl_transaksi'),
			'jumlah'					=>	str_replace(',', '', $this->input->post('jumlah')),
			'keterangan'			=>	$this->input->post('ket'),
			'dari_kas_id'			=>	$this->input->post('kas_id'),
			'jns_trans'				=>	$this->input->post('akun_id'),
			'update_data'			=> $tanggal_u,
			'user_name'				=> $this->data['u_name']
		));
	}

	public function delete($id){
		return $this->db->delete('tbl_trans_kas', array('id' => $id)); 
	}

	// ambil header code
	public function get_header_code(){
		$this->db->limit('1');
		$this->db->order_by('IDHeaderAP','DESC');
		return $this->db->get('tbl_apheader');
	}

	// insert data ke table ap_header
	public function insert_ap_header($data){
		$this->db->insert('tbl_apheader', $data);
		return TRUE;
	}

	// ambil data ap header
	public function get_data_ap_header(){
		$this->db->join('tbl_coa C','C.vcCOACode = H.vcCOACode','LEFT');
		$this->db->where('H.itStatusAPHeader','0');
		$this->db->order_by('H.vcApHeaderCode','DESC');
		return $this->db->get('tbl_apheader H');
	}

	// update ap header
	public function update_ap_header($vcApHeaderCode, $data){
		$this->db->where('vcApHeaderCode', $vcApHeaderCode);
		$this->db->update('tbl_apheader', $data);
		return TRUE;
	}

	//update ap header by id
	public function update_ap_header_by_id($IDHeaderAP, $data){
		$this->db->where('IDHeaderAP', $IDHeaderAP);
		$this->db->update('tbl_apheader', $data);
		return TRUE;
	}

	// ambil data ap header
	public function get_data_ap_header_by_id($vcApHeaderCode){
		$this->db->join('tbl_coa C','C.vcCOACode = H.vcCOAApItemCode','LEFT');
		$this->db->where('H.vcApHeaderCode', $vcApHeaderCode);
		$this->db->order_by('H.IDItemAP','DESC');
		return $this->db->get('tbl_apitem H');
	}

	// ambil header code by id
	public function get_header_code_by_id($vcApHeaderCode){
		$this->db->join('tbl_coa C','C.vcCOACode = H.vcCOACode','LEFT');
		$this->db->where('H.vcApHeaderCode',$vcApHeaderCode);
		$this->db->where('H.itStatusApHeader','0');
		return $this->db->get('tbl_apheader H');
	}

	// ambil data header by id header
	public function get_data_header($IDHeaderAP){
		$this->db->limit('1');
		$this->db->where('IDHeaderAP', $IDHeaderAP);
		return $this->db->get('tbl_apheader');
	}
}