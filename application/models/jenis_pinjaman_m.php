<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_pinjaman_m extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	// insert data
	public function insert($data){
		$this->db->insert('jns_pinjam', $data);
		return TRUE;
	}

	// update data
	public function update($id, $data){
		$this->db->where('id', $id);
		$this->db->update('jns_pinjam', $data);
		return TRUE;
	}

	// hapus data
	public function delete($id){
		$this->db->where('id',$id);
		if($this->db->delete('jns_pinjam')){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// ambil dataj
	public function get_data_jpinjam(){
		$this->db->order_by('id', 'DESC');
		$this->db->join('tbl_coa C','C.vcCOACode = J.vcCOACode','C.vcCOACode = J.COAPB','C.vcCOACode = J.COABA');
		//$this->db->join('tbl_coa C','C.vcCOACode = J.COAPB');
		//$this->db->join('tbl_coa C','C.vcCOACode = J.COABA');
		return $this->db->get('jns_pinjam J');
	}

	// ambil data by id
	public function get_data_jpinjam_by_id($id){
		$this->db->where('id', $id);
		return $this->db->get('jns_pinjam');
	}
}
