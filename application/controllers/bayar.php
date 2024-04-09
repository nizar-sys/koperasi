<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bayar extends OperatorController {
	public function __construct() {
		parent::__construct();	
		$this->load->helper('fungsi');
		$this->load->model('bayar_m');
		$this->load->model('general_m');
		$this->load->model('pinjaman_m');
	}	

	public function index() {
		$this->data['judul_browser'] = 'Pinjaman';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Pembayaran Angsuran';

		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/default/easyui.css';
		$this->data['css_files'][] = base_url() . 'assets/easyui/themes/icon.css';
		$this->data['js_files'][] = base_url() . 'assets/easyui/jquery.easyui.min.js';
		//$this->data['js_files'][] = base_url() . 'assets/easyui/datagrid-detailview.js';

		#include tanggal
		$this->data['css_files'][] = base_url() . 'assets/extra/bootstrap_date_time/css/bootstrap-datetimepicker.min.css';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/bootstrap-datetimepicker.min.js';
		$this->data['js_files'][] = base_url() . 'assets/extra/bootstrap_date_time/js/locales/bootstrap-datetimepicker.id.js';
		#include seach
		$this->data['css_files'][] = base_url() . 'assets/theme_admin/css/daterangepicker/daterangepicker-bs3.css';
		$this->data['js_files'][] = base_url() . 'assets/theme_admin/js/plugins/daterangepicker/daterangepicker.js';

		$this->data['isi'] = $this->load->view('bayar_list_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}


	function ajax_list() {
		$this->load->model('bunga_m');
		/*Default request pager params dari jeasyUI*/
		$offset = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$limit  = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort  = isset($_POST['sort']) ? $_POST['sort'] : 'tgl_pinjam';
		$order  = isset($_POST['order']) ? $_POST['order'] : 'desc';
		$kode_transaksi = isset($_POST['kode_transaksi']) ? $_POST['kode_transaksi'] : '';
		$cari_nama = isset($_POST['cari_nama']) ? $_POST['cari_nama'] : '';
		$tgl_dari = isset($_POST['tgl_dari']) ? $_POST['tgl_dari'] : '';
		$tgl_sampai = isset($_POST['tgl_sampai']) ? $_POST['tgl_sampai'] : '';
		$search = array(
			'kode_transaksi' => $kode_transaksi, 
			'cari_nama' => $cari_nama, 
			'tgl_dari' => $tgl_dari, 
			'tgl_sampai' => $tgl_sampai
			);
		$offset = ($offset-1)*$limit;
		$data   = $this->bayar_m->get_data_transaksi_ajax($offset,$limit,$search,$sort,$order);
		$i	= 0;
		$rows   = array(); 

		$data_bunga_arr = $this->bunga_m->get_key_val();

		foreach ($data['data'] as $r) {
			$tgl_pinjam = explode(' ', $r->tgl_pinjam);
			$txt_tanggal = jin_date_ina($tgl_pinjam[0],'p');		

			$barang = $this->pinjaman_m->get_data_barang($r->barang_id);   

			//array keys ini = attribute 'field' di view nya
			$anggota = $this->general_m->get_data_anggota($r->anggota_id);   

			$rows[$i]['id'] = $r->id;
			$rows[$i]['id_txt'] ='TPJ' . sprintf('%05d', $r->id) . '';
			$rows[$i]['tgl_pinjam_txt'] = $txt_tanggal;
			// $rows[$i]['anggota_id'] ='A-' . sprintf('%04d', $r->anggota_id) . '';
			$rows[$i]['id_txt'] = sprintf('%03d', $r->id).'/'.$barang->kode.'/'.date('m',strtotime($r->tgl_pinjam)).'/'.date('y',strtotime($r->tgl_pinjam));
			// $rows[$i]['anggota_id'] = 'A-'.sprintf('%04d',$r->anggota_id).' <br>'.$anggota->identitas;
			// $rows[$i]['anggota_id'] = $anggota->identitas;
			$rows[$i]['anggota_id_txt'] = 'A-'.sprintf('%04d',$r->anggota_id).' - '.$anggota->nama;
			// $rows[$i]['anggota_id_txt'] = $anggota->nama;
			$rows[$i]['lama_angsuran_txt'] = $r->lama_angsuran.' Bulan';
			$rows[$i]['jumlah'] = number_format($r->jumlah);
			$rows[$i]['ags_pokok'] = number_format($r->pokok_angsuran);
			$rows[$i]['bunga'] = number_format($r->bunga_pinjaman);
			$rows[$i]['biaya_adm'] = number_format($r->biaya_adm);
			$rows[$i]['angsuran_bln'] = number_format(nsi_round($r->ags_per_bulan));
			// Jatuh Tempo
			$sdh_ags_ke = $r->bln_sudah_angsur;
			$ags_ke = $r->bln_sudah_angsur + 1;

			$denda_hari = $data_bunga_arr['denda_hari'];
			$tgl_pinjam = substr($r->tgl_pinjam, 0, 7) . '-01';
			$tgl_tempo = date('Y-m-d', strtotime("+".$ags_ke." months", strtotime($tgl_pinjam)));
			$tgl_tempo = substr($tgl_tempo, 0, 7) . '-' . sprintf("%02d", $denda_hari);
			$txt_status = '';
			$txt_status_tip = 'Ags Ke: ' . $ags_ke . ' Tempo: ' . $tgl_tempo;
			if($tgl_tempo < date('Y-m-d')) {
				$rows[$i]['merah'] = 1;
				$txt_status .= '<span title="'.$txt_status_tip.'" class="text-red"><i class="fa fa-warning"></i></span>';
			} else {
				$rows[$i]['merah'] = 0;
				$txt_status .= '<span title="'.$txt_status_tip.'" class="text-green"><i class="fa fa-check-circle" title="'.$txt_status_tip.'"></i></span>';
			}
			//$rows[$i]['status'] = $txt_status;

			$rows[$i]['bayar'] = '<br><p>'.$txt_status.' 
			<a href="'.site_url('angsuran').'/index/' . $r->id . '" title="Bayar Angsuran"> <i class="fa fa-money"></i> Bayar </a></p>';
			$i++;
		}
		//keys total & rows wajib bagi jEasyUI
		$result = array('total'=>$data['count'],'rows'=>$rows);
		echo json_encode($result); //return nya json
	}

	function cetak_laporan() {
		$data_pinjam = $this->pinjaman_m->lap_data_pinjaman();
		if($data_pinjam == FALSE) {
			echo 'DATA KOSONG<br>Pastikan Filter Tanggal dengan benar.';
			exit();
		}

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
			.txt_judul {font-size: 15pt; font-weight: bold; padding-bottom: 12px;}
			.header_kolom {background-color: #cccccc; text-align: center; font-weight: bold;}
		</style>
		'.$pdf->nsi_box($text = '<span class="txt_judul">Laporan Transaksi Data Bayar Pinjaman <br></span> <span> Periode '.jin_date_ina($tgl_dari).' - '.jin_date_ina($tgl_sampai).'</span> ', $width = '100%', $spacing = '0', $padding = '1', $border = '0', $align = 'center').'
		<table width="100%" cellspacing="0" cellpadding="3" border="1" nobr="true">
			<tr class="header_kolom">
				<th style="width:5%;" >No</th>
				<th style="width:10%;">No. Transaksi</th>
				<th style="width:11%;">Tanggal</th>
				<th style="width:15%;">No. Anggota + Nama</th>
				<th style="width:9%;">Jenis Pinjaman</th>
				<th style="width:10%;">Jenis Kas</th>
				<th style="width:10%;">Angsuran</th>
				<th style="width:10%;">Biaya Admin</th>
				<th style="width:10%;">Jasa Pinjaman</th>
				<th style="width:10%;">Jumlah Pinjaman</th>
			</tr>';

		$no =1;
		$jns_pinjaman_loop = $this->pinjaman_m->get_jenis_pinjaman_pj()->result();
		$grand_total = 0;
		$grand_total_adm = 0;
		$grand_total_bunga = 0;
		$grand_total_angs = 0;
		foreach ($jns_pinjaman_loop as $key => $pinjaman){
		$jml_pinjaman[$key] = 0;
		$jml_biaya_adm[$key] = 0;
		$jml_bunga[$key] = 0;
		$jml_angs[$key] = 0;
			if (!empty($this->pinjaman_m->lap_data_pinjaman_by_id($pinjaman->id))) {
				// print_r($this->pinjaman_m->lap_data_pinjaman($pinjaman->id));
				foreach ($this->pinjaman_m->lap_data_pinjaman_by_id($pinjaman->id) as $row){
					$anggota = $this->general_m->get_data_anggota($row->anggota_id);
					// $anggota = $this->pinjaman_m->get_data_anggota($row->anggota_id);
					$barang = $this->pinjaman_m->get_data_barang($row->barang_id);
					// $jns_simpan= $this->pinjaman_m->get_jenis_simpan($row->jenis_id);
					$nama_kas = $this->general_m->get_nama_kas($row->kas_id)->nama;
					// $jns_kas = $this->pinjaman_m->get_data_kas_by_id($row->kas_id);

					//tanggal
					$tgl_bayar = explode(' ', $row->tgl_pinjam);
					$txt_tanggal = jin_date_ina($tgl_bayar[0],'p');
					$txt_tanggal .= ' - ' . substr($tgl_bayar[1], 0, 5);	

					// no Transaksi
					$no_transaksi = sprintf('%03d', $row->id).'/'.$barang->kode.'/'.date('m',strtotime($row->tgl_pinjam)).'/'.date('y', strtotime($row->tgl_pinjam));
					// no anggota
					$no_anggota = 'A-'.sprintf('%04d',$row->anggota_id).' <br>'.$anggota->nama;

					// jenis pinjaman
					$jenis_pinjaman = $barang->nm_barang;


					$jml_pinjaman[$key] += $row->jumlah;
					$jml_biaya_adm[$key] += $row->biaya_adm;
					$jml_bunga[$key] += $row->bunga_pinjaman;
					$jml_angs[$key] += $row->pokok_angsuran;

					$grand_total += $row->jumlah;
					$grand_total_adm += $row->biaya_adm;
					$grand_total_bunga += $row->bunga_pinjaman;
					$grand_total_angs += $row->pokok_angsuran;

					// '.'AG'.sprintf('%04d', $row->anggota_id).'
					$html .= '
					<tr>
						<td align="center">'.$no++.'</td>
						<td align="center">'.$no_transaksi.'</td>
						<td align="center">'.$txt_tanggal.'</td>
						<td align="center">'.$no_anggota.'</td>
						<td align="center">'.$jenis_pinjaman.'</td>
						<td align="center">'.$nama_kas.'</td>
						<td align="right">'.number_format($row->pokok_angsuran).'</td>
						<td align="right">'.number_format($row->biaya_adm).'</td>
						<td align="right">'.number_format($row->bunga_pinjaman).'</td>
						<td align="right">'.number_format($row->jumlah).'</td>
					</tr>';
				}
				$html .= '
				<tr>
					<td colspan="6" class="h_tengah"><strong> Jumlah </strong></td>
					<td class="h_kanan"> <strong>'.number_format($jml_angs[$key]).'</strong></td>
					<td class="h_kanan"> <strong>'.number_format($jml_biaya_adm[$key]).'</strong></td>
					<td class="h_kanan"> <strong>'.number_format($jml_bunga[$key]).'</strong></td>
					<td class="h_kanan"> <strong>'.number_format($jml_pinjaman[$key]).'</strong></td>
				</tr>';
			}
		}
		$html .= '
		<tr>
			<td colspan="6" class="h_tengah"><strong> Grand Total </strong></td>
			<td class="h_kanan"> <strong>'.number_format($grand_total_angs).'</strong></td>
			<td class="h_kanan"> <strong>'.number_format($grand_total_adm).'</strong></td>
			<td class="h_kanan"> <strong>'.number_format($grand_total_bunga).'</strong></td>
			<td class="h_kanan"> <strong>'.number_format($grand_total).'</strong></td>
		</tr>';
		$html .= '</table>';
		$pdf->nsi_html($html);
		$pdf->Output('pinjam'.date('Ymd_His') . '.pdf', 'I');
	} 
}
