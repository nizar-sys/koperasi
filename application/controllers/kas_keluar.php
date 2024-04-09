<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kas_keluar extends OperatorController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model(['pengeluaran_m','pemasukan_m']);
	}

	public function index() {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Cash/Bank Payment';

		$this->data['akun'] = $this->pemasukan_m->get_akun()->result();
		$this->data['header_code'] = $this->pengeluaran_m->get_header_code();
		$this->data['curr_def'] = $this->pemasukan_m->get_default_currency()->row();
		$this->data['mata_uang'] = $this->pemasukan_m->get_currency()->result();

		$this->data['data_ap_header'] = $this->pengeluaran_m->get_data_ap_header()->result();

		$this->data['isi'] = $this->load->view('kas_keluar_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	public function insert_ap_header(){
		$this->form_validation->set_rules('vcApHeaderCode', 'vcApHeaderCode', 'required');
		$this->form_validation->set_rules('vcUserID', 'vcUserID', 'required');
		$this->form_validation->set_rules('cuRateValue', 'cuRateValue', 'required');
		$this->form_validation->set_rules('dtApDate', 'dtApDate','required');
		$this->form_validation->set_rules('vcCOACode', 'vcCOACode', 'required');
		$this->form_validation->set_rules('vcCurrCode', 'vcCurrCode','required');
		$this->form_validation->set_rules('vcApHeaderDesc', 'vcApHeaderDesc','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$date 		= date('Y-m-d', strtotime($this->input->post('dtApDate')));
			$time		= date('H:i:s');
			$datetime	= date('Y-m-d H:i:s', strtotime("$date $time"));

			$data = array(
				'vcApHeaderCode' 	=> $this->input->post('vcApHeaderCode'), 
				'vcUserID' 			=> $this->input->post('vcUserID'), 
				'cuAPRateValue' 	=> $this->input->post('cuRateValue'), 
				'dtApDate' 			=> $datetime,
				'vcCOACode' 		=> $this->input->post('vcCOACode'), 
				'vcCurrCode' 		=> $this->input->post('vcCurrCode'), 
				'vcApHeaderDesc' 	=> $this->input->post('vcApHeaderDesc'), 
			);
			$vcApHeaderCode = $this->input->post('vcApHeaderCode');
			if($this->pengeluaran_m->insert_ap_header($data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
				redirect('detail_kas_keluar/'.$vcApHeaderCode);
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal disimpan.');
				redirect_back();
			}
		}
	}
	
	public function update_ap_header(){
		$this->form_validation->set_rules('vcApHeaderCode', 'vcApHeaderCode', 'required');
		$this->form_validation->set_rules('dtApDate', 'dtApDate','required');
		$this->form_validation->set_rules('vcCOACode', 'vcCOACode', 'required');
		$this->form_validation->set_rules('vcCurrCode', 'vcCurrCode','required');
		$this->form_validation->set_rules('vcApHeaderDesc', 'vcApHeaderDesc','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'dtApDate' 			=> date('Y-m-d', strtotime($this->input->post('dtApDate'))), 
				'vcCOACode' 		=> $this->input->post('vcCOACode'), 
				'vcCurrCode' 		=> $this->input->post('vcCurrCode'), 
				'vcApHeaderDesc' 	=> $this->input->post('vcApHeaderDesc'), 
			);
			$vcApHeaderCode = $this->input->post('vcApHeaderCode');
			if($this->pengeluaran_m->update_ap_header($vcApHeaderCode, $data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil diubah.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal diubah.');
				redirect_back();
			}
		}
	}

	public function delete_ap_header($IDHeaderAP, $vcApHeaderCode){
		if($this->pengeluaran_m->get_data_ap_header_by_id($vcApHeaderCode)->num_rows() == 0){
			$data = array(
				'itStatusApHeader' => '1', 
			);
			if($this->pengeluaran_m->update_ap_header_by_id($IDHeaderAP, $data)){
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

	public function posting_ap_header($IDHeaderAP){
		$data = array(
			'itPostApHeader' => '1', 
		);
		// ambil data header dan item
		$data_header 	= $this->pengeluaran_m->get_data_header($IDHeaderAP)->row();
		$data_item 		= $this->pengeluaran_m->get_data_ap_header_by_id($data_header->vcApHeaderCode)->result();

		$this->db->trans_start();
		// data header
		$insert_header = array(
			'vcIDJournal' 		=> $data_header->vcApHeaderCode,
			'dtJournal'			=> $data_header->dtApDate,
			'vcCOAJournal'		=> $data_header->vcCOACode,
			'cuJournalCredit' 	=> $data_header->cuItemApTotal,
			'vcJournalDesc'		=> $data_header->vcApHeaderDesc,
			'itPostJournal'		=> '1',
			'vcUserID'			=> $data_header->vcUserID

		);
		$this->db->insert('tbl_journal', $insert_header);

		// data item
		foreach ($data_item as $item) {
			$insert_item = array(
				'vcIDJournal' 		=> $item->vcApHeaderCode,
				'dtJournal'			=> $data_header->dtApDate,
				'vcCOAJournal'		=> $item->vcCOAApItemCode,
				'cuJournalDebet' 	=> $item->cuApItemValue,
				'vcJournalDesc'		=> $item->vcApItemDesc,
				'itPostJournal'		=> '1',
				'vcUserID'			=> $item->vcUserID
			);
			$this->db->insert('tbl_journal', $insert_item);
		};
		// update tbl ap header
		$this->pengeluaran_m->update_ap_header_by_id($IDHeaderAP, $data);
		
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

	public function unposting_ap_header($IDHeaderAP){
		$data = array(
			'itPostApHeader' => '0', 
		);
		// ambil data by IDHeaderap
		$data_header 	= $this->pengeluaran_m->get_data_header($IDHeaderAP)->row();

		$this->db->trans_start();
		//delete tabel row ditabel jurnal
		$this->db->where('vcIDJournal', $data_header->vcApHeaderCode);
		$this->db->delete('tbl_journal');
		// update tabel tbl_apheader
		$this->pengeluaran_m->update_ap_header_by_id($IDHeaderAP, $data);

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

	public function detail($vcApHeaderCode) {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Detail Pengeluaran Kas Accounting';

		$this->data['detail_header'] 	= $this->pengeluaran_m->get_data_ap_header_by_id($vcApHeaderCode)->result();
		$this->data['data_ap_header'] 	= $this->pengeluaran_m->get_header_code_by_id($vcApHeaderCode)->row();
		$this->data['akun'] 			= $this->pemasukan_m->get_akun()->result();

		$this->data['isi'] = $this->load->view('detail_kas_keluar_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	public function insert_ap_item(){
		$this->form_validation->set_rules('vcApHeaderCode', 'vcApHeaderCode', 'required');
		$this->form_validation->set_rules('vcUserID', 'vcUserID', 'required');
		$this->form_validation->set_rules('cuApItemValue', 'cuApItemValue', 'required');
		$this->form_validation->set_rules('vcCOAApItemCode', 'vcCOAApItemCode', 'required');
		$this->form_validation->set_rules('vcApItemDesc', 'vcApItemDesc','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$this->db->trans_start();
			$data = array(
				'vcApHeaderCode' 	=> $this->input->post('vcApHeaderCode'), 
				'vcUserID' 			=> $this->input->post('vcUserID'), 
				'cuApItemValue' 	=> $this->input->post('cuApItemValue'), 
				'vcCOAApItemCode' 	=> $this->input->post('vcCOAApItemCode'), 
				'vcApItemDesc' 		=> $this->input->post('vcApItemDesc'), 
			);

			$harga = $this->input->post('cuApItemValue');
			$this->db->insert('tbl_apitem', $data);

			$this->db->where('vcApHeaderCode', $this->input->post('vcApHeaderCode'));
			$this->db->set('cuItemApTotal', 'cuItemApTotal +'.$harga, FALSE);
			$this->db->update('tbl_apheader');
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

	public function update_ap_item(){
		$this->form_validation->set_rules('IDItemAP', 'IDItemAP', 'required');
		$this->form_validation->set_rules('cuApItemValue_before', 'cuApItemValue_before', 'required');
		$this->form_validation->set_rules('cuApItemValue', 'cuApItemValue', 'required');
		$this->form_validation->set_rules('vcCOAApItemCode', 'vcCOAApItemCode', 'required');
		$this->form_validation->set_rules('vcApItemDesc', 'vcApItemDesc','required');
		$this->form_validation->set_rules('vcApHeaderCode', 'vcApHeaderCode','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$this->db->trans_start();
			$data = array(
				'cuApItemValue' 	=> $this->input->post('cuApItemValue'), 
				'vcCOAApItemCode' 	=> $this->input->post('vcCOAApItemCode'), 
				'vcApItemDesc' 		=> $this->input->post('vcApItemDesc'), 
			);

			$IDItemAP 				= $this->input->post('IDItemAP');
			$cuApItemValue_before 	= $this->input->post('cuApItemValue_before');
			$cuApItemValue 			= $this->input->post('cuApItemValue');

			$this->db->where('IDItemAP', $IDItemAP);
			$this->db->update('tbl_apitem', $data);
			$selisih = $cuApItemValue - $cuApItemValue_before;

			$this->db->where('vcApHeaderCode', $this->input->post('vcApHeaderCode'));
			$this->db->set('cuItemApTotal', 'cuItemApTotal +'.$selisih, FALSE);
			$this->db->update('tbl_apheader');
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

	public function delete_ap_item($IDItemAP, $harga, $vcApHeaderCode){
		$this->db->trans_start();
		$this->db->where('IDItemAP',$IDItemAP);
		$this->db->delete('tbl_apitem');

		$this->db->where('vcApHeaderCode', $vcApHeaderCode);
		$this->db->set('cuItemApTotal', 'cuItemApTotal -'.$harga, FALSE);
		$this->db->update('tbl_apheader');

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
