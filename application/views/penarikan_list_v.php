
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/asset/css/bootstrap-datepicker.min.css">
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<?php
	// buaat tanggal sekarang
	$tanggal = date('Y-m-d H:i');
	$tanggal_arr = explode(' ', $tanggal);
	$txt_tanggal = jin_date_ina($tanggal_arr[0]);
	$txt_tanggal .= ' - ' . $tanggal_arr[1];
?>

<!-- Data Grid -->

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah" >Tambah</button>
<div style="padding: 25px;">
    <?php
    $data=$this->session->flashdata('sukses');
    if($data!=""){
        ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Sukses! </h4>
            <?=$data;?>
        </div>
        <?php
    }
    ?>
    <?php
    $data2=$this->session->flashdata('error');
    if($data2!=""){
        ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Gagal! </h4>
            <?=$data2;?>
        </div>
        <?php
    }
    ?>


    <table id="example1" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th class="text-center">Kode Transaksi</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Id Anggota</th>
                <th class="text-center">Nama Anggota</th>
                <th class="text-center">Jenis Simpanan</th>
				<th class="text-center">Jumlah</th>
				<th class="text-center">User</th>
				<th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
			<?php
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
			$nama_simpanan = $this->general_m->get_jns_simpanan($r->jenis_id);   {
			}
		}
		?>
				
				
                <tr>
                    <td><?php echo "TRD00". $r->id ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"></td>
					<td class="text-center"> </td>
					<td class="text-center"> </td>
					<td class="text-center"> </td>
				</tr>
				
		</tbody>
	</table>
</div>

<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/vfs_fonts.js"  type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.html5.min.js"  type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.print.min.js"  type="text/javascript" ></script>

<script src="<?php echo base_url(); ?>assets/asset/javascript/bootstrap-datepicker.min.js"></script>




<script>
    $(document).ready(function() {
        $('#example1').DataTable( {
            "ordering" : false,
            dom: 'Bfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
  });

    $('#datepicker2').datepicker({
      autoclose: true
  });
</script>