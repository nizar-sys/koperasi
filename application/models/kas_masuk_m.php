<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kas_masuk_m extends CI_Model {

	public function __construct(){
		parent::__construct();
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
		$this->db->order_by('H.vcARHeaderCode','DESC');
		return $this->db->get('tbl_arheader H');
	}

	// ambil data ar header
	public function get_data_ar_header_by_id($vcARHeaderCode){
		// $this->db->join('tbl_arheader C','C.vcARHeaderCode = H.vcARHeaderCode','LEFT');
		$this->db->join('tbl_coa C','C.vcCOACode = H.vcCOAARItemCode','LEFT');
		$this->db->where('H.vcARHeaderCode', $vcARHeaderCode);
		$this->db->order_by('H.IDItem','DESC');
		return $this->db->get('tbl_aritem H');
	}

	// ambil data header by id header
	public function get_data_header($IDHeader){
		$this->db->limit('1');
		$this->db->where('IDHeader', $IDHeader);
		return $this->db->get('tbl_arheader');
	}
}
