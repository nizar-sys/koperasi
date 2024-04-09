<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kas_masuk extends OperatorController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model('kas_masuk_m');
	}

	public function index() {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Kas Masuk';
		
		$this->data['akun'] = $this->kas_masuk_m->get_akun()->result();
		$this->data['mata_uang'] = $this->kas_masuk_m->get_currency()->result();
		$this->data['header_code'] = $this->kas_masuk_m->get_header_code();
		$this->data['curr_def'] = $this->kas_masuk_m->get_default_currency()->row();

		$this->data['data_ar_header'] = $this->kas_masuk_m->get_data_ar_header()->result();
		$this->data['isi'] = $this->load->view('kas_masuk_v', $this->data, TRUE);
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
			$date 		= date('Y-m-d', strtotime($this->input->post('dtARDate')));
			$time		= date('H:i:s');
			$datetime	= date('Y-m-d H:i:s', strtotime("$date $time"));

			$data = array(
				'vcARHeaderCode' 	=> $this->input->post('vcARHeaderCode'),
				'vcUserID' 			=> $this->input->post('vcUserID'),
				'cuARRateValue' 	=> $this->input->post('cuARRateValue'),
				'dtARDate' 			=> $datetime,
				'vcCOACode' 		=> $this->input->post('vcCOACode'),
				'vcCurrCode' 		=> $this->input->post('vcCurrCode'),
				'vcARHeaderDesc' 	=> $this->input->post('vcARHeaderDesc'),
			);

			$vcARHeaderCode = $this->input->post('vcARHeaderCode');
			if($this->kas_masuk_m->insert_ar_header($data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
				redirect("detail_kas_masuk/".$vcARHeaderCode);
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
			if($this->kas_masuk_m->update_ar_header($vcARHeaderCode, $data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil diubah.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal diubah.');
				redirect_back();
			}
		}
	}

	public function delete_ar_header($IDHeader, $vcARHeaderCode){
		if($this->kas_masuk_m->get_data_ar_header_by_id($vcARHeaderCode)->num_rows() == 0){
			$data = array(
				'itStatusARHeader' => '1',
			);
			if($this->kas_masuk_m->update_ar_header_by_id($IDHeader, $data)){
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
		// ambil data header dan item
		$data_header 	= $this->kas_masuk_m->get_data_header($IDHeader)->row();
		$data_item 		= $this->kas_masuk_m->get_data_ar_header_by_id($data_header->vcARHeaderCode)->result();
		
		$this->db->trans_start();
		// data header
		$insert_header = array(
			'vcIDJournal' 		=> $data_header->vcARHeaderCode,
			'dtJournal'			=> $data_header->dtARDate,
			'vcCOAJournal'		=> $data_header->vcCOACode,
			'cuJournalDebet' 	=> $data_header->cuItemARTotal,
			'vcJournalDesc'		=> $data_header->vcARHeaderDesc,
			'itPostJournal'		=> '1',
			'vcUserID'			=> $data_header->vcUserID

		);
		$this->db->insert('tbl_journal', $insert_header);

		// data item
		foreach ($data_item as $item) {
			$insert_item = array(
				'vcIDJournal' 		=> $item->vcARHeaderCode,
				'dtJournal'			=> $data_header->dtARDate,
				'vcCOAJournal'		=> $item->vcCOAARItemCode,
				'cuJournalCredit' 	=> $item->cuARItemValue,
				'vcJournalDesc'		=> $item->vcARItemDesc,
				'itPostJournal'		=> '1',
				'vcUserID'			=> $item->vcUserID
			);
			$this->db->insert('tbl_journal', $insert_item);
		};
		// update tbl_arheader
		$this->kas_masuk_m->update_ar_header_by_id($IDHeader, $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error','Mohon maaf data gagal diposting.');
			redirect_back();
			return FALSE;
		} else {
			$this->db->trans_complete();
			$this->session->set_flashdata('sukses','Selamat, Data berhasil diposting.');
			redirect_back();
			return TRUE;
		}
	}

	public function unposting_ar_header($IDHeader){
		$data = array(
			'itPostARHeader' => '0',
		);
		// ambil data by IDHeader
		$data_header 	= $this->kas_masuk_m->get_data_header($IDHeader)->row();

		$this->db->trans_start();
		//delete tabel row ditabel jurnal
		$this->db->where('vcIDJournal', $data_header->vcARHeaderCode);
		$this->db->delete('tbl_journal');
		// update tabel tbl_arheader
		$this->kas_masuk_m->update_ar_header_by_id($IDHeader, $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error','Mohon maaf data gagal diposting.');
			redirect_back();
			return FALSE;
		} else {
			$this->db->trans_complete();
			$this->session->set_flashdata('sukses','Selamat, Data berhasil diposting.');
			redirect_back();
			return TRUE;
		}
	}

	public function detail($vcARHeaderCode) {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Detail Kas Masuk';

		$this->data['detail_header'] = $this->kas_masuk_m->get_data_ar_header_by_id($vcARHeaderCode)->result();
		$this->data['data_ar_header'] = $this->kas_masuk_m->get_header_code_by_id($vcARHeaderCode)->row();
		$this->data['akun'] = $this->kas_masuk_m->get_akun()->result();

		$this->data['isi'] = $this->load->view('detail_kas_masuk_v', $this->data, TRUE);
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
			$this->session->set_flashdata('error','Mohon maaf data gagal dihapus.');
			redirect_back();
			return FALSE;
		}else{
			$this->db->trans_complete();
			$this->session->set_flashdata('sukses','Selamat, Data berhasil dihapus.');
			redirect_back();
			return TRUE;
		}
	}
}
