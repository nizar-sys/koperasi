<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Simpanan extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('simpanan_m');
		$this->load->model('general_m');
	}	

	public function index() {
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Setoran Tunai';
		

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';

		#include daterange
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		//number_format
		$this->data['js_files'][] = base_url() . 'assets/extra/fungsi/number_format.js';

		$this->data['kas_id'] = $this->simpanan_m->get_data_kas();
		$this->data['jenis_id'] = $this->general_m->get_id_simpanan();

		$this->data['isi'] = $this->load->view('simpanan_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}

	function list_anggota() {
		$q = isset($_POST['q']) ? $_POST['q'] : '';
		$data   = $this->general_m->get_data_anggota_ajax($q);
		$i	= 0;
		$rows   = array(); 
		foreach ($data['data'] as $r) {
			if($r->file_pic == '') {
				$rows[$i]['photo'] = '<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="30" height="40" />';
			} else {
				$rows[$i]['photo'] = '<img src="'.base_url().'uploads/anggota/' . $r->file_pic . '" alt="Foto" width="30" height="40" />';
			}
			$rows[$i]['id'] = $r->id;
			$rows[$i]['kode_anggota'] = 'A-'.sprintf('%04d', $r->id) . '<br>' . $r->identitas;
			$rows[$i]['nama'] = $r->nama;
			// $rows[$i]['kota'] = $r->kota. '<br>' . $r->departement;		
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	function get_anggota_by_id() {
		$id = isset($_POST['anggota_id']) ? $_POST['anggota_id'] : '';
		$r   = $this->general_m->get_data_anggota($id);
		$out = '';
		$photo_w = 3 * 30;
		$photo_h = 4 * 30;
		if($r->file_pic == '') {
			$out =	'<input type="hidden" name="id_anggota" id="id_anggota" value="'.$r->id.'">
					<img src="'.base_url().'assets/theme_admin/img/photo.jpg" alt="default" width="'.$photo_w.'" height="'.$photo_h.'" />'.'<br> ID : '.'AG'.sprintf('%04d', $r->id).'';
		} else {
			$out = 	'<input type="hidden" name="id_anggota" id="id_anggota" value="'.$r->id.'">
					<img src="'.base_url().'uploads/anggota/' . $r->file_pic . '" alt="Foto" width="'.$photo_w.'" height="'.$photo_h.'" />'.'<br> ID : '.'AG'.sprintf('%04d', $r->id).'';
		}
		echo $out;
		exit();
	}

	function get_autocomplete(){
        if (isset($_GET['term'])) {
            $result = $this->simpanan_m->dataAnggota($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = $row->nama;
                echo json_encode($arr_result);
            }
        }
    }

	function ajax_list() {
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  = isset($_POST['sort']) ? $_POST['sort'] : 'tgl_transaksi';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$kode_transaksi = isset($_POST['kode_transaksi']) ? $_POST['kode_transaksi'] : '';
		$cari_simpanan = isset($_POST['cari_simpanan']) ? $_POST['cari_simpanan'] : '';
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_sampai = isset($_POST['tgl_sampai']) ? $_POST['tgl_sampai'] : '';
		$search = array('kode_transaksi' => $kode_transaksi, 
			'cari_simpanan' => $cari_simpanan,
			'tgl_dari' => $tgl_dari, 
			'tgl_sampai' => $tgl_sampai);
		$offset = ($offset-1)*$limit;
		$data   = $this->simpanan_m->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order);
		$i	= 0;
		$rows   = array(); 

		foreach ($data['data'] as $r) {
			$tgl_bayar = explode(' ', $r->tgl_transaksi);
			$txt_tanggal = jin_date_ina($tgl_bayar[0]);
			$txt_tanggal .= ' - ' . substr($tgl_bayar[1], 0, 5);		

			//array keys ini = attribute 'field' di view nya
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);  
			$nama_simpanan = $this->general_m->get_jns_simpanan($r->jenis_id);  
			

			$rows[$i]['id'] = $r->id;
			$rows[$i]['id_txt'] ='TRD' . sprintf('%05d', $r->id) . '';
			$rows[$i]['tgl_transaksi'] = $r->tgl_transaksi;
			$rows[$i]['tgl_transaksi_txt'] = $txt_tanggal;
			$rows[$i]['anggota_id'] = $r->anggota_id;
			$rows[$i]['anggota_id_txt'] = 'A-' . sprintf('%04d', $r->anggota_id);
			// $rows[$i]['anggota_id_txt'] = $anggota->identitas;
			$rows[$i]['nama'] = $anggota->nama;
			// $rows[$i]['departement'] = $anggota->departement;
			$rows[$i]['jenis_id'] = $r->jenis_id;
			$rows[$i]['jenis_id_txt'] =$nama_simpanan->jns_simpan;
			$rows[$i]['jumlah'] = number_format($r->jumlah);
			$rows[$i]['ket'] = $r->keterangan;
			$rows[$i]['user'] = $r->user_name;
			$rows[$i]['kas_id'] = $r->kas_id;
			$rows[$i]['nama_penyetor'] = $r->nama_penyetor;
			$rows[$i]['no_identitas'] = $r->no_identitas;
			$rows[$i]['alamat'] = $r->alamat;
			// if($r->itPostSp == 0){
				$rows[$i]['nota'] = '
			<a href="'.site_url('cetak_simpanan').'/cetak/' . $r->id . '"  title="Cetak Bukti Transaksi" target="_blank"> <i class="glyphicon glyphicon-print"></i> </a>
			<a href="'.site_url('simpanan/postingSetoranTunai').'/'. $r->id . '"  title="Posting" <i class="fa fa-share"></i> </a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="update()">Edit</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="hapus()">Hapus</a>';
			// }else{
			// 	$rows[$i]['nota'] = '
			// 	<a href="'.site_url('cetak_simpanan').'/cetak/' . $r->id . '"  title="Cetak Bukti Transaksi" target="_blank"> <i class="glyphicon glyphicon-print"></i> </a>
			// 	<a href="'.site_url('simpanan/unpostingSetoran').'/'. $r->id . '"  title="Posting" <i class="fa fa-reply"></i> </a>';		
			// }
			
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	public function postingSetoranTunai($id){
		$data = array(
			'itPostSp' => '1',
		);
		$dataSimpanan 	= $this->simpanan_m->getDataSimpananById($id)->row();
		$relSimpanan 		= $this->simpanan_m->getJenisSimpanan($dataSimpanan->jenis_id)->result();
		$relKas 		= $this->simpanan_m->getKasId($dataSimpanan->kas_id)->result();
		
		$this->db->trans_start();

		foreach ($relSimpanan as $item) {
			$item = array(
		
			// 'vcIDJournal' 		=> 'TRD-'. $dataSimpanan->id,
			'vcIDJournal' 		=> $dataSimpanan->id,
			'dtJournal'			=> $dataSimpanan->tgl_transaksi,
			'vcJournalDesc'		=> 'Setoran Tunai',
			'vcCOAJournal'		=> $item->vcCOACode,
			'cuJournalCredit' 	=> $dataSimpanan->jumlah,
			// 'cuJournalDebet'	=> $dataSimpanan->jumlah,
			'itPostJournal'		=> '1',
			'vcUserID'			=> 'admin',
		);
	};

	foreach ($relKas as $kas) {
		$kas = array(
			// 'vcIDJournal' 		=> 'TRD-'. $dataSimpanan->id,
			'vcIDJournal' 		=> $dataSimpanan->id,
			'dtJournal'			=> $dataSimpanan->tgl_transaksi,
			'vcJournalDesc'		=> 'Setoran Tunai',
			'vcCOAJournal'		=> $kas->vcCOACode,
			// 'cuJournalCredit' 	=> $dataSimpanan->jumlah,
			'cuJournalDebet'	=> $dataSimpanan->jumlah,
			'itPostJournal'		=> '1',
			'vcUserID'			=> 'admin',

		);
	};
		$this->db->insert('tbl_journal', $item);
		$this->db->insert('tbl_journal', $kas);
	
		// update tbl_arheader
		$this->simpanan_m->updateSimpananById($id, $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error','Mohon maaf data gagal diposting.');
			redirect_back();
			return FALSE;
		} else {
			$this->db->trans_complete();
			$this->session->set_flashdata('sukses','Selamat, Data berhasil diposting.');
			redirect_back();
			return TRUE;
		}
	}

	public function unpostingSetoran($id){
		$data = array(
			'itPostSp' => '0',
		);
		// ambil data by IDHeader
		$dataSimpanan 	= $this->simpanan_m->getDataSimpananById($id)->row();

		$this->db->trans_start();
		//delete tabel row ditabel jurnal
		$this->db->where('vcIDJournal', $dataSimpanan->id);
		$this->db->delete('tbl_journal');
		// update tabel tbl_arheader
		$this->simpanan_m->updateSimpananById($id, $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error','Mohon maaf data gagal diposting.');
			redirect_back();
			return FALSE;
		} else {
			$this->db->trans_complete();
			$this->session->set_flashdata('sukses','Selamat, Data berhasil diposting.');
			redirect_back();
			return TRUE;
		}
	}

	function get_jenis_simpanan() {
		$id = $this->input->post('jenis_id');
		$jenis_simpanan = $this->general_m->get_id_simpanan();
		foreach ($jenis_simpanan as $row) {
			if($row->id == $id) {
				echo number_format($row->jumlah);
			}
		}
		exit();
	}

	public function create() {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->simpanan_m->create()){
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil disimpan </div>'));
		}else
		{
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Gagal menyimpan data, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}
	}

	public function update($id=null) {
		if(!isset($_POST)) {
			show_404();
		}
		if($this->simpanan_m->update($id)) {
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil diubah </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i>  Maaf, Data gagal diubah, pastikan nilai lebih dari <strong>0 (NOL)</strong>. </div>'));
		}

	}
	public function delete() {
		if(!isset($_POST))	 {
			show_404();
		}
		$id = intval(addslashes($_POST['id']));
		if($this->simpanan_m->delete($id))
		{
			echo json_encode(array('ok' => true, 'msg' => '<div class="text-green"><i class="fa fa-check"></i> Data berhasil dihapus </div>'));
		} else {
			echo json_encode(array('ok' => false, 'msg' => '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data gagal dihapus </div>'));
		}
	}


	function cetak_laporan() {
		// $simpanan = $this->simpanan_m->lap_data_simpanan();
		// if($simpanan == FALSE) {
		// 	//redirect('simpanan');
		// 	echo 'DATA KOSONG<br>Pastikan Filter Tanggal dengan benar.';
		// 	exit();
		// }

		$tgl_dari = $_REQUEST['tgl_dari']; 
		$tgl_sampai = $_REQUEST['tgl_sampai']; 

		$this->load->library('Pdf');
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->set_nsi_header(TRUE);
		$pdf->AddPage('L');
		$html = '';
		$html .= '
		<style>
			.h_tengah {text-align: center;}
			.h_kiri {text-align: left;}
			.h_kanan {text-align: right;}
			.txt_judul {font-size: 12pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
			.txt_content {font-size: 10pt; font-style: arial;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">LAPORAN TRANSAKSI SIMPANAN/SETORAN TUNAI <br></span>
			<span> PERIODE : '.jin_date_ina($tgl_dari).' S/D '.jin_date_ina($tgl_sampai).'</span> ', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="3" border="1" border-collapse= "collapse">
		<tr class="header_kolom">
			<th class="h_tengah" style="width:5%;" > No. </th>
			<th class="h_tengah" style="width:8%;"> No Transaksi</th>
			<th class="h_tengah" style="width:18%;"> Tanggal </th>
			<th class="h_tengah" style="width:20%;"> No.Anggota+Nama </th>
			<th class="h_tengah" style="width:18%;"> Jenis Simpanan </th>
			<th class="h_tengah" style="width:15%;"> Jenis Kas </th>
			<th class="h_tengah" style="width:13%;"> Jumlah  </th>
		</tr>';

		$no =1;
		$jns_simpan_loop = $this->simpanan_m->get_jenis_simpan_pj()->result();
		$grand_total = 0;
		foreach ($jns_simpan_loop as $key => $simpanan) {
		$jml_simpanan[$key] = 0;
			if (!empty($this->simpanan_m->lap_data_simpanan($simpanan->id))) {
				// print_r($this->simpanan_m->lap_data_simpanan($simpanan->id));
				foreach ($this->simpanan_m->lap_data_simpanan($simpanan->id) as $row){
					$anggota= $this->simpanan_m->get_data_anggota($row->anggota_id);
					$jns_simpan= $this->simpanan_m->get_jenis_simpan($row->jenis_id);
					$jns_kas = $this->simpanan_m->get_data_kas_by_id($row->kas_id);

					$tgl_bayar = explode(' ', $row->tgl_transaksi);
					$txt_tanggal = jin_date_ina($tgl_bayar[0],'p');

					$jml_simpanan[$key] += $row->jumlah;
					$grand_total += $row->jumlah;

					// '.'AG'.sprintf('%04d', $row->anggota_id).'
					$html .= '
					<tr>
						<td class="h_tengah" >'.$no++.'</td>
						<td class="h_tengah"> '.'TRD'.sprintf('%04d', $row->id).'</td>
						<td class="h_tengah"> '.$txt_tanggal.'</td>
						<td class="h_kiri"> '.'A-'.sprintf('%03d', $anggota->id).' '.$anggota->nama.'</td>
						<td> '.$jns_simpan->jns_simpan.'</td>
						<td> '.$jns_kas->nama.'</td>
						<td class="h_kanan"> '.number_format($row->jumlah).'</td>
					</tr>';
				}
				$html .= '
				<tr>
					<td colspan="6" class="h_tengah"><strong> Jumlah </strong></td>
					<td class="h_kanan"> <strong>'.number_format($jml_simpanan[$key]).'</strong></td>
				</tr>';
			}
		}
		$html .= '
		<tr>
			<td colspan="6" class="h_tengah"><strong> Grand Total </strong></td>
			<td class="h_kanan"> <strong>'.number_format($grand_total).'</strong></td>
		</tr>';

		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('trans_sp'.date('Ymd_His') . '.pdf', 'I');
	} 
}