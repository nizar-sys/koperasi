<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_kas extends AdminController {

	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model(['jenis_kas_m','akun_m','jenis_simpanan_m']);
  }

	public function index() {
		$this->data['judul_browser'] = 'Setting';
		$this->data['judul_utama'] = 'Setting';
		$this->data['judul_sub'] = 'Jenis Kas/Bank';

		$this->data['data_jkas'] = $this->jenis_kas_m->get_data_jkas()->result();
		$this->data['coa'] = $this->akun_m->get_data_akun_where_aktif()->result();
		$this->data['isi'] = $this->load->view('jenis_kas_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	public function post_jenis_kas(){
		$this->form_validation->set_rules('nama', 'nama', 'required');
		$this->form_validation->set_rules('vcCOACode', 'vcCOACode', 'required');
		$this->form_validation->set_rules('aktif', 'aktif', 'required');
		$this->form_validation->set_rules('tmpl_simpan', 'tmpl_simpan', 'required');
		$this->form_validation->set_rules('tmpl_penarikan', 'tmpl_penarikan', 'required');
		$this->form_validation->set_rules('tmpl_pinjaman', 'tmpl_pinjaman', 'required');
		$this->form_validation->set_rules('tmpl_bayar', 'tmpl_bayar', 'required');
		$this->form_validation->set_rules('tmpl_pemasukan', 'tmpl_pemasukan', 'required');
		$this->form_validation->set_rules('tmpl_pengeluaran', 'tmpl_pengeluaran', 'required');
		$this->form_validation->set_rules('tmpl_transfer', 'tmpl_transfer', 'required');

		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'nama' 	    	      => $this->input->post('nama'),
				'vcCOACode' 	      => $this->input->post('vcCOACode'),
				'aktif'	        	  => $this->input->post('aktif'),
				'tmpl_simpan'    	  => $this->input->post('tmpl_simpan'),
				'tmpl_penarikan' 	  => $this->input->post('tmpl_penarikan'),
				'tmpl_pinjaman'  	  => $this->input->post('tmpl_pinjaman'),
				'tmpl_bayar'    	  => $this->input->post('tmpl_bayar'),
				'tmpl_pemasukan' 	  => $this->input->post('tmpl_pemasukan'),
				'tmpl_pengeluaran' 		=> $this->input->post('tmpl_pengeluaran'),
				'tmpl_transfer'			=> $this->input->post('tmpl_transfer')

			);

			if($this->jenis_kas_m->insert($data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil disimpan.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal disimpan.');
				redirect_back();
			}
		}
	}

	public function post_update_jenis_kas(){
		$this->form_validation->set_rules('nama', 'nama', 'required');
		$this->form_validation->set_rules('vcCOACode', 'vcCOACode', 'required');
		$this->form_validation->set_rules('aktif', 'aktif', 'required');
		$this->form_validation->set_rules('tmpl_simpan', 'tmpl_simpan', 'required');
		$this->form_validation->set_rules('tmpl_penarikan', 'tmpl_penarikan', 'required');
		$this->form_validation->set_rules('tmpl_pinjaman', 'tmpl_pinjaman', 'required');
		$this->form_validation->set_rules('tmpl_bayar', 'tmpl_bayar', 'required');
		$this->form_validation->set_rules('tmpl_pemasukan', 'tmpl_pemasukan', 'required');
		$this->form_validation->set_rules('tmpl_pengeluaran', 'tmpl_pengeluaran', 'required');
		$this->form_validation->set_rules('tmpl_transfer', 'tmpl_transfer', 'required');

		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error','Mohon maaf data gagal disimpan, Silahkan lengkapi pengisian data.');
			redirect_back();
		}else{
			$data = array(
				'nama' 	    	      => $this->input->post('nama'),
				'vcCOACode' 	      => $this->input->post('vcCOACode'),
				'aktif'	        	  => $this->input->post('aktif'),
				'tmpl_simpan'    	  => $this->input->post('tmpl_simpan'),
				'tmpl_penarikan' 	  => $this->input->post('tmpl_penarikan'),
				'tmpl_pinjaman'  	  => $this->input->post('tmpl_pinjaman'),
				'tmpl_bayar'    	  => $this->input->post('tmpl_bayar'),
				'tmpl_pemasukan' 	  => $this->input->post('tmpl_pemasukan'),
				'tmpl_pengeluaran' 	=> $this->input->post('tmpl_pengeluaran'),
				'tmpl_transfer'    	=> $this->input->post('tmpl_transfer'),

			);
			$id = $this->input->post('id');
			if($this->jenis_kas_m->update($id, $data)){
				$this->session->set_flashdata('sukses','Selamat, Data berhasil diubah.');
				redirect_back();
			}else{
				$this->session->set_flashdata('error','Mohon maaf data gagal diubah.');
				redirect_back();
			}
		}
	}

	public function delete($id) {
		if($this->jenis_kas_m->delete($id)){
			$this->session->set_flashdata('sukses','Selamat, Data berhasil dihapus.');
			redirect_back();
		}else{
			$this->session->set_flashdata('error','Mohon maaf data gagal dihapus.');
			redirect_back();
		}
	}

}
