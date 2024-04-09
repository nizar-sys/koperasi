<!-- Styler -->
<style type="text/css">
td, div {
	font-family: "Arial","​Helvetica","​sans-serif";
}
.datagrid-header-row * {
	font-weight: bold;
}
.messager-window * a:focus, .messager-window * span:focus {
	color: blue;
	font-weight: bold;
}
.daterangepicker * {
	font-family: "Source Sans Pro","Arial","​Helvetica","​sans-serif";
	box-sizing: border-box;
}
.glyphicon	{font-family: "Glyphicons Halflings"}
</style>
<!-- <?php
$start_date    = new DateTime($data_tagihan->start_date);
$end_date      = new DateTime($data_tagihan->end_date);
$masa_aktif    = $start_date->diff($end_date);
?> -->

<!-- Data Grid -->
<?php
# buaat tanggal sekarang
$tanggal = date('Y-m-d H:i');
$tanggal_arr = explode(' ', $tanggal);
$txt_tanggal = jin_date_ina($tanggal_arr[0]);
$txt_tanggal .= ' - ' . $tanggal_arr[1];

# ambil suku bunga
foreach ($suku_bunga as $row) {
	$bunga = $row->opsi_val;
}
# ambil biaya admin
foreach ($biaya as $row) {
	$biaya_adm = $row->opsi_val;
}

?>
<table   id="dg"
class="easyui-datagrid"
title="Data Pinjaman Anggota"
style="width:auto; height: auto;"
url="<?php echo site_url('pinjaman/ajax_list'); ?>"
pagination="true" rownumbers="true"
fitColumns="true" singleSelect="true" collapsible="true"
sortName="tgl_pinjam" sortOrder="DESC"
toolbar="#tb"
striped="true">
<thead>
	<tr>
		<th data-options="field:'id',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'id_txt', width:'17', halign:'center', align:'center'">No. Transaksi</th>
		<th data-options="field:'tgl_pinjam', halign:'center', align:'center'" hidden="true">Tanggal</th>
		<th data-options="field:'tgl_pinjam_txt', width:'25', halign:'center', align:'center'">Tanggal Pinjam</th>
		<th data-options="field:'anggota_id',halign:'center', align:'center'" hidden="true">ID</th>
		<th data-options="field:'anggota_id_txt', width:'35', halign:'center', align:'left'">Nama Anggota</th>
		<th data-options="field:'barang_id', width:'35', halign:'center', align:'left'"  hidden="true">Nama barang</th>
		<th data-options="field:'lama_angsuran',halign:'center', align:'center'" hidden="true">Lama</th>
		<th data-options="field:'bunga', halign:'center', align:'right'" hidden="true"> Jasa Pinjaman</th>
		<th data-options="field:'bunga_txt', halign:'center', align:'right'" hidden="true"> Jasa Pinjaman</th>
		<th data-options="field:'biaya_adm', halign:'center', align:'right'" hidden="true"> Biaya</th>
		<th data-options="field:'biaya_adm_txt', halign:'center', align:'right'" hidden="true"> Biaya</th>
		<th data-options="field:'jumlah', width:'15', halign:'center', align:'right'" hidden="true" >Pokok <br> Pinjaman</th>
		<th data-options="field:'lama_angsuran_txt', width:'13', halign:'center', align:'center'" hidden="true">Lama</th>
		<th data-options="field:'hitungan', width:'35', halign:'center', align:'center'">Hitungan</th>
		<th data-options="field:'tagihan', width:'35', halign:'center', align:'right'">Total <br> Tagihan</th>
		<th data-options="field:'lunas', width:'10', halign:'center', align:'center'">Lunas</th>
		<th data-options="field:'user', width:'15', halign:'center', align:'center'">User </th>
		<th data-options="field:'ket', width:'15', halign:'center', align:'left'" hidden="true">Keterangan</th>
		<th data-options="field:'kas_id', halign:'center', align:'right'" hidden="true"> Kas</th>
		<th data-options="field:'detail', halign:'center', align:'center'">Aksi</th>
	</tr>
</thead>
</table>

