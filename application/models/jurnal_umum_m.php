<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jurnal_umum_m extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	//ambil kode akun
	public function get_akun()
	{
		return $this->db->get('tbl_coa');
	}

	// ambil header code
	public function get_header_code()
	{
		$this->db->limit('1');
		$this->db->order_by('IDHeaderMemo', 'DESC');
		return $this->db->get('tbl_memoheader');
	}

	// ambil header code by id
	public function get_header_code_by_id($vcMemoHeaderCode)
	{
		$this->db->limit('1');
		$this->db->order_by('IDHeaderMemo', 'DESC');
		$this->db->where('vcMemoHeaderCode', $vcMemoHeaderCode);
		return $this->db->get('tbl_memoheader');
	}

	// ambil default tbl_currency
	public function get_default_currency()
	{
		$this->db->where('itDefault = 1');
		return $this->db->get('tbl_currency');
	}

	//ambil mata uang
	public function get_currency()
	{
		return $this->db->get('tbl_currency');
	}

	// ambil data memo header
	public function get_data_memo_header()
	{
		$this->db->where('H.itStatusMemoHeader', '0');
		$this->db->order_by('vcMemoHeaderCode', 'DESC');
		return $this->db->get('tbl_memoheader H');
	}

	public function get_data_memo_header_by_id($IDHeaderMemo)
	{
		$this->db->where('H.itStatusMemoHeader', '0');
		$this->db->where('IDHeaderMemo', $IDHeaderMemo);
		return $this->db->get('tbl_memoheader H');
	}

	// ambil data memo header
	public function get_data_memo_header_by_id_2($vcMemoHeaderCode)
	{
		$this->db->join('tbl_coa C', 'H.vcCOAMemoItemCode = C.vcCOACode');
		$this->db->where('H.vcMemoHeaderCode', $vcMemoHeaderCode);
		$this->db->order_by('IDItemMemo', 'DESC');
		return $this->db->get('tbl_memoitem H');
	}

	// insert data ke table memoheader
	public function insert_memo_header($data)
	{
		$this->db->insert('tbl_memoheader', $data);
		return TRUE;
	}

	// update memo header
	public function update_memo_header($vcMemoHeaderCode, $data)
	{
		$this->db->where('vcMemoHeaderCode', $vcMemoHeaderCode);
		$this->db->update('tbl_memoheader', $data);
		return TRUE;
	}

	//update ar header by id
	public function update_memo_header_by_id($IDHeaderMemo, $data)
	{
		$this->db->where('IDHeaderMemo', $IDHeaderMemo);
		$this->db->update('tbl_memoheader', $data);
		return TRUE;
	}

	// get data item memo
	public function get_data_item_by_id($IDItemMemo)
	{
		$this->db->where('IDItemMemo', $IDItemMemo);
		return $this->db->get('tbl_memoitem');
	}

	public function get_akun_journal()
	{
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');
		// $this->db->group_by('J.vcCOAJournal');
		return $this->db->get('tbl_journal J');
	}

	public function get_akun_journal_umum()
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
			if ($_REQUEST['jenis_akun'] != 'no') {
				$jenis_akun = $_REQUEST['jenis_akun'];
				$this->db->where('J.vcCOAJournal', $jenis_akun);
			}
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}

		$this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari . '');
		$this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp . '');

		// $this->db->group_by('J.vcCOAJournal');
		return $this->db->get();
	}

	public function get_data_journal()
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');
		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
			if ($_REQUEST['jenis_akun'] != 'no') {
				$jenis_akun = $_REQUEST['jenis_akun'];
				$this->db->where('J.vcCOAJournal', $jenis_akun);
			}
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
			// if ($_REQUEST['jenis_akun'] != 'no') {
			// 	$jenis_akun = $_REQUEST['jenis_akun'];
			// 	$this->db->where('J.vcCOAJournal', $jenis_akun);
			// }
		}

		$this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari . '');
		$this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp . '');

		return $this->db->get();
		// print_r($this->db->last_query());
	}

	// public function get_data_journal_query()
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('tbl_journal J');
	// 	$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');
	// 	if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
	// 		$tgl_dari = $_REQUEST['tgl_dari'];
	// 		$tgl_samp = $_REQUEST['tgl_samp'];
	// 		if ($_REQUEST['jenis_akun'] != 'no'){
	// 			$jenis_akun = $_REQUEST['jenis_akun'];
	// 			$this->db->where('J.vcCOAJournal', $jenis_akun);
	// 		}
	// 	} else {
	// 		$tgl_dari = date('Y') . '-01-01';
	// 		$tgl_samp = date('Y') . '-12-31';
	// 		if ($_REQUEST['jenis_akun'] != 'no') {
	// 			$jenis_akun = $_REQUEST['jenis_akun'];
	// 			$this->db->where('J.vcCOAJournal', $jenis_akun);
	// 		}
	// 	}

	// 	$this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari . '');
	// 	$this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp . '');

	// 	$this->db->get();
	// 	print_r($this->db->last_query());
	// }

	public function get_data_journal_by_id($id_akun)
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
			$level_min = $_REQUEST['level_min'];
			$level_max = $_REQUEST['level_max'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
			$level_min = '0';
			$level_max = '3';
		}
		$this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari . '');
		$this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp . '');


		$this->db->where('C.itCOALevel >= ', '' . $level_min . '');
		$this->db->where('C.itCOALevel <= ', '' . $level_max . '');

		$this->db->where('vcCOAJournal', $id_akun);
		return $this->db->get();
	}

	public function get_data_balance_by_id($id_akun)
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
			if ($_REQUEST['level'] != '') {
				$level = $_REQUEST['level'];
				$this->db->where('C.itCOALevel = ', '' . $level . '');
			}
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
			$level = '';
		}
		// $this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp . '');
		// $this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari . '');

		$this->db->where('vcCOAJournal', $id_akun);
		return $this->db->get();
	}

	public function get_data_balance_before_by_id($id_akun)
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];

			$tgl_dari_before = (date('Y', strtotime($tgl_dari)) - 1) . '-' . date('m-d', strtotime($tgl_dari));
			$tgl_samp_before = (date('Y', strtotime($tgl_samp)) - 1) . '-' . date('m-d', strtotime($tgl_samp));

			if ($_REQUEST['level'] != '') {
				$level = $_REQUEST['level'];
				$this->db->where('C.itCOALevel = ', '' . $level . '');
			}
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';

			$tgl_dari_before = date('Y') - 1 . '-01-01';
			$tgl_samp_before = date('Y') - 1 . '-12-31';

			$level_min = '';
		}
		// $this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari_before . '');
		// $this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp_before . '');

		$this->db->where('vcCOAJournal', $id_akun);
		return $this->db->get();
	}

	public function get_akun_balance()
	{
		$this->db->select('*');
		$this->db->from('tbl_coa C');
		$this->db->join('tbl_journal J', 'J.vcCOAJournal = C.vcCOACode', 'left');
		$this->db->join('tbl_groupcoa G', 'G.vcGroupCode = C.vcGroupCode', 'left');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
			if ($_REQUEST['level'] != '') {
				$level = $_REQUEST['level'];
				$this->db->where('C.itCOALevel = ', '' . $level . '');
			}
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
			$level_min = '';
		}

		// $this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari . '');
		// $this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp . '');


		// $this->db->group_by('C.vcCOACode');
		return $this->db->get();
	}

	public function get_data_journal_umum_by_id($id_akun)
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari . '');
		$this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp . '');

		$this->db->where('vcCOAJournal', $id_akun);
		return $this->db->get();
	}

	public function get_data_journal_umum_by_id_before($id_akun)
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
		} else {
			$tgl_dari = ((date('Y')) - 1) . '-12-31';
		}
		$this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_dari . '');

		$this->db->where('vcCOAJournal', $id_akun);
		return $this->db->get();
	}

	public function get_akun_trial_balance()
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
			if ($_REQUEST['level'] != '') {
				$level = $_REQUEST['level'];
				$this->db->where('C.itCOALevel = ', '' . $level . '');
			}
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}

		$this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari . '');
		$this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp . '');


		// $this->db->group_by('J.vcCOAJournal');
		return $this->db->get();
	}

	public function get_data_trial_balance_by_id($id_akun)
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
			if ($_REQUEST['level'] != '') {
				$level = $_REQUEST['level'];
				$this->db->where('C.itCOALevel = ', '' . $level . '');
			}
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
		}
		$this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari . '');
		$this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp . '');

		$this->db->where('vcCOAJournal', $id_akun);
		return $this->db->get();
	}

	public function get_data_trial_balance_before_by_id($id_akun)
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
			if ($_REQUEST['level'] != '') {
				$level = $_REQUEST['level'];
				$this->db->where('C.itCOALevel = ', '' . $level . '');
			}

		} else {
			$tgl_dari = ((date('Y')) - 1) . '-12-31';
		}
		$this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_dari . '');

		$this->db->where('vcCOAJournal', $id_akun);
		return $this->db->get();
	}


	public function get_akun_laba()
	{
		$this->db->select('*');
		$this->db->from('tbl_coa C');
		$this->db->join('tbl_journal J', 'J.vcCOAJournal = C.vcCOACode', 'left');
		$this->db->join('tbl_groupcoa G', 'G.vcGroupCode = C.vcGroupCode', 'left');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
			if ($_REQUEST['level'] != '') {
				$level = $_REQUEST['level'];
				$this->db->where('C.itCOALevel = ', '' . $level . '');
			}
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
			$level_min = '';
		}

		// $this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari . '');
		// $this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp . '');
		$this->db->where('G.vcGroupCode = "33" OR G.vcGroupCode = "44"');


		// $this->db->group_by('C.vcCOACode');
		return $this->db->get();
	}

	public function get_data_laba_by_id($id_akun)
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];
			if ($_REQUEST['level'] != '') {
				$level = $_REQUEST['level'];
				$this->db->where('C.itCOALevel = ', '' . $level . '');
			}
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';
			$level = '';
		}
		$this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp . '');
		$this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari . '');

		$this->db->where('vcCOAJournal', $id_akun);
		return $this->db->get();
	}

	public function get_data_laba_before_by_id($id_akun)
	{
		$this->db->select('*');
		$this->db->from('tbl_journal J');
		$this->db->join('tbl_coa C', 'C.vcCOACode = J.vcCOAJournal');

		if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
			$tgl_dari = $_REQUEST['tgl_dari'];
			$tgl_samp = $_REQUEST['tgl_samp'];

			$tgl_dari_before = (date('Y', strtotime($tgl_dari)) - 1) . '-' . date('m-d', strtotime($tgl_dari));
			$tgl_samp_before = (date('Y', strtotime($tgl_samp)) - 1) . '-' . date('m-d', strtotime($tgl_samp));

			if ($_REQUEST['level'] != '') {
				$level = $_REQUEST['level'];
				$this->db->where('C.itCOALevel = ', '' . $level . '');
			}
		} else {
			$tgl_dari = date('Y') . '-01-01';
			$tgl_samp = date('Y') . '-12-31';

			$tgl_dari_before = date('Y') - 1 . '-01-01';
			$tgl_samp_before = date('Y') - 1 . '-12-31';

			$level_min = '';
		}
		$this->db->where('DATE(J.dtJournal) >= ', '' . $tgl_dari_before . '');
		$this->db->where('DATE(J.dtJournal) <= ', '' . $tgl_samp_before . '');

		$this->db->where('vcCOAJournal', $id_akun);
		return $this->db->get();
	}
}
