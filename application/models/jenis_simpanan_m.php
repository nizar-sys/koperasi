<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_simpanan_m extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	// insert data
	public function insert($data){
		$this->db->insert('jns_simpan', $data);
		return TRUE;
	}

	// update data
	public function update($id, $data){
		$this->db->where('id', $id);
		$this->db->update('jns_simpan', $data);
		return TRUE;
	}

	// hapus data
	public function delete($id){
		$this->db->where('id',$id);
		if($this->db->delete('jns_simpan')){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// ambil dataj
	public function get_data_jsimpan(){
		$this->db->order_by('id','DESC');
		$this->db->join('tbl_coa C','C.vcCOACode = J.vcCOACode');
		return $this->db->get('jns_simpan J');
	}

	// ambil data by id
	public function get_data_jsimpan_by_id($id){
		$this->db->where('id', $id);
		return $this->db->get('jns_simpan');
	}
}