<!-- Toolbar -->
<div id="tb" style="height: 35px;">
	<div style="vertical-align: middle; display: inline; padding-top: 15px;">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="create()" title="Tambah"></a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="update()" title="Edit"></a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="hapus()" title="Hapus"></a>
	</div>
	<div class="pull-right" style="vertical-align: middle;">
		<div id="filter_tgl" class="input-group" style="display: inline;">
			<button class="btn btn-default" id="daterange-btn">
				<i class="fa fa-calendar"></i> <span id="reportrange"><span></span></span>
				<i class="fa fa-caret-down"></i>
			</button>
		</div>
		<select id="cari_status" name="cari_status" style="width:170px; height:27px" >
			<option value=""> -- Status Pinjaman --</option>
			<option value="Belum">Belum Lunas</option>
			<option value="Lunas">Sudah Lunas</option>
		</select>
		<span>Cari :</span>
		<input name="kode_transaksi" id="kode_transaksi" size="23" placeholder="Kode Transaksi" style="line-height:22px;border:1px solid #ccc">
		<input name="cari_nama" id="cari_nama" size="23" placeholder="Nama Anggota" style="line-height:22px;border:1px solid #ccc">

		<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()" title="Cari"></a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak_laporan()">Cetak Laporan</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak_laporan2()">Cetak</a>
		<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
	</div>
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" show= "blind" hide= "blind" modal="true" resizable="false" style="width:500px; height:600px; padding-left: 15px; padding-top:20px" closed="true" buttons="#dialog-buttons" style="display: none;">
	<form id="form" method="post" novalidate>
		<table>
			<tr>
				<td>
					<table>
						<tr style="height:40px">
							<td>Tanggal Pinjam</td>
							<td>:</td>
							<td>
								<div class="input-group date dtpicker col-md-5" style="z-index: 9999 !important;">
									<input type="text" name="tgl_pinjam_txt" id="tgl_pinjam_txt"  style=" background:#eee; width:155px; height:23px" required="true" readonly="readonly" />
									<input type="hidden" name="tgl_pinjam" id="tgl_pinjam" />
									<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								</div>
							</td>
						</tr>
						<tr style="height:40px">
							<td>Jenis Pinjaman</td>
							<td>:</td>
							<td>
								<select id="jenis_pinj" name="jenis_pinj" style="width:200px; height:23px" class="easyui-validatebox" required="true">
									<option value="0"> -- Pilih Jenis Pinjaman --</option>

									<?php
									foreach ($jenis_pinjaman as $jpinjam) {
										echo '<option value="'.$jpinjam->id.'">'.$jpinjam->jns_pinjam.'</option>';
									}
									?>
								</select>
							</td>
						</tr>

						<tr style="height:40px">
							<td>Nomor Pinjaman</td>
							<td>:</td>
							<td>
								<input class="" id="no_pinjam" name="no_pinjam" style="width:190px; height:20px; background-color:#eee;" readonly="readonly"/>
								<input type="hidden" id="kode_jenis_pinjam" name="kode_jenis_pinjam"/>
							</td>
						</tr>
						<tr style="height:40px">
							<td>Nama Anggota</td>
							<td>:</td>
							<td>
								<input id="anggota_id" name="anggota_id" style="width:195px; height:25px" class="easyui-validatebox" required="true" >
							</td>
						</tr>
						<tr style="height:40px">
							<td>Masa Kerja</td>
							<td>:</td>
							<td>
								<input id="masa_kerja" name="masa_kerja" style="width:40px; height:20px" readonly="readonly"> <b> Tahun</b>
							</td>
						</tr>
						<tr style="height:40px">
							<td>Nama Barang</td>
							<td>:</td>
							<td>
								<select id="barang_id" name="barang_id" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0"> -- Pilih Barang --</option>
									<?php
									foreach ($barang_id as $row) {
										echo '<option value="'.$row->id.'">'.$row->nm_barang.' Rp '.number_format($row->harga).'</option>';
									}
									?>
								</select>
							</td>
						</tr>
						<tr style="height:40px">
							<td>Harga Barang</td>
							<td>:</td>
							<td>
								<input class="" id="jumlah" name="jumlah" style="width:195px; height:25px; background-color:#eee;" readonly="true"  />
							</td>
						</tr>
						<tr style="height:40px">
							<td>Lama Angsuran</td>
							<td>:</td>
							<td>
								<select id="lama_angsuran" name="lama_angsuran" style="width:200px; height:23px" class="easyui-validatebox" required="true">
									<option> -- Pilih Angsuran --</option>
								</select>
								<input type="hidden" name="max_angsuran" id="max_angsuran">
							</td>
						</tr>
						<tr style="height:40px">
							<td>Bunga Pinjaman</td>
							<td>:</td>
							<td>
								<!-- <input type="hidden" name="bunga" id="bunga" readonly="readonly" />
									<input type="text" id="bunga_txt" name="bunga_txt" style="background:#eee; border-width:1; width:195px; height:23px" readonly="true" /> -->
									<input type="text" name="bunga" id="bunga" style="width:30px; height:20px" placeholder="1-100"> <b>%</b>&emsp;|&emsp;Rp
									<input type="text" name="total_bunga" id="total_bunga" style="width:95px; height:20px" placeholder="Nominal rupiah">
									<!-- <input type="text" name="bunga_txt" id="bunga_txt" style="width:130px; height:20px"> -->
								</td>
							</tr>
							<tr style="height:40px">
								<td>Biaya Admin</td>
								<td>:</td>
								<td>
								<!-- <input type="hidden" name="biaya_adm" id="biaya_adm" readonly="readonly" />
									<input type="text" id="biaya_adm_txt" name="biaya_adm_txt" style=" background:#eee; border-width:1; width:195px; height:23px" readonly="true" /> -->
									<input type="text" name="persen_admin" id="persen_admin" style="width:30px; height:20px" placeholder="1-100"> <b>%</b>&emsp;|&emsp;Rp
									<input type="text" name="biaya_adm" id="biaya_adm" style="width:95px; height:20px" placeholder="Nominal rupiah">
								</td>
							</tr>
							<tr style="height:40px">
								<td>Ambil Dari Kas</td>
								<td>:</td>
								<td>
									<select id="kas" name="kas_id" style="width:200px; height:23px" class="easyui-validatebox" required="true">
										<option value="0"> -- Pilih Kas --</option>
										<?php
										foreach ($kas_id as $row) {
											echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
							<tr style="height:40px">
								<td>Keterangan</td>
								<td>:</td>
								<td>
									<input id="ket" name="ket" style="width:190px; height:20px" >
								</td>
							</tr>
						</table>
					</td>
					<td width="10px"></td><td valign="top"> Photo : <br> <div id="anggota_poto" style="height:120px; width:90px; border:1px solid #ccc"> </div></td>
				</tr>
			</table>
		</form>
	</div>

	<!-- Dialog Button -->
	<div id="dialog-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">Simpan</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
	</div>

	<?php
	$tahun = date('Y-m');
	if($header_code->num_rows() == 0){
		$no_urut = 1;
	}else{
		$tahun_header = date('Y', strtotime($header_code->result()[0]->tgl_pinjam));
		$tahun_sekarang = date('Y');
		if($tahun_header == $tahun_sekarang){
			$array = explode("-",$header_code->result()[0]->no_pinjaman);
			$kode_sekarang = $array[3];
                            // substr($header_code->result()[0]->vcARHeaderCode,-1);
			$no_urut = (int)$kode_sekarang + 1;
		}else{
			$no_urut = 1;
		}
	}
	$nomor = '-'.$tahun.'-'.$no_urut;

	?>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#barang_id').change(function(){
				val_barang_id = $(this).val();
				$.ajax({
					url: '<?php echo site_url()?>pinjaman/get_jenis_barang',
					type: 'POST',
					dataType: 'html',
					data: {barang_id: val_barang_id},
				})
				.done(function(result) {
					$('#jumlah').val(result);
					if(result == '0') {
						$('#jumlah').removeAttr('readonly');
						$('#jumlah').css('background-color', '');
						$('#jumlah').focus().select();
					} else {
						$('#jumlah').attr('readonly', 'true');
						$('#jumlah').css('background-color', '#eee');
					}
				})
				.fail(function() {
					alert('Kesalahan Konekasi, silahkan ulangi beberapa saat lagi.');
				});

			});

			$(".dtpicker").datetimepicker({
				language:  'id',
				weekStart: 1,
				autoclose: true,
				todayBtn: true,
				todayHighlight: true,
				pickerPosition: 'bottom-right',
				format: "dd MM yyyy - hh:ii",
				linkField: "tgl_pinjam",
				linkFormat: "yyyy-mm-dd hh:ii"
			});

			$('#anggota_id').combogrid({
				panelWidth:400,
				url: '<?php echo site_url('pinjaman/list_anggota'); ?>',
				idField:'id',
				valueField:'id',
				textField:'nama',
				mode:'remote',
				fitColumns:true,
				columns:[[
				{field:'photo',title:'Photo',align:'center',width:5},
				{field:'id',title:'ID', hidden: true},
				{field:'kode_anggota', title:'ID', align:'center', width:15},
				{field:'nama',title:'Nama Anggota',align:'left',width:15}
				]],
				onSelect: function(record){
					$("#anggota_poto").html('<img src="<?php echo base_url();?>assets/theme_admin/img/loading.gif" />');
					var val_anggota_id = $('input[name=anggota_id]').val();
					$.ajax({
						url: '<?php echo site_url(); ?>simpanan/get_anggota_by_id/' + val_anggota_id,
						type: 'POST',
						dataType: 'html',
						data: {anggota_id: val_anggota_id},
					})
					.done(function(result) {
						$('#anggota_poto').html(result);
						if($('#id_anggota').val() != ''){
							var val_anggota_id = $('input[name=anggota_id]').val();
							$.ajax({
								method: "POST",
								url: '<?php echo site_url('pinjaman/get_anggota/');?>',
								data: {anggota_id: val_anggota_id},
								dataType: "json",  
								success: function(response){
						          	$.each(response,function(daftar,data){
						          		var start = new Date(data['masuk_kerja']);
							          	end   = new Date();
							          	var diff_date =  end - start;
							          	days  = diff_date/1000/60/60/24;
							          	var years = Math.floor(days/31536000000);
							          	var years = Math.floor(diff_date/31536000000);
						          		$('#masa_kerja').val(years);
						          		//get lama angsuran
						          		var masa_kerja = $('#masa_kerja').val();

						          		$.ajax({
						          			method		: 'POST',
						          			url 		: '<?php echo site_url('pinjaman/get_lama_angsuran')?>',
						          			data 		: {masa_kerja : masa_kerja},
						          			dataType	: 'json',
						          			success		: function(response){
						          				$.each(response, function(daftar, data){
						          					$('#max_angsuran').val((data['ket']));
						          					var n = $('#max_angsuran').val();
						          					$('#lama_angsuran').find('option').not(':first').remove();
						          					for (var i = 1; i <= n; i++) {
						          						$('#lama_angsuran').append('<option value="'+i+'">'+i+'</option>');
						          					}
						          				});
						          			}
						          		});
						          	});
						        }
						    });
						}else{
							return false;
						}
					})
					.fail(function() {
						alert('Koneksi error, silahkan ulangi.')
					});
				}
			});

			// $('#masa_kerja').change(function(){
			// 	var masa_kerja = $('#masa_kerja').val();
			// 	$.ajax({
			// 		method		: 'POST',
			// 		url 		: '<?php echo site_url('pinjaman/get_lama_angsuran')?>',
			// 		data 		: {masa_kerja : masa_kerja},
			// 		dataType	: 'json',
			// 		success		: function(response){
			// 			$.each(response, function(daftar, data){
			// 				alert(data['ket']);
			// 			});
			// 		}
			// 	});
			// });

			$('#jenis_pinj').change(function(){
				var id_jenis_pinjaman = $("#jenis_pinj option:selected").val();
				$.ajax({
					method: "POST",
					url: '<?php echo site_url('pinjaman/get_kode_jenis_pinjaman/');?>',
					data: {jenis_pinjaman: id_jenis_pinjaman},
					dataType: "json",  
					success: function(response){
						$.each(response,function(daftar,data){
							var jenis_pinjam = data['kode_jenis_pinjam'];
							var no_pinjam = "<?php echo $nomor?>";
							$('#kode_jenis_pinjam').val(data['kode_jenis_pinjam']);
							var kode_jenis_pinjam = $('#kode_jenis_pinjam').val();
							// //nomor pinjaman
							// alert(kode_jenis_pinjam);
							$('#no_pinjam').val(kode_jenis_pinjam + no_pinjam);
						});
					}
				});
			});


			$("#cari_status").change(function(){
				$('#dg').datagrid('load',{
					cari_status: $('#cari_status').val()
				});
			});

			$("#kode_transaksi").keyup(function(event){
				if(event.keyCode == 13){
					$("#btn_filter").click();
				}
			});

			$("#kode_transaksi").keyup(function(e){
				var isi = $(e.target).val();
				$(e.target).val(isi.toUpperCase());
			});

			fm_filter_tgl();

			$('#bunga').keyup(function() {
				var harga = $('#jumlah').val();
				var hargav = harga.replace(/,/g, "");
				$('#total_bunga').val((hargav*$(this).val())/100);
			});
			$('#total_bunga').keyup(function() {
				var harga = $('#jumlah').val();
				var hargav = harga.replace(/,/g, "");
				$('#bunga').val(($(this).val()*100)/hargav);
			});

			$('#persen_admin').keyup(function() {
				var harga = $('#jumlah').val();
				var hargav = harga.replace(/,/g, "");
				$('#biaya_adm').val((hargav*$(this).val())/100);
			});
			$('#biaya_adm').keyup(function() {
				var harga = $('#jumlah').val();
				var hargav = harga.replace(/,/g, "");
				$('#persen_admin').val(($(this).val()*100)/hargav);
			});

			$('#jumlah').keyup(function(){
				var persen = $('#persen_admin').val();
				var bunga = $('#bunga').val();
				var jumlah = $('#jumlah').val();
				var jumlahv = jumlah.replace(/,/g, "");

				var biaya = (persen * jumlahv) / 100;
				var tot_bunga = (bunga * jumlahv) / 100;

				$('#biaya_adm').val(biaya);
				$('#total_bunga').val(tot_bunga);
			});
}); //ready


		function fm_filter_tgl() {
			$('#daterange-btn').daterangepicker({
				ranges: {
					'Hari ini': [moment(), moment()],
					'Kemarin': [moment().subtract('days', 1), moment().subtract('days', 1)],
					'7 Hari yang lalu': [moment().subtract('days', 6), moment()],
					'30 Hari yang lalu': [moment().subtract('days', 29), moment()],
					'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
					'Bulan kemarin': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
					'Tahun ini': [moment().startOf('year').startOf('month'), moment().endOf('year').endOf('month')],
					'Tahun kemarin': [moment().subtract('year', 1).startOf('year').startOf('month'), moment().subtract('year', 1).endOf('year').endOf('month')]
				},
				showDropdowns: true,
				format: 'YYYY-MM-DD',
				startDate: moment().startOf('year').startOf('month'),
				endDate: moment().endOf('year').endOf('month')
			},
			function(start, end) {
				$('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
				doSearch();
			});
		}
	</script>

	<script type="text/javascript">
	var url;
	function create(){
		jQuery('#dialog-form').dialog('open').dialog('setTitle','Form Tambah Pinjaman');
		jQuery('#form').form('clear');
		$('#anggota_id ~ span span a').show();
		$('#anggota_id ~ span input').removeAttr('disabled');
		$('#anggota_id ~ span input').focus();

		$('#barang_id').attr('enable', true);
		$('#barang_id').removeAttr('disabled');
		$('#barang_id').css('background-color', '#fff');
		

		jQuery('#tgl_pinjam_txt').val('<?php echo $txt_tanggal;?>');
		jQuery('#tgl_pinjam').val('<?php echo $tanggal;?>');
		jQuery('#barang_id option[value="0"]').prop('selected', true);
		jQuery('#bunga').val('<?php echo $bunga;?>');
		jQuery('#bunga_txt').val('<?php echo $bunga .'%';?>');
		jQuery('#persen_admin').val('<?php echo $biaya_adm;?>');
		jQuery('#biaya_adm_txt').val('<?php echo number_format($biaya_adm);?>');
		jQuery('#kas option[value="0"]').prop('selected', true);
		jQuery('#lama_angsuran option[value="0"]').prop('selected', true);
		jQuery('#jenis_pinj option[value="0"]').prop('selected', true);
		$("#anggota_poto").html('');

		$('#jumlah').keyup(function(){
			var val_jumlah = $(this).val();
			//$('#jumlah').numberbox('setValue', number_format(val_jumlah));
			$('#jumlah').val(number_format(val_jumlah));
		});

		url = '<?php echo site_url('pinjaman/create'); ?>';
	}

	function save() {
		var string = $("#form").serialize();
	//validasi teks kosong
	var anggota_id = $("input[name=anggota_id]").val();
	if(anggota_id == '') {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Anggota belum dipilih. </div>',
			timeout:2000,
			showType:'slide'
		});
		$("#anggota_id").focus();
		return false;
	}
	var barang_id = $("#barang_id option:selected").val();
	if(barang_id == "0" || barang_id == "") {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Barang belum dipilih. </div>',
			timeout:2000,
			showType:'slide'
		});
		$("#barang_id").focus();
		return false;
	}
	var jumlah = $("#jumlah").val();
	if(jumlah <= 0 || jumlah == '') {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Jumlah harus diisi.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#barang_id").focus();
		return false;
	}

	var lama_angsuran = $("#lama_angsuran").val();
	if(lama_angsuran == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Lama Angsuran belum dipilih </div>',
			timeout:2000,
			showType:'slide'
		});
		$("#lama_angsuran").focus();
		return false;
	}

	var kas = $("#kas").val();
	if(kas == 0) {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan ! </div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Ambil dari Kas harus diisi.</div>',
			timeout:2000,
			showType:'slide'
		});
		$("#kas").focus();
		return false;
	}

	$.ajax({
		type	: "POST",
		url: url,
		data	: string,
		success	: function(result) {
			var result = eval('('+result+')');
			$.messager.show({
				title:'<div><i class="fa fa-info"></i> Informasi</div>',
				msg: result.msg,
				timeout:2000,
				showType:'slide'
			});
			if(result.ok) {
				jQuery('#dialog-form').dialog('close');
				$('#dg').datagrid('reload');
				location.reload();
			}
		}
	});
}

