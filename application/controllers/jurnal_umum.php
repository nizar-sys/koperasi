<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jurnal_umum extends OperatorController {
	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model(['transfer_m','jurnal_umum_m']);
	}

	public function index() {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'General Journal';
		$this->data['header_code'] = $this->jurnal_umum_m->get_header_code();
		$this->data['curr_def'] = $this->jurnal_umum_m->get_default_currency()->row();
		$this->data['mata_uang'] = $this->jurnal_umum_m->get_currency()->result();

		$this->data['data_memo_header'] = $this->jurnal_umum_m->get_data_memo_header()->result();

		$this->data['isi'] = $this->load->view('jurnal_umum_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	public function detail($vcMemoHeaderCode) {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Detail Jurnal Umum';

		$this->data['detail_header'] = $this->jurnal_umum_m->get_data_memo_header_by_id_2($vcMemoHeaderCode)->result();
		$this->data['data_memo_header'] = $this->jurnal_umum_m->get_header_code_by_id($vcMemoHeaderCode)->row();
		$this->data['akun'] = $this->jurnal_umum_m->get_akun()->result();

		$this->data['isi'] = $this->load->view('detail_jurnal_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}

	public function insert_memo_header(){
		$this->form_validation->set_rules('vcMemoHeaderCode', 'vcMemoHeaderCode', 'required');
		$this->form_validation->set_rules('vcUserID', 'vcUserID', 'required');
		$this->form_validation->set_rules('cuMemoRateValue', 'cuMemoRateValue', 'required');
		$this->form_validation->set_rules('dtMemoDate', 'dtMemoDate','required');
		$this->form_validation->set_rules('vcCurrCode', 'vcCurrCode','required');
		$this->form_validation->set_rules('vcMemoHeaderDesc', 'vcMemoHeaderDesc','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$date 		= date('Y-m-d', strtotime($this->input->post('dtMemoDate')));
			$time		= date('H:i:s');
			$datetime	= date('Y-m-d H:i:s', strtotime("$date $time"));

			$data = array(
				'vcMemoHeaderCode' 	=> $this->input->post('vcMemoHeaderCode'), 
				'vcUserID' 			=> $this->input->post('vcUserID'), 
				'cuMemoRateValue' 	=> $this->input->post('cuMemoRateValue'), 
				'dtMemoDate' 		=> $datetime, 
				'vcCurrCode' 		=> $this->input->post('vcCurrCode'), 
				'vcMemoHeaderDesc' 	=> $this->input->post('vcMemoHeaderDesc'), 
			);
			$vcMemoHeaderCode 	= $this->input->post('vcMemoHeaderCode');
			if($this->jurnal_umum_m->insert_memo_header($data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
				redirect('detail_jurnal_umum/'.$vcMemoHeaderCode);
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal disimpan.');
				redirect_back();
			}
		}
	}

	public function update_memo_header(){
		$this->form_validation->set_rules('vcMemoHeaderCode', 'vcMemoHeaderCode', 'required');
		$this->form_validation->set_rules('dtMemoDate', 'dtMemoDate','required');
		$this->form_validation->set_rules('vcCurrCode', 'vcCurrCode','required');
		$this->form_validation->set_rules('vcMemoHeaderDesc', 'vcMemoHeaderDesc','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'dtMemoDate' 		=> date('Y-m-d', strtotime($this->input->post('dtMemoDate'))), 
				'vcCurrCode' 		=> $this->input->post('vcCurrCode'), 
				'vcMemoHeaderDesc' 	=> $this->input->post('vcMemoHeaderDesc'), 
			);
			$vcMemoHeaderCode = $this->input->post('vcMemoHeaderCode');
			if($this->jurnal_umum_m->update_memo_header($vcMemoHeaderCode, $data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil diubah.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal diubah.');
				redirect_back();
			}
		}
	}

	public function posting_memo_header($IDHeaderMemo){
		$data = array(
			'itPostMemoHeader' => '1',
		);
		$kredit = $this->jurnal_umum_m->get_data_memo_header_by_id($IDHeaderMemo)->row()->cuMemoHeaderCredit;
		$debet = $this->jurnal_umum_m->get_data_memo_header_by_id($IDHeaderMemo)->row()->cuMemoHeaderDebet;
		if($kredit === $debet){
			// ambil data header dan item
			$data_header 	= $this->jurnal_umum_m->get_data_memo_header_by_id($IDHeaderMemo)->row();
			$data_item 		= $this->jurnal_umum_m->get_data_memo_header_by_id_2($data_header->vcMemoHeaderCode)->result();

			$this->db->trans_start();
			// data item
			foreach ($data_item as $item) {
			if($item->debet_or_kredit == 'K'){
				$creditValue 	= $item->cuMemoItemValue;
				$debetValue 	= 0;
			}else{
				$creditValue	= 0;
				$debetValue 	= $item->cuMemoItemValue;
			}
				$insert_item = array(
					'vcIDJournal' 		=> $item->vcMemoHeaderCode,
					'dtJournal'			=> $data_header->dtMemoDate,
					'vcCOAJournal'		=> $item->vcCOAMemoItemCode,
					'cuJournalCredit' 	=> $creditValue,
					'cuJournalDebet' 	=> $debetValue,
					'vcJournalDesc'		=> $item->vcMemoItemDesc,
					'itPostJournal'		=> '1',
					'vcUserID'			=> $item->vcUserID
				);
				$this->db->insert('tbl_journal', $insert_item);
			};
			$this->jurnal_umum_m->update_memo_header_by_id($IDHeaderMemo, $data);

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
		}else{
			$this->session->set_flashdata('error','Mohon maaf data gagal diposting. Nilai kredit dan debet tidak sama.');
			redirect_back();
		}
	}

	public function unposting_memo_header($IDHeaderMemo){
		$data = array(
			'itPostMemoHeader' => '0',
		);

		$data_header 	= $this->jurnal_umum_m->get_data_memo_header_by_id($IDHeaderMemo)->row();

		$this->db->trans_start();
		//delete tabel row ditabel jurnal
		$this->db->where('vcIDJournal', $data_header->vcMemoHeaderCode);
		$this->db->delete('tbl_journal');

		$this->jurnal_umum_m->update_memo_header_by_id($IDHeaderMemo, $data);

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

	public function delete_memo_header($IDHeaderMemo){
		if($this->jurnal_umum_m->get_data_memo_header_by_id($IDHeaderMemo)->num_rows() == 0){
			$data = array(
				'itStatusMemoHeader' => '1',
			);
			if($this->jurnal_umum_m->update_memo_header_by_id($IDHeaderMemo, $data)){
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

	public function insert_memo_item(){
		$this->form_validation->set_rules('vcMemoHeaderCode', 'vcMemoHeaderCode', 'required');
		$this->form_validation->set_rules('vcUserID', 'vcUserID', 'required');
		$this->form_validation->set_rules('cuMemoItemValue', 'cuMemoItemValue', 'required');
		$this->form_validation->set_rules('vcCOAMemoItemCode', 'vcCOAMemoItemCode', 'required');
		$this->form_validation->set_rules('vcMemoItemDesc', 'vcMemoItemDesc','required');
		$this->form_validation->set_rules('debet_or_kredit', 'debet_or_kredit','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$this->db->trans_start();
			$data = array(
				'vcMemoHeaderCode' 		=> $this->input->post('vcMemoHeaderCode'),
				'vcUserID' 				=> $this->input->post('vcUserID'),
				'cuMemoItemValue' 		=> $this->input->post('cuMemoItemValue'),
				'vcCOAMemoItemCode' 	=> $this->input->post('vcCOAMemoItemCode'),
				'vcMemoItemDesc' 		=> $this->input->post('vcMemoItemDesc'),
				'debet_or_kredit' 		=> $this->input->post('debet_or_kredit')
			);

			$debet_or_kredit = $this->input->post('debet_or_kredit');
			$harga = $this->input->post('cuMemoItemValue');
			$this->db->insert('tbl_memoitem', $data);

			$this->db->where('vcMemoHeaderCode', $this->input->post('vcMemoHeaderCode'));
			if($debet_or_kredit == 'D'){
				$this->db->set('cuMemoHeaderDebet', 'cuMemoHeaderDebet +'.$harga, FALSE);
			}else{
				$this->db->set('cuMemoHeaderCredit', 'cuMemoHeaderCredit +'.$harga, FALSE);
			}
			$this->db->update('tbl_memoheader');
			
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

	public function update_memo_item(){
		$this->form_validation->set_rules('IDItemMemo', 'IDItemMemo', 'required');
		$this->form_validation->set_rules('cuMemoItemValue_before', 'cuMemoItemValue_before', 'required');
		$this->form_validation->set_rules('vcUserID', 'vcUserID', 'required');
		$this->form_validation->set_rules('cuMemoItemValue', 'cuMemoItemValue', 'required');
		$this->form_validation->set_rules('vcCOAMemoItemCode', 'vcCOAMemoItemCode', 'required');
		$this->form_validation->set_rules('vcMemoItemDesc', 'vcMemoItemDesc','required');
		$this->form_validation->set_rules('debet_or_kredit', 'debet_or_kredit','required');
		$this->form_validation->set_rules('vcMemoHeaderCode', 'vcMemoHeaderCode','required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$this->db->trans_start();
			$data = array(
				'cuMemoItemValue' 		=> $this->input->post('cuMemoItemValue'),
				'vcCOAMemoItemCode' 	=> $this->input->post('vcCOAMemoItemCode'),
				'vcMemoItemDesc' 		=> $this->input->post('vcMemoItemDesc'),
				'debet_or_kredit' 		=> $this->input->post('debet_or_kredit')
			);

			$IDItemMemo 				= $this->input->post('IDItemMemo');
			$cuMemoItemValue_before 	= $this->input->post('cuMemoItemValue_before');
			$cuMemoItemValue 			= $this->input->post('cuMemoItemValue');
			$debet_or_kredit 			= $this->input->post('debet_or_kredit');

			$this->db->where('IDItemMemo', $IDItemMemo);
			$this->db->update('tbl_memoitem', $data);
			$selisih = $cuMemoItemValue - $cuMemoItemValue_before;
			$this->db->where('vcMemoHeaderCode', $this->input->post('vcMemoHeaderCode'));
			if($debet_or_kredit == 'D'){
				$this->db->set('cuMemoHeaderDebet', 'cuMemoHeaderDebet +'.$selisih, FALSE);
			}else{
				$this->db->set('cuMemoHeaderCredit', 'cuMemoHeaderCredit +'.$selisih, FALSE);
			}
			$this->db->update('tbl_memoheader');

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

	public function delete_memo_item($IDItemMemo){
		$data_item = $this->jurnal_umum_m->get_data_item_by_id($IDItemMemo)->row();
		$vcMemoHeaderCode 	= $data_item->vcMemoHeaderCode;
		$debet_or_kredit 	= $data_item->debet_or_kredit;
		$harga 				= $data_item->cuMemoItemValue;
		$this->db->trans_start();
		$this->db->where('IDItemMemo',$IDItemMemo);
		$this->db->delete('tbl_memoitem');

		$this->db->where('vcMemoHeaderCode', $vcMemoHeaderCode);
		if($debet_or_kredit == 'D'){
			$this->db->set('cuMemoHeaderDebet', 'cuMemoHeaderDebet -'.$harga, FALSE);
		}else{
			$this->db->set('cuMemoHeaderCredit', 'cuMemoHeaderCredit -'.$harga, FALSE);
		}
		$this->db->update('tbl_memoheader');

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
