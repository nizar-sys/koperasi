<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun extends AdminController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model(['akun_m','grup_akun_m']);
  }

	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Chart Of Account';

		$this->data['data_akun'] = $this->akun_m->get_data_akun()->result();
		$this->data['group_coa'] = $this->grup_akun_m->get_data_grup_akun_where_aktif()->result();
		$this->data['isi'] = $this->load->view('akun_v_2', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	public function post_coa(){
		$this->form_validation->set_rules('vcCOACode', 'vcCOACode', 'required');
		$this->form_validation->set_rules('vcCOAName', 'vcCOAName', 'required');
		$this->form_validation->set_rules('vcGroupCode', 'vcGroupCode', 'required');
		$this->form_validation->set_rules('itCOAType','itCOAType', 'required');
		$this->form_validation->set_rules('itCOALevel', 'itCOALevel', 'required');
		$this->form_validation->set_rules('itCOACashBank', 'itCOACashBank', 'required');
		$this->form_validation->set_rules('itCOAFixedAsset', 'itCOAFixedAsset', 'required');
		$this->form_validation->set_rules('vcCOABalanceType', 'vcCOABalanceType', 'required');
		$this->form_validation->set_rules('cuCOABalanceValue', 'cuCOABalanceValue', 'required');
		$this->form_validation->set_rules('itCOAReportType', 'itCOAReportType', 'required');
		$this->form_validation->set_rules('vcCOADesc', 'vcCOADesc', 'required');
		$this->form_validation->set_rules('itActive', 'itActive', 'required');
		$this->form_validation->set_rules('vcUserID', 'vcUserID', 'required');
		
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'vcCOACode' 		=> $this->input->post('vcCOACode'),
				'vcCOAName' 		=> $this->input->post('vcCOAName'),
				'vcGroupCode' 		=> $this->input->post('vcGroupCode'),
				'itCOAType' 		=> $this->input->post('itCOAType'),
				'itCOALevel' 		=> $this->input->post('itCOALevel'),
				'itCOACashBank' 	=> $this->input->post('itCOACashBank'),
				'itCOAFixedAsset' 	=> $this->input->post('itCOAFixedAsset'),
				'vcCOABalanceType' 	=> $this->input->post('vcCOABalanceType'),
				'cuCOABalanceValue' => $this->input->post('cuCOABalanceValue'),
				'itCOAReportType' 	=> $this->input->post('itCOAReportType'),
				'vcCOADesc' 		=> $this->input->post('vcCOADesc'),
				'itActive' 			=> $this->input->post('itActive'),
				'vcUserID' 			=> $this->input->post('vcUserID'),
				
			);

			if($this->akun_m->insert($data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal disimpan.');
				redirect_back();
			}
		}
	}

	public function post_update_coa(){
		$this->form_validation->set_rules('vcCOAName', 'vcCOAName', 'required');
		$this->form_validation->set_rules('vcGroupCode', 'vcGroupCode', 'required');
		$this->form_validation->set_rules('itCOAType','itCOAType', 'required');
		$this->form_validation->set_rules('itCOALevel', 'itCOALevel', 'required');
		$this->form_validation->set_rules('itCOACashBank', 'itCOACashBank', 'required');
		$this->form_validation->set_rules('itCOAFixedAsset', 'itCOAFixedAsset', 'required');
		$this->form_validation->set_rules('vcCOABalanceType', 'vcCOABalanceType', 'required');
		$this->form_validation->set_rules('cuCOABalanceValue', 'cuCOABalanceValue', 'required');
		$this->form_validation->set_rules('itCOAReportType', 'itCOAReportType', 'required');
		$this->form_validation->set_rules('vcCOADesc', 'vcCOADesc', 'required');
		$this->form_validation->set_rules('itActive', 'itActive', 'required');
		$this->form_validation->set_rules('vcUserID', 'vcUserID', 'required');
		
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'vcCOAName' 		=> $this->input->post('vcCOAName'),
				'vcGroupCode' 		=> $this->input->post('vcGroupCode'),
				'itCOAType' 		=> $this->input->post('itCOAType'),
				'itCOALevel' 		=> $this->input->post('itCOALevel'),
				'itCOACashBank' 	=> $this->input->post('itCOACashBank'),
				'itCOAFixedAsset' 	=> $this->input->post('itCOAFixedAsset'),
				'vcCOABalanceType' 	=> $this->input->post('vcCOABalanceType'),
				'cuCOABalanceValue' => $this->input->post('cuCOABalanceValue'),
				'itCOAReportType' 	=> $this->input->post('itCOAReportType'),
				'vcCOADesc' 		=> $this->input->post('vcCOADesc'),
				'itActive' 			=> $this->input->post('itActive'),
				'vcUserID' 			=> $this->input->post('vcUserID'),
				
			);

			$vcCOACode = $this->input->post('vcCOACode');

			if($this->akun_m->update($vcCOACode, $data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil diubah.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal diubah.');
				redirect_back();
			}
		}
	}

	public function delete($vcCOACode) {
		if($this->akun_m->delete($vcCOACode)){
			$this->session->set_flashdata('sukses','Selamat, Data berhasil dihapus.');
			redirect_back();
		}else{
			$this->session->set_flashdata('error','Mohon maaf data gagal dihapus.');
			redirect_back();
		}
	}

}