function update(){
	var row = jQuery('#dg').datagrid('getSelected');
	if(row){
		jQuery('#dialog-form').dialog('open').dialog('setTitle','Edit Data Pinjaman');
		jQuery('#form').form('load',row);

		$('#anggota_id ~ span input').attr('disabled', true);
		$('#anggota_id ~ span input').css('background-color', '#fff');
		$('#anggota_id ~ span span a').hide();

		$('#barang_id').attr('disabled', true);
		$('#barang_id').css('background-color', '#fff');

		url = '<?php echo site_url('pinjaman/update'); ?>/' + row.id;

	}else {
		$.messager.show({
			title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
			msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
			timeout:2000,
			showType:'slide'
		});		}
	}

	function hapus(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Konfirmasi','Apakah anda yakin akan menghapus data pinjaman <code>' + row.id_txt + '</code>  dan Seluruh data angsurannya?',function(r){
				if (r){
					$.ajax({
						type	: "POST",
						url		: "<?php echo site_url('pinjaman/delete'); ?>",
						data	: 'id='+row.id,
						success	: function(result){
							var result = eval('('+result+')');
							$.messager.show({
								title:'<div><i class="fa fa-info"></i> Informasi</div>',
								msg: result.msg,
								timeout:2000,
								showType:'slide'
							});
							if(result.ok) {
								$('#dg').datagrid('reload');
							}

						},
						error : function (){
							$.messager.show({
								title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
								msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Terjadi kesalahan koneksi, silahkan muat ulang !!</div>',
								timeout:2000,
								showType:'slide'
							});
						}
					});
				}
			});
		}  else {
			$.messager.show({
				title:'<div><i class="fa fa-warning"></i> Peringatan !</div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Data harus dipilih terlebih dahulu </div>',
				timeout:2000,
				showType:'slide'
			});
		}
		$('.messager-button a:last').focus();
	}


	function form_select_clear() {
		$('select option')
		.filter(function() {
			return !this.value || $.trim(this.value).length == 0;
		})
		.remove();
		$('select option')
		.first()
		.prop('selected', true);
	}

	function doSearch(){
		$('#dg').datagrid('load',{
			cari_status : $('#cari_status').val(),
			kode_transaksi: $('#kode_transaksi').val(),
			cari_nama: $('#cari_nama').val(),
			tgl_dari: 	$('input[name=daterangepicker_start]').val(),
			tgl_sampai: $('input[name=daterangepicker_end]').val()
		});
	}

	function clearSearch(){
		location.reload();
	}

	function cetak_laporan () {
		var cari_status	 	= $('#cari_status').val();
		var kode_transaksi 	= $('#kode_transaksi').val();
		var tgl_dari			= $('input[name=daterangepicker_start]').val();
		var tgl_sampai			= $('input[name=daterangepicker_end]').val();


		var win = window.open('<?php echo site_url("lap_pinjaman/cetak_laporan/?cari_status=' + cari_status + '&kode_transaksi=' + kode_transaksi + '&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
		if (win) {
			win.focus();
		} else {
			alert('Popup jangan di block');
		}
	}
	function cetak_laporan2 () {
		var cari_status	 	= $('#cari_status').val();
		var kode_transaksi 	= $('#kode_transaksi').val();
		var tgl_dari		= $('input[name=daterangepicker_start]').val();
		var tgl_sampai		= $('input[name=daterangepicker_end]').val();


		var win = window.open('<?php echo site_url("lap_pinjaman/cetak_laporan2/?cari_status=' + cari_status + '&kode_transaksi=' + kode_transaksi + '&tgl_dari=' + tgl_dari + '&tgl_sampai=' + tgl_sampai + '"); ?>');
		if (win) {
			win.focus();
		} else {
			alert('Popup jangan di block');
		}
	}
</script>