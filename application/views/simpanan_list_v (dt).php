<link rel="stylesheet" href="<?php echo base_url(); ?>assets/asset/css/bootstrap-datepicker.min.css">
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet"
	type="text/css" />
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet"
	type="text/css" />

<?php
	// buaat tanggal sekarang
	$tanggal = date('Y-m-d H:i');
	$tanggal_arr = explode(' ', $tanggal);
	$txt_tanggal = jin_date_ina($tanggal_arr[0]);
	$txt_tanggal .= ' - ' . $tanggal_arr[1];
?>

<!-- Data Grid -->

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah">Tambah</button>
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
			$nama_simpanan = $this->general_m->get_jns_simpanan($r->jenis_id);
			$i	= 0;
		// print_r($r)
		// 		?>


			<tr>
				<td class="text-center"><?php echo "TRD00". $r->id ?></td>
				<td class="text-center"><?php echo $r->tgl_transaksi?></td>
				<td class="text-center"><?php echo "A-00". $r->id ?></td>
				<td class="text-center"><?php echo $anggota->nama?></td>
				<td class="text-center"><?php echo $nama_simpanan->jns_simpan?></td>
				<td class="text-right"><?php echo "Rp. " .number_format($r->jumlah)?> </td>
				<td class="text-center"><?php echo $r->user_name?> </td>
				<td class="text-center">
					<a title="Print" href="<?php echo site_url('cetak_simpanan').'/cetak/'.$r->id?>"
						class="btn-sm btn-primary" role="button"><i class="fa fa-print" aria-hidden="true"></i></a>
					<?php
                        if($r->itPostSp == 0){
                            ?>
					<a title="Posting" href="<?php echo site_url('simpanan/postingSetoranTunai').'/'.$r->id;?>"
						class="btn-sm btn-success"><i class="fa fa-share" aria-hidden="true"></i></a>
					<a title="Edit" href="javascript:void(0)" class="btn-sm btn-warning" onclick="update()"><i
							class="fa fa-pencil" aria-hidden="true"></i></a>
					<a title="Hapus" href="<?php echo site_url('kas_masuk/delete_ar_header/').'/'.$r->id;?>"
						class="btn-sm btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i
							class="fa fa-trash-o"></i></a>
					<?php
                        }else{
                            ?>
					<a title="Unposting" href="<?php echo site_url('simpanan/unpostingSetoranTunai').'/'.$r->id;?>"
						class="btn-sm btn-secondary"><i class="fa fa-reply" aria-hidden="true"></i></a>
					<a title="Edit" href="#" class="btn-sm btn-warning" disabled><i class="fa fa-pencil"></i></a>
					<a title="Hapus" href="#" class="btn-sm btn-danger" disabled><i class="fa fa-trash-o"></i></a>
					<?php
                        }
                        ?>
				</td>
			</tr>
			<?php
      }
      ?>
		</tbody>
	</table>
</div>

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambah Setoran Tunai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="<?php echo site_url('simpanan/insert_ar_header')?>" method="post">
				<div class="modal-body">
					<?php
                    $tahun = date('Y-m');
					?>
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Tanggal Transaksi</label>
						<input type="text" class="form-control" id="datepicker2" name="dtARDate" style="height: 20%;"
							required="required">
					</div>
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Nama Anggota</label>
						<input type="text" class="form-control" id="anggota" name="anggota"
							style="height: 20%;" value=""
							required="required">
					</div>

					<div class="form-group">
						<input type="hidden" name="vcUserID" value="<?php echo $u_name?>" required="required">
					</div>

					<div class="form-group">
						<input type="hidden" name="cuRateValue" value="<?php echo $curr_def->cuRateValue?>"
							required="required">
					</div>



					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Akun</label><br>
						<select type="text" class="form-control" style="width: 97%;" name="vcCOACode" id="vcCOACode"
							required="required">
							<option value="">----- Pilih Akun -----</option>
							<?php
                            foreach ($akun as $ak) {
                                if($ak->itCOACashBank == 1){
                                    ?>
							<option value="<?php echo $ak->vcCOACode?>"><?php echo $ak->vcCOAName?></option>
							<?php
                                }
                            }
                            ?>
						</select>
					</div>
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Mata Uang</label><br>
						<select type="text" class="form-control" style="width: 97%;" name="vcCurrCode" id="vcCurrCode"
							required="required">
							<option value="">-----Pilih Mata Uang-----</option>
							<?php
                            foreach ($mata_uang as $mata) {
                                ?>
							<option value="<?php echo $mata->vcCurrCode?>"><?php echo $mata->vcCurrName?></option>
							<?php
                            }
                            ?>
						</select>
					</div>
					<div class="form-group">
						<label for="message-text" class="col-form-label">Keterangan</label>
						<textarea class="form-control" id="vcARHeaderDesc" name="vcARHeaderDesc" required="required"
							maxlength="30"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<input type="submit" name="submit" class="btn btn-danger" value="Simpan">
				</div>
			</form>
		</div>
	</div>
</div>


<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/jquery.dataTables.min.js"
	type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/dataTables.buttons.min.js"
	type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.flash.min.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/jszip.min.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/pdfmake.min.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/vfs_fonts.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.html5.min.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.print.min.js" type="text/javascript">
</script>

<script src="<?php echo base_url(); ?>assets/asset/javascript/bootstrap-datepicker.min.js"></script>




<script>
	$(document).ready(function () {
		$('#example1').DataTable({
			"ordering": false,
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		});
	});

	//Date picker
	$('#datepicker').datepicker({
		autoclose: true
	});

	$('#datepicker2').datepicker({
		autoclose: true
	});
</script>
<script type="text/javascript">
        $(document).ready(function(){
            $( "#anggota" ).autocomplete({
              source: "<?php echo site_url('simpanan/get_autocomplete'); ?>"
            });
        });
</script>

<script type="text/javascript">
	$(document).ready(function () {
		$('#jenis_id').change(function () {
			val_jenis_id = $(this).val();
			$.ajax({
					url: '<?php echo site_url()?>simpanan/get_jenis_simpanan',
					type: 'POST',
					dataType: 'html',
					data: {
						jenis_id: val_jenis_id
					},
				})
				.done(function (result) {
					$('#jumlah').numberbox('setValue', result);
					$('#jumlah ~ span input').focus();
					$('#jumlah ~ span input').select();
				})
				.fail(function () {
					alert('Kesalahan Konekasi, silahkan ulangi beberapa saat lagi.');
				});
		});

		$(".dtpicker").datetimepicker({
			language: 'id',
			weekStart: 1,
			autoclose: true,
			todayBtn: true,
			todayHighlight: true,
			pickerPosition: 'bottom-right',
			format: "dd MM yyyy - hh:ii",
			linkField: "tgl_transaksi",
			linkFormat: "yyyy-mm-dd hh:ii"
		});

		
		$("#cari_simpanan").change(function () {
			$('#dg').datagrid('load', {
				cari_simpanan: $('#cari_simpanan').val()
			});
		});

		$("#kode_transaksi").keyup(function (event) {
			if (event.keyCode == 13) {
				$("#btn_filter").click();
			}
		});

		$("#kode_transaksi").keyup(function (e) {
			var isi = $(e.target).val();
			$(e.target).val(isi.toUpperCase());
		});

		fm_filter_tgl();
	}); // ready

	function fm_filter_tgl() {
		$('#daterange-btn').daterangepicker({
				ranges: {
					'Hari ini': [moment(), moment()],
					'Kemarin': [moment().subtract('days', 1), moment().subtract('days', 1)],
					'7 Hari yang lalu': [moment().subtract('days', 6), moment()],
					'30 Hari yang lalu': [moment().subtract('days', 29), moment()],
					'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
					'Bulan kemarin': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1)
						.endOf('month')
					],
					'Tahun ini': [moment().startOf('year').startOf('month'), moment().endOf('year').endOf('month')],
					'Tahun kemarin': [moment().subtract('year', 1).startOf('year').startOf('month'), moment().subtract(
						'year', 1).endOf('year').endOf('month')]
				},
				showDropdowns: true,
				format: 'YYYY-MM-DD',
				startDate: moment().startOf('year').startOf('month'),
				endDate: moment().endOf('year').endOf('month')
			},

			function (start, end) {
				$('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
				doSearch();
			});
	}
</script>

