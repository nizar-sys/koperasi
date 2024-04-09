<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pemasukan_m extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	#panggil data kas
	function get_data_kas() {
		$this->db->select('*');
		$this->db->from('nama_kas_tbl');
		$this->db->where('aktif', 'Y');
		$this->db->where('tmpl_pemasukan', 'Y');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

//panggil data jenis kas
	function get_jenis_kas($id) {
		$this->db->select('*');
		$this->db->from('nama_kas_tbl');
		$this->db->where('id',$id);
		$query = $this->db->get();

		if($query->num_rows()>0){
			$out = $query->row();
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
		$this->db->where('pemasukan', 'Y');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$out = $query->result();
			return $out;
		} else {
			return array();
		}
	}

	//panggil data jenis kas
	function get_jenis_akun($id) {
		$this->db->select('*');
		$this->db->from('jns_akun');
		$this->db->where('id',$id);
		$query = $this->db->get();

		if($query->num_rows()>0){
			$out = $query->row();
			return $out;
		} else {
			return FALSE;
		}
	}

	//panggil data simpanan untuk laporan
	function lap_data_pemasukan() {
		$kode_transaksi = isset($_REQUEST['kode_transaksi']) ? $_REQUEST['kode_transaksi'] : '';
		$tgl_dari = isset($_REQUEST['tgl_dari']) ? $_REQUEST['tgl_dari'] : '';
		$tgl_sampai = isset($_REQUEST['tgl_sampai']) ? $_REQUEST['tgl_sampai'] : '';
		$sql = '';
		$sql = " SELECT * FROM tbl_trans_kas WHERE akun='Pemasukan' ";
		$q = array('kode_transaksi' => $kode_transaksi,
			'tgl_dari' => $tgl_dari,
			'tgl_sampai' => $tgl_sampai);
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
				$q['kode_transaksi'] = str_replace('TKD', '', $q['kode_transaksi']);
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

	//panggil data simpanan untuk esyui
	function get_data_transaksi_ajax($offset, $limit, $q='', $sort, $order) {
		$sql = "SELECT * FROM tbl_trans_kas WHERE akun='Pemasukan' ";
		if(is_array($q)) {
			if($q['kode_transaksi'] != '') {
				$q['kode_transaksi'] = str_replace('TKD', '', $q['kode_transaksi']);
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
			'tgl_catat'		=>	$this->input->post('tgl_transaksi'),
			'jumlah'					=>	str_replace(',', '', $this->input->post('jumlah')),
			'keterangan'			=>	$this->input->post('ket'),
			'dk'						=>	'D',
			'akun'					=>	'Pemasukan',
			'untuk_kas_id'			=>	$this->input->post('kas_id'),
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
			'untuk_kas_id'			=>	$this->input->post('kas_id'),
			'jns_trans'				=>	$this->input->post('akun_id'),
			'update_data'			=> $tanggal_u,
			'user_name'				=> $this->data['u_name']
		));
	}

	public function delete($id)
	{
		return $this->db->delete('tbl_trans_kas', array('id' => $id));
	}

	//ambil kode akun
	public function get_akun(){
		return $this->db->get('tbl_coa');
	}

	//ambil mata uang
	public function get_currency(){
		return $this->db->get('tbl_currency');
	}

	// ambil header code
	public function get_header_code(){
		$this->db->limit('1');
		$this->db->order_by('IDHeader','DESC');
		return $this->db->get('tbl_arheader');
	}

	// ambil header code by id
	public function get_header_code_by_id($vcARHeaderCode){
		$this->db->join('tbl_coa C','C.vcCOACode = H.vcCOACode','LEFT');
		$this->db->where('H.vcARHeaderCode',$vcARHeaderCode);
		$this->db->where('H.itStatusARHeader','0');
		return $this->db->get('tbl_arheader H');
	}

	// ambil default tbl_currency
	public function get_default_currency(){
		$this->db->where('itDefault = 1');
		return $this->db->get('tbl_currency');
	}

	// insert data ke table ar_header
	public function insert_ar_header($data){
		$this->db->insert('tbl_arheader', $data);
		return TRUE;
	}

	// insert data ke table ar_item->blm dipake
	public function insert_ar_item($data){
		$this->db->insert('tbl_aritem', $data);
		return TRUE;
	}

	// update ar header
	public function update_ar_header($vcARHeaderCode, $data){
		$this->db->where('vcARHeaderCode', $vcARHeaderCode);
		$this->db->update('tbl_arheader', $data);
		return TRUE;
	}

	//update ar header by id
	public function update_ar_header_by_id($IDHeader, $data){
		$this->db->where('IDHeader', $IDHeader);
		$this->db->update('tbl_arheader', $data);
		return TRUE;
	}

	//update ar header by id
	public function update_ar_item_by_id($IDitem, $data){
		$this->db->where('IDitem', $IDitem);
		$this->db->update('tbl_aritem', $data);
		return TRUE;
	}

	// hapus ar header
	public function delete_ar_header($IDHeader){
		$this->db->where('IDHeader',$IDHeader);
		if($this->db->delete('tbl_arheader')){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// hapus ar item -> belum dipakai
	public function delete_ar_item($IDItem){
		$this->db->where('IDItem',$IDItem);
		if($this->db->delete('tbl_aritem')){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// ambil data ar header
	public function get_data_ar_header(){
		$this->db->join('tbl_coa C','C.vcCOACode = H.vcCOACode','LEFT');
		$this->db->where('H.itStatusARHeader','0');
		return $this->db->get('tbl_arheader H');
	}

	// ambil data ar header
	public function get_data_ar_header_by_id($vcARHeaderCode){
		// $this->db->join('tbl_arheader C','C.vcARHeaderCode = H.vcARHeaderCode','LEFT');
		$this->db->join('tbl_coa C','C.vcCOACode = H.vcCOAARItemCode','LEFT');
		$this->db->where('H.vcARHeaderCode', $vcARHeaderCode);
		return $this->db->get('tbl_aritem H');
	}
}
