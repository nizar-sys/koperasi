<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pemasukan_kas extends OperatorController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model('pemasukan_m');
	}

	public function index() {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Pemasukan Kas Tunai';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

		#include daterange
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		//number_format
		$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';

		$this->data['kas_id'] = $this->pemasukan_m->get_data_kas();
		$this->data['akun_id'] = $this->pemasukan_m->get_data_akun();

		$this->data['isi'] = $this->load->view('pemasukan_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  = isset($_POST['sort']) ? $_POST['sort'] : 'tgl_transaksi';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$kode_transaksi = isset($_POST['kode_transaksi']) ? $_POST['kode_transaksi'] : '';
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_sampai = isset($_POST['tgl_sampai']) ? $_POST['tgl_sampai'] : '';
		$search = array('kode_transaksi' => $kode_transaksi,
			'tgl_dari' => $tgl_dari,
			'tgl_sampai' => $tgl_sampai);
		$offset = ($offset-1)*$limit;
		$data   = $this->pemasukan_m->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order);
		$i	= 0;
		$rows   = array();

		foreach ($data['data'] as $r) {
			$tgl_bayar = explode(' ', $r->tgl_catat);
			$txt_tanggal = jin_date_ina($tgl_bayar[0]);
			$txt_tanggal .= ' - ' . substr($tgl_bayar[1], 0, 5);

			$nama_kas = $this->pemasukan_m->get_jenis_kas($r->untuk_kas_id);
			$nama_akun = $this->pemasukan_m->get_jenis_akun($r->jns_trans);

			$rows[$i]['id'] = $r->id;
			$rows[$i]['id_txt'] ='TKD' . sprintf('%05d', $r->id) . '';
			$rows[$i]['tgl_transaksi'] = $r->tgl_catat;
			$rows[$i]['tgl_transaksi_txt'] = $txt_tanggal;
			$rows[$i]['ket'] = $r->keterangan;
			$rows[$i]['jumlah'] = number_format($r->jumlah);
			$rows[$i]['user'] = $r->user_name;
			$rows[$i]['kas_id'] = $r->untuk_kas_id;
			$rows[$i]['kas_id_txt'] = $nama_kas->nama;
			$rows[$i]['akun_id'] = $r->jns_trans;
			$rows[$i]['akun_id_txt'] = $nama_akun->jns_trans;
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	function get_jenis_simpanan() {
		$id = $this->input->post('jenis_id');
		$jenis_simpanan = $this->general_m->get_id_simpanan();
		foreach ($jenis_simpanan as $row) {
			if($row->id == $id) {
				echo number_format($row->jumlah);
			}
		}
		exit();
	}

	public function create() {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->pemasukan_m->create()){
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil disimpan </div>'));
		}else
		{
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Gagal menyimpan data, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}
	}

	public function update($id=null) {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->pemasukan_m->update($id)) {
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil diubah </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i>  Maaf, Data gagal diubah, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}

	}
	public function delete() {
		if(!isset($_POST))	 {
			show_404();
		}
		$id = intval(addslashes($_POST['id']));
		if($this->pemasukan_m->delete($id))
		{
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data gagal dihapus </div>'));
		}
	}


	function cetak_laporan() {
		$pemasukan = $this->pemasukan_m->lap_data_pemasukan();
		if($pemasukan == FALSE) {
			redirect('pemasukan_kas');
			exit();
		}

		$tgl_dari = $_REQUEST['tgl_dari'];
		$tgl_sampai = $_REQUEST['tgl_sampai'];

		$this->load->library('Pdf');
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('L');
		$html = '';
		$html .= '
		<style>
		.h_tengah {text-align: center;}
		.h_kiri {text-align: left;}
		.h_kanan {text-align: right;}
		.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
		.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		.txt_content {font-size: 10pt; font-style: arial;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Data Pemasukan Kas<br> </span>
			<span> Periode '.jin_date_ina($tgl_dari).' - '.jin_date_ina($tgl_sampai).'</span>'
			, $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'

		<table width="100%" cellspacing="0" cellpadding="3" border="1" border-collapse= "collapse">
		<tr class="header_kolom">
		<th class="h_tengah" style="width:5%;" > No. </th>
		<th class="h_tengah" style="width:10%;"> No Transaksi</th>
		<th class="h_tengah" style="width:15%;"> Tanggal </th>
		<th class="h_tengah" style="width:40%;"> Uraian  </th>
		<th class="h_tengah" style="width:20%;"> Jumlah  </th>
		<th class="h_tengah" style="width:10%;"> User </th>
		</tr>';

		$no =1;
		$jml_tot = 0;
		foreach ($pemasukan as $row) {
			$nama_kas = $this->pemasukan_m->get_jenis_kas($row->untuk_kas_id);
			$nama_akun = $this->pemasukan_m->get_jenis_akun($row->jns_trans);

			$tgl_bayar = explode(' ', $row->tgl_catat);
			$txt_tanggal = jin_date_ina($tgl_bayar[0],'p');

			$jml_tot += $row->jumlah;
			$html .= '
			<tr>
			<td class="h_tengah" >'.$no++.'</td>
			<td class="h_tengah"> '.'TKD'.sprintf('%05d', $row->id).'</td>
			<td class="h_tengah"> '.$txt_tanggal.'</td>
			<td class="h_kiri"> '.$row->keterangan.'</td>
			<td class="h_kanan"> '.number_format($row->jumlah).'</td>
			<td> '.$row->user_name.'</td>
			</tr>';
		}
		$html .= '
		<tr>
		<td colspan="4" class="h_tengah"><strong> Jumlah Total </strong></td>
		<td class="h_kanan"> <strong>'.number_format($jml_tot).'</strong></td>

		</tr>
		</table>';
		$pdf->nsi_html($html);
		$pdf->Output('trans_d'.date('Ymd_His') . '.pdf', 'I');
	}

	public function pemasukan_kas_accounting() {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Pemasukan Kas Accounting';
		$this->data['akun'] = $this->pemasukan_m->get_akun()->result();
		$this->data['mata_uang'] = $this->pemasukan_m->get_currency()->result();
		$this->data['header_code'] = $this->pemasukan_m->get_header_code();
		$this->data['curr_def'] = $this->pemasukan_m->get_default_currency()->row();

		$this->data['data_ar_header'] = $this->pemasukan_m->get_data_ar_header()->result();
		$this->data['isi'] = $this->load->view('pemasukan_account_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	public function insert_ar_header(){
		$this->form_validation->set_rules('vcARHeaderCode', 'vcARHeaderCode', 'required');
		$this->form_validation->set_rules('vcUserID', 'vcUserID', 'required');
		$this->form_validation->set_rules('cuRateValue', 'cuRateValue', 'required');
		$this->form_validation->set_rules('dtARDate', 'dtARDate','required');
		$this->form_validation->set_rules('vcCOACode', 'vcCOACode', 'required');
		$this->form_validation->set_rules('vcCurrCode', 'vcCurrCode','required');
		$this->form_validation->set_rules('vcARHeaderDesc', 'vcARHeaderDesc','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'vcARHeaderCode' 	=> $this->input->post('vcARHeaderCode'),
				'vcUserID' 			=> $this->input->post('vcUserID'),
				'cuARRateValue' 	=> $this->input->post('	cuARRateValue'),
				'dtARDate' 			=> date('Y-m-d', strtotime($this->input->post('dtARDate'))),
				'vcCOACode' 		=> $this->input->post('vcCOACode'),
				'vcCurrCode' 		=> $this->input->post('vcCurrCode'),
				'vcARHeaderDesc' 	=> $this->input->post('vcARHeaderDesc'),
			);

			if($this->pemasukan_m->insert_ar_header($data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal disimpan.');
				redirect_back();
			}
		}
	}

	public function update_ar_header(){
		$this->form_validation->set_rules('vcARHeaderCode', 'vcARHeaderCode', 'required');
		$this->form_validation->set_rules('dtARDate', 'dtARDate','required');
		$this->form_validation->set_rules('vcCOACode', 'vcCOACode', 'required');
		$this->form_validation->set_rules('vcCurrCode', 'vcCurrCode','required');
		$this->form_validation->set_rules('vcARHeaderDesc', 'vcARHeaderDesc','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'dtARDate' 			=> date('Y-m-d', strtotime($this->input->post('dtARDate'))),
				'vcCOACode' 		=> $this->input->post('vcCOACode'),
				'vcCurrCode' 		=> $this->input->post('vcCurrCode'),
				'vcARHeaderDesc' 	=> $this->input->post('vcARHeaderDesc'),
			);
			$vcARHeaderCode = $this->input->post('vcARHeaderCode');
			if($this->pemasukan_m->update_ar_header($vcARHeaderCode, $data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil diubah.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal diubah.');
				redirect_back();
			}
		}
	}

	public function delete_ar_header($IDHeader, $vcARHeaderCode){
		if($this->pemasukan_m->get_data_ar_header_by_id($vcARHeaderCode)->num_rows() == 0){
			$data = array(
				'itStatusARHeader' => '1',
			);
			if($this->pemasukan_m->update_ar_header_by_id($IDHeader, $data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil dihapus.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal dihapus.');
				redirect_back();
			}
		}else{
			$this->session->set_flashdata('error','Mohon maaf data gagal dihapus. Hapus detail terlebih dahulu');
			redirect_back();
		}
	}

	public function posting_ar_header($IDHeader){
		$data = array(
			'itPostARHeader' => '1',
		);
		if($this->pemasukan_m->update_ar_header_by_id($IDHeader, $data)){
			$this->session->set_flashdata('sukses','Selamat, Data berhasil diposting.');
			redirect_back();
		}else{
			$this->session->set_flashdata('error','Mohon maaf data gagal diposting.');
			redirect_back();
		}
	}

	public function unposting_ar_header($IDHeader){
		$data = array(
			'itPostARHeader' => '0',
		);
		if($this->pemasukan_m->update_ar_header_by_id($IDHeader, $data)){
			$this->session->set_flashdata('sukses','Selamat, Data berhasil diunposting.');
			redirect_back();
		}else{
			$this->session->set_flashdata('error','Mohon maaf data gagal diunposting.');
			redirect_back();
		}
	}

	public function detail($vcARHeaderCode) {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Detail Pemasukan Kas Accounting';

		$this->data['detail_header'] = $this->pemasukan_m->get_data_ar_header_by_id($vcARHeaderCode)->result();
		$this->data['data_ar_header'] = $this->pemasukan_m->get_header_code_by_id($vcARHeaderCode)->row();
		$this->data['akun'] = $this->pemasukan_m->get_akun()->result();

		$this->data['isi'] = $this->load->view('detail_pemasukan_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	public function insert_ar_item(){
		$this->form_validation->set_rules('vcARHeaderCode', 'vcARHeaderCode', 'required');
		$this->form_validation->set_rules('vcUserID', 'vcUserID', 'required');
		$this->form_validation->set_rules('cuARItemValue', 'cuARItemValue', 'required');
		$this->form_validation->set_rules('vcCOAARItemCode', 'vcCOAARItemCode', 'required');
		$this->form_validation->set_rules('vcARItemDesc', 'vcARItemDesc','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$this->db->trans_start();
			$data = array(
				'vcARHeaderCode' 	=> $this->input->post('vcARHeaderCode'),
				'vcUserID' 			=> $this->input->post('vcUserID'),
				'cuARItemValue' 	=> $this->input->post('cuARItemValue'),
				'vcCOAARItemCode' 	=> $this->input->post('vcCOAARItemCode'),
				'vcARItemDesc' 		=> $this->input->post('vcARItemDesc'),
			);

			$harga = $this->input->post('cuARItemValue');
			$this->db->insert('tbl_aritem', $data);

			$this->db->where('vcARHeaderCode', $this->input->post('vcARHeaderCode'));
			$this->db->set('cuItemARTotal', 'cuItemARTotal +'.$harga, FALSE);
			$this->db->update('tbl_arheader');
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$this->session->set_flashdata('error','Mohon maaf data gagal disimpan.');
				redirect_back();
				return FALSE;
			} else {
				$this->db->trans_complete();
				$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
				redirect_back();
				return TRUE;
			}
		}
	}

	public function update_ar_item(){
		$this->form_validation->set_rules('IDItem', 'IDItem', 'required');
		$this->form_validation->set_rules('cuARItemValue_before', 'cuARItemValue_before', 'required');
		$this->form_validation->set_rules('cuARItemValue', 'cuARItemValue', 'required');
		$this->form_validation->set_rules('vcCOAARItemCode', 'vcCOAARItemCode', 'required');
		$this->form_validation->set_rules('vcARItemDesc', 'vcARItemDesc','required');
		$this->form_validation->set_rules('vcARHeaderCode', 'vcARHeaderCode','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$this->db->trans_start();
			$data = array(
				'cuARItemValue' 	=> $this->input->post('cuARItemValue'),
				'vcCOAARItemCode' 	=> $this->input->post('vcCOAARItemCode'),
				'vcARItemDesc' 		=> $this->input->post('vcARItemDesc'),
			);

			$IDItem 				= $this->input->post('IDItem');
			$cuARItemValue_before 	= $this->input->post('cuARItemValue_before');
			$cuARItemValue 			= $this->input->post('cuARItemValue');

			$this->db->where('IDItem', $IDItem);
			$this->db->update('tbl_aritem', $data);
			$selisih = $cuARItemValue - $cuARItemValue_before;

			$this->db->where('vcARHeaderCode', $this->input->post('vcARHeaderCode'));
			$this->db->set('cuItemARTotal', 'cuItemARTotal +'.$selisih, FALSE);
			$this->db->update('tbl_arheader');
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$this->session->set_flashdata('error','Mohon maaf data gagal disimpan.');
				redirect_back();
				return FALSE;
			} else {
				$this->db->trans_complete();
				$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
				redirect_back();
				return TRUE;
			}
		}
	}

	public function delete_ar_item($IDItem, $harga, $vcARHeaderCode){
		$this->db->trans_start();
		$this->db->where('IDItem',$IDItem);
		$this->db->delete('tbl_aritem');

		$this->db->where('vcARHeaderCode', $vcARHeaderCode);
		$this->db->set('cuItemARTotal', 'cuItemARTotal -'.$harga, FALSE);
		$this->db->update('tbl_arheader');

		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan.');
			redirect_back();
			return FALSE;
		}else{
			$this->db->trans_complete();
			$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
			redirect_back();
			return TRUE;
		}
	}
}
