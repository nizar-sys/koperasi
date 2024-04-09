<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_simpanan extends AdminController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model(['jenis_simpanan_m','akun_m']);
  }

	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Jenis Simpanan';
		$this->data['data_jsimpan'] = $this->jenis_simpanan_m->get_data_jsimpan()->result();
		$this->data['coa'] = $this->akun_m->get_data_akun_where_aktif()->result();
		$this->data['isi'] = $this->load->view('jenis_simpanan_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	public function post_jenis_simpan(){
		$this->form_validation->set_rules('jns_simpan', 'jns_simpan', 'required');
		$this->form_validation->set_rules('vcCOACode', 'vcCOACode', 'required');
		$this->form_validation->set_rules('jumlah', 'jumlah', 'required');
		$this->form_validation->set_rules('tampil', 'tampil', 'required');

		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'jns_simpan' 		=> $this->input->post('jns_simpan'),
				'vcCOACode' 		=> $this->input->post('vcCOACode'),
				'jumlah' 	    	=> $this->input->post('jumlah'),
				'tampil' 	    	=> $this->input->post('tampil'),
			);

			if($this->jenis_simpanan_m->insert($data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal disimpan.');
				redirect_back();
			}
		}
	}

	public function post_update_jenis_simpanan(){
		$this->form_validation->set_rules('jns_simpan', 'jns_simpan', 'required');
		$this->form_validation->set_rules('vcCOACode', 'vcCOACode', 'required');
		$this->form_validation->set_rules('jumlah', 'jumlah', 'required');
		$this->form_validation->set_rules('tampil', 'tampil', 'required');

		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'jns_simpan' 		=> $this->input->post('jns_simpan'),
				'vcCOACode' 		=> $this->input->post('vcCOACode'),
				'jumlah' 	    	=> $this->input->post('jumlah'),
				'tampil' 	    	=> $this->input->post('tampil'),

			);

			$id = $this->input->post('id');
			if($this->jenis_simpanan_m->update($id, $data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil diubah.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal diubah.');
				redirect_back();
			}
		}
	}

	public function delete($id) {
		if($this->jenis_simpanan_m->delete($id)){
			$this->session->set_flashdata('sukses','Selamat, Data berhasil dihapus.');
			redirect_back();
		}else{
			$this->session->set_flashdata('error','Mohon maaf data gagal dihapus.');
			redirect_back();
		}
	}

}
