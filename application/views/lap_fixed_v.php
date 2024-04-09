
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/asset/css/bootstrap-datepicker.min.css">
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


<!-- Styler -->
<style type="text/css">
.panel * {
	font-family: "Arial","​Helvetica","​sans-serif";
}
.fa {
	font-family: "FontAwesome";
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

.form-control {
	height: 20px;
	padding: 4px;
}
</style>


<?php
	// buaat tanggal sekarang
	$tanggal = date('Y-m-d H:i');
	$tanggal_arr = explode(' ', $tanggal);
	$txt_tanggal = jin_date_ina($tanggal_arr[0]);
	$txt_tanggal .= ' - ' . $tanggal_arr[1];
?>


<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title"> Laporan Fixed Asset</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-primary btn-sm" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">
				<div id="filter_tgl" class="input-group" style="display: inline;">
					<button class="btn btn-default" id="daterange-btn" style="line-height:16px;border:1px solid #ccc">
						<i class="fa fa-calendar"></i> <span id="reportrange"><span> Tanggal</span></span>
						<i class="fa fa-caret-down"></i>
					</button>
				</div> &nbsp;
				<select id="" name="" style="width:170px; height:27px" >
					<option value=""> -- Tampilkan Akun --</option>
					<option value=""> -- Kas Besar --</option>
					<option value=""> -- Bank --</option>
					<option value=""> -- Piutang --</option>
				</select>  &nbsp; S/d  &nbsp;
				<select id="" name="" style="width:170px; height:27px" >
					<option value=""> -- Tampilkan Akun --</option>
					<option value=""> -- Kas Besar --</option>
					<option value=""> -- Bank --</option>
					<option value=""> -- Piutang --</option>
				</select>&nbsp;
				<select id="" name="" style="width:170px; height:27px" >
					<option value=""> -- No Fixed Assed --</option>
					<option value=""> -- 0000 --</option>
					<option value=""> -- 0000 --</option>
					<option value=""> -- 0000 --</option>
				</select>  &nbsp; S/d  &nbsp;
				<select id="" name="" style="width:170px; height:27px" >
					<option value=""> -- No Fixed Assed --</option>
					<option value=""> -- 0000  --</option>
					<option value=""> -- 0000 --</option>
					<option value=""> -- 0000 --</option>
				</select><br><br>


				<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Fixed Asset </p>
				<div style="padding: 25px;">
				  <table id="example" class="display nowrap" style="width:100%">
				        <thead>
				        	<tr>
				            <th >Akun</th>
				            <th >Tanggal</th>
				            <th >Nama Fixed Asset</th>
				            <th >Nilai</th>
				            <th >Depresi</th>
				          </tr>
				        </thead>
				        <tbody>
				        	<tr>
	                  <td>Akun</td>
		                <td>Tanggal</td>
	                  <td>Nama Fixed Asset</td>
	                  <td>Nilai</td>
	                  <td>Depresi</td>
				          </tr>
				        </tbody>
				    </table>
				</div>



			</div>
		</div>
	</div>
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
        $('#example').DataTable( {
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



<script type="text/javascript">
$(document).ready(function() {
	$('#jenis_id').change(function(){
		val_jenis_id = $(this).val();
		$.ajax({
			url: '<?php echo site_url()?>simpanan/get_jenis_simpanan',
			type: 'POST',
			dataType: 'html',
			data: {jenis_id: val_jenis_id},
		})
		.done(function(result) {
			$('#jumlah').numberbox('setValue', result);
			$('#jumlah ~ span input').focus();
			$('#jumlah ~ span input').select();
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
		linkField: "tgl_transaksi",
		linkFormat: "yyyy-mm-dd hh:ii"
	});

	$('#anggota_id').combogrid({
		panelWidth:400,
		url: '<?php echo site_url('simpanan/list_anggota'); ?>',
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
		// {field:'kota',title:'Kota',align:'left',width:10}
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
			})
			.fail(function() {
				alert('Koneksi error, silahkan ulangi.')
			});
		}
	});

	$("#cari_simpanan").change(function(){
		$('#dg').datagrid('load',{
			cari_simpanan: $('#cari_simpanan').val()
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
}); // ready

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