<script type="text/javascript">
	var url;

	function form_select_clear() {
		$('select option')
			.filter(function () {
				return !this.value || $.trim(this.value).length == 0;
			})
			.remove();
		$('select option')
			.first()
			.prop('selected', true);
	}

	function doSearch() {
		$('#dg').datagrid('load', {
			cari_simpanan: $('#cari_simpanan').val(),
			kode_transaksi: $('#kode_transaksi').val(),
			tgl_dari: $('input[name=daterangepicker_start]').val(),
			tgl_sampai: $('input[name=daterangepicker_end]').val()
		});
	}

	function clearSearch() {
		location.reload();
	}

	function create() {
		$('#dialog-form').dialog('open').dialog('setTitle', 'Tambah Data');
		$('#form').form('clear');
		$('#anggota_id ~ span span a').show();
		$('#anggota_id ~ span input').removeAttr('disabled');
		$('#anggota_id ~ span input').focus();

		$('#tgl_transaksi_txt').val('<?php echo $txt_tanggal;?>');
		$('#tgl_transaksi').val('<?php echo $tanggal;?>');
		$('#kas option[value="0"]').prop('selected', true);
		$('#jenis_id option[value="0"]').prop('selected', true);
		$("#anggota_poto").html('');
		$('#jumlah ~ span input').keyup(function () {
			var val_jumlah = $(this).val();
			$('#jumlah').numberbox('setValue', number_format(val_jumlah));
		});

		url = '<?php echo site_url('
		simpanan / create '); ?>';
	}

	function save() {
		var string = $("#form").serialize();
		//validasi teks kosong
		var jenis_id = $("#jenis_id").val();
		if (jenis_id == 0) {
			$.messager.show({
				title: '<div><i class="fa fa-warning"></i> Peringatan ! </div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Jenis Simpanan belum dipilih.</div>',
				timeout: 2000,
				showType: 'slide'
			});
			$("#jenis_id").focus();
			return false;
		}

		var kas = $("#kas").val();
		if (kas == 0) {
			$.messager.show({
				title: '<div><i class="fa fa-warning"></i> Peringatan ! </div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Simpan Ke Kas belum dipilih.</div>',
				timeout: 2000,
				showType: 'slide'
			});
			$("#kas").focus();
			return false;
		}

		var isValid = $('#form').form('validate');
		if (isValid) {
			$.ajax({
				type: "POST",
				url: url,
				data: string,
				success: function (result) {
					var result = eval('(' + result + ')');
					$.messager.show({
						title: '<div><i class="fa fa-info"></i> Informasi</div>',
						msg: result.msg,
						timeout: 2000,
						showType: 'slide'
					});
					if (result.ok) {
						jQuery('#dialog-form').dialog('close');
						//clearSearch();
						$('#dg').datagrid('reload');
					}
				}
			});
		} else {
			$.messager.show({
				title: '<div><i class="fa fa-info"></i> Informasi</div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Lengkapi seluruh pengisian data.</div>',
				timeout: 2000,
				showType: 'slide'
			});
		}
	}

	function update() {
		var row = jQuery('#dg').datagrid('getSelected');
		if (row) {
			jQuery('#dialog-form').dialog('open').dialog('setTitle', 'Edit Data Setoran');
			jQuery('#form').form('load', row);
			$('#anggota_id ~ span input').attr('disabled', true);
			$('#anggota_id ~ span input').css('background-color', '#fff');
			$('#anggota_id ~ span span a').hide();
			url = '<?php echo site_url('
			simpanan / update '); ?>/' + row.id;
			$('#jumlah ~ span input').keyup(function () {
				var val_jumlah = $(this).val();
				$('#jumlah').numberbox('setValue', number_format(val_jumlah));
			});

		} else {
			$.messager.show({
				title: '<div><i class="fa fa-warning"></i> Peringatan !</div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
				timeout: 2000,
				showType: 'slide'
			});
		}
	}

	function hapus() {
		var row = $('#dg').datagrid('getSelected');
		if (row) {
			$.messager.confirm('Konfirmasi', 'Apakah Anda akan menghapus data kode transaksi : <code>' + row.id_txt +
				'</code> ?',
				function (r) {
					if (r) {
						$.ajax({
							type: "POST",
							url: "<?php echo site_url('simpanan/delete'); ?>",
							data: 'id=' + row.id,
							success: function (result) {
								var result = eval('(' + result + ')');
								$.messager.show({
									title: '<div><i class="fa fa-info"></i> Informasi</div>',
									msg: result.msg,
									timeout: 2000,
									showType: 'slide'
								});
								if (result.ok) {
									$('#dg').datagrid('reload');
								}
							},
							error: function () {
								$.messager.show({
									title: '<div><i class="fa fa-warning"></i> Peringatan !</div>',
									msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Terjadi kesalahan koneksi, silahkan muat ulang !</div>',
									timeout: 2000,
									showType: 'slide'
								});
							}
						});
					}
				});
		} else {
			$.messager.show({
				title: '<div><i class="fa fa-warning"></i> Peringatan !</div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
				timeout: 2000,
				showType: 'slide'
			});
		}
		$('.messager-button a:last').focus();
	}

	function cetak() {
		var cari_simpanan = $('#cari_simpanan').val();
		var kode_transaksi = $('#kode_transaksi').val();
		var tgl_dari = $('input[name=daterangepicker_start]').val();
		var tgl_sampai = $('input[name=daterangepicker_end]').val();

		var win = window.open('<?php echo site_url("simpanan/cetak_laporan/?cari_simpanan=' + cari_simpanan +
			'&kode_transaksi=' + kode_transaksi + '&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
		if (win) {
			win.focus();
		} else {
			alert('Popup jangan di block');
		}
	}
</script>