<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_m extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	// insert data
	public function insert($data){
		$this->db->insert('tbl_coa', $data);
		return TRUE;
	}

	// update data
	public function update($vcCoaCode, $data){
		$this->db->where('vcCoaCode', $vcCoaCode);
		$this->db->update('tbl_coa', $data);
		return TRUE;
	}

	// hapus data
	public function delete($vcCOACode){
		$this->db->where('vcCOACode',$vcCOACode);
		if($this->db->delete('tbl_coa')){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// ambil data
	public function get_data_akun(){
		$this->db->order_by('CoaId','ASC');
		$this->db->join('tbl_groupcoa G','G.vcGroupCode = C.vcGroupCode');
		return $this->db->get('tbl_coa C');
	}

	// ambil data by id
	public function get_data_akun_by_id($vcCoaCode){
		$this->db->where('vcCoaCode', $vcCoaCode);
		return $this->db->get('tbl_coa');
	}

	// ambil data
	public function get_data_akun_where_aktif(){
		$this->db->order_by('CoaId', 'DESC');
		$this->db->where('itActive','0');
		return $this->db->get('tbl_coa');
	}
}
