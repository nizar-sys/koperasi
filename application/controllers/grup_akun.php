<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grup_akun extends AdminController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model('grup_akun_m');
	}

	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Group Chart Of Account';

		$this->data['data_grup_akun'] = $this->grup_akun_m->get_data_grup_akun()->result();
		$this->data['isi'] = $this->load->view('grup_akun_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	public function post_group_akun(){
		$this->form_validation->set_rules('vcGroupName', 'vcGroupName', 'required');
		$this->form_validation->set_rules('vcGroupCode', 'vcGroupCode', 'required');
		$this->form_validation->set_rules('itStatus', 'itStatus','required');
		$this->form_validation->set_rules('vcUserID', 'vcUserID', 'required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'vcGroupCode' 	=> $this->input->post('vcGroupCode'),
				'vcGroupName' 	=> $this->input->post('vcGroupName'),
				'itStatus'    	=> $this->input->post('itStatus'),
				'vcUserID' 		=> $this->input->post('vcUserID'),
			);
			if($this->grup_akun_m->insert($data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal disimpan.');
				redirect_back();
			}
		}
	}

	public function update(){
		$this->form_validation->set_rules('GroupId', 'GroupId', 'required');
		$this->form_validation->set_rules('vcGroupName', 'vcGroupName', 'required');
		$this->form_validation->set_rules('itStatus', 'itStatus','required');
		$this->form_validation->set_rules('vcUserID', 'vcUserID', 'required');
		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'vcGroupName' 	=> $this->input->post('vcGroupName'),
				'itStatus'    	=> $this->input->post('itStatus'),
				'vcUserID' 		=> $this->input->post('vcUserID'),
			);

			$GroupId = $this->input->post('GroupId');

			if($this->grup_akun_m->update($GroupId, $data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil diubah.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal diubah.');
				redirect_back();
			}
		}
	}

	public function delete($GroupId) {
		if($this->grup_akun_m->delete($GroupId)){
			$this->session->set_flashdata('sukses','Selamat, Data berhasil dihapus.');
			redirect_back();
		}else{
			$this->session->set_flashdata('error','Mohon maaf data gagal dihapus.');
			redirect_back();
		}
	}

}
