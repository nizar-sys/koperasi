<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_kas_m extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	// insert data
	public function insert($data){
		$this->db->insert('nama_kas_tbl', $data);
		if($this->db->affected_rows() > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// update data
	public function update($id, $data){
		$this->db->where('id', $id);
		$this->db->update('nama_kas_tbl', $data);
		return TRUE;
	}

	// hapus data
	public function delete($id){
		$this->db->where('id',$id);
		if($this->db->delete('nama_kas_tbl')){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// ambil dataj
	public function get_data_jkas(){
		$this->db->order_by('id', 'DESC');
		$this->db->join('tbl_coa C','C.vcCOACode = J.vcCOACode');
		return $this->db->get('nama_kas_tbl J');
	}

	// ambil data by id
	public function get_data_jkas_by_id($id){
		$this->db->where('id', $id);
		return $this->db->get('nama_kas_tbl');
	}
}
