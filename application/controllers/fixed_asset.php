<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fixed_asset extends OperatorController {
	public function __construct() {
		parent::__construct();
		$this->load->helper('fungsi');
		$this->load->model('transfer_m');
	}

	public function index() {		
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Fixed Asset ';
		$this->data['isi'] = $this->load->view('fixed_asset_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}


	public function detail_fixed() {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Detail Fixed Asset';
		$this->data['isi'] = $this->load->view('detail_fixed_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);

	}


}
