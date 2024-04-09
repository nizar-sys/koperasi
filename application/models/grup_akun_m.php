<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class grup_akun_m extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	// insert data
	public function insert($data){
		$this->db->insert('tbl_groupcoa', $data);
		return TRUE;
	}

	// update data
	public function update($GroupId, $data){
		$this->db->where('GroupId', $GroupId);
		$this->db->update('tbl_groupcoa', $data);
		return TRUE;
	}

	// hapus data
	public function delete($GroupID){
		$this->db->where('GroupID',$GroupID);
		if($this->db->delete('tbl_groupcoa')){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// ambil data
	public function get_data_grup_akun(){
		$this->db->order_by('GroupId', 'DESC');
		return $this->db->get('tbl_groupcoa');
	}

	// ambil data
	public function get_data_grup_akun_where_aktif(){
		$this->db->order_by('GroupId', 'DESC');
		$this->db->where('itStatus','0');
		return $this->db->get('tbl_groupcoa');
	}

	// ambil data by id
	public function get_data_grup_akun_by_id($vcGroupCode){
		$this->db->where('vcGroupCode', $vcGroupCode);
		return $this->db->get('tbl_groupcoa');
	}
}
