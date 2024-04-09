<link rel="stylesheet" href="<?php echo base_url(); ?>assets/asset/css/bootstrap-datepicker.min.css">
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


<!-- Styler -->
<style type="text/css">
	.panel * {
		font-family: "Arial", "​Helvetica", "​sans-serif";
	}

	.fa {
		font-family: "FontAwesome";
	}

	.datagrid-header-row * {
		font-weight: bold;
	}

	.messager-window * a:focus,
	.messager-window * span:focus {
		color: blue;
		font-weight: bold;
	}

	.daterangepicker * {
		font-family: "Source Sans Pro", "Arial", "​Helvetica", "​sans-serif";
		box-sizing: border-box;
	}

	.glyphicon {
		font-family: "Glyphicons Halflings"
	}

	.form-control {
		height: 20px;
		padding: 4px;
	}
</style>

<?php
if (isset($_REQUEST['tgl_dari']) && isset($_REQUEST['tgl_samp'])) {
	$tgl_dari = $_REQUEST['tgl_dari'];
	$tgl_samp = $_REQUEST['tgl_samp'];

	$tgl_dari_next = (date('Y', strtotime($tgl_dari)) - 1) . '-' . date('m-d', strtotime($tgl_dari));
	$tgl_samp_next = (date('Y', strtotime($tgl_samp)) - 1) . '-' . date('m-d', strtotime($tgl_samp));

	$level = $_REQUEST['level'];
} else {
	$tgl_dari = date('Y') . '-01-01';
	$tgl_samp = date('Y') . '-12-31';

	$tgl_dari_next = date('Y') - 1 . '-01-01';
	$tgl_samp_next = date('Y') - 1 . '-12-31';

	$level = '';
}

$tgl_dari_txt = jin_date_ina($tgl_dari, 'p');
$tgl_samp_txt = jin_date_ina($tgl_samp, 'p');

$tgl_dari_next_txt = jin_date_ina($tgl_dari_next, 'p');
$tgl_samp_next_txt = jin_date_ina($tgl_samp_next, 'p');

$tgl_periode_txt = $tgl_dari_txt . ' - ' . $tgl_samp_txt;
?>


<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title"> Laporan Balance Sheet </h3>
				<div class="box-tools pull-right">
					<button class="btn btn-primary btn-sm" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="box-body">

				<input type="hidden" name="lev" id="lev" value="<?php echo $level ?>">

				<form id="fmCari" method="GET">
					<input type="hidden" name="tgl_dari" id="tgl_dari" value="<?php $tgl_dari ?>">
					<input type="hidden" name="tgl_samp" id="tgl_samp" value="<?php $tgl_samp ?>">

					<table>
						<tr>
							<td>
								<div id="filter_tgl" class="input-group" style="display: inline;">
									<button class="btn btn-default" id="daterange-btn">
										<i class="fa fa-calendar"></i> <span id="reportrange"><span><?php echo $tgl_periode_txt; ?></span></span>
										<i class="fa fa-caret-down"></i>
									</button>
								</div>
							</td>
							<td>
								<!-- <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a> -->
								&nbsp;<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
							</td>
							<td>
								&nbsp;<select id="level" name="level" style="width:170px; height:27px">
									<option value="">--Pilih level--</option>
									<option value="0">--Level 0--</option>
									<option value="1">--Level 1--</option>
									<option value="2">--Level 2--</option>
									<option value="3">--Level 3--</option>
								</select>
							</td>
						</tr>
					</table>
				</form><br>
				<p style="text-align:center; font-size: 15pt; font-weight: bold;"> Laporan Balance Sheet </p>
			</div>
			<div style="padding: 25px;">
				<table id="example" border="" class="display nowrap" style="width:100%">
					<thead>
						<tr>
							<th class="text-center" width=10%>Kode Akun</th>
							<th class="text-center" width=30%>Nama Akun</th>
							<th class="text-center" width=20%><?= $tgl_dari_next_txt . ' - ' . $tgl_samp_next_txt ?></th>
							<th class="text-center" width=20%><?= $tgl_dari_txt . ' - ' . $tgl_samp_txt ?></th>
							<th class="text-center" width=20%>Changed</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$total_before = 0;
						$total = 0;
						$total_hasil = 0;
						foreach ($akun_balance as $key => $ak) {
							$data_before = $jurnal_umum_m->get_data_balance_before_by_id($ak->vcCOACode)->result();
							$debit_before = 0;
							$credit_before = 0;
							$hasil_before = 0;
							foreach ($data_before as $dat_bef) {
								$debit_before += $dat_bef->cuJournalDebet;
								$credit_before += $dat_bef->cuJournalCredit;
							}
							$hasil_before = $debit_before - $credit_before;

							$data = $jurnal_umum_m->get_data_balance_by_id($ak->vcCOACode)->result();
							$debit = 0;
							$credit = 0;
							$hasil = 0;
							foreach ($data as $bal) {
								$debit += $bal->cuJournalDebet;
								$credit += $bal->cuJournalCredit;
							}
							$hasil = $debit - $credit;
							?>
							<tr>
								<td class="text-center">
									<?php echo $ak->vcCOACode ?>
								</td>
								<td class="text-left">
									<?php
									for ($i = 0; $i <= $ak->itCOALevel; $i++) {
										echo "&emsp;&emsp;";
									}
									if ($ak->itCOALevel == '0') {
										echo '<b>' . $ak->vcCOAName . '</b>';
									} else {
										echo $ak->vcCOAName;
									}
									?>
								</td>
								<td class="text-right">
									<?php
									if ($hasil_before != 0) {
										echo "Rp" . number_format($hasil_before, 2, ',', '.');
									} else {
										echo '-';
									}
									?>
								</td>
								<td class="text-right">
									<?php
									if ($hasil != 0) {
										echo "Rp" . number_format($hasil, 2, ',', '.');
									} else {
										echo '-';
									}
									?>
								</td>
								<td class="text-right">
									<?php
									if ($hasil_before - $hasil != 0) {
										echo "Rp" . number_format($hasil_before - $hasil, 2, ',', '.');
									} else {
										echo '-';
									}
									?>
								</td>
							</tr>
							<?php
							$total_before += $hasil_before;
							$total += $hasil;
							$total_hasil += $hasil_before - $hasil;
						}
						?>
					</tbody>
					<tfoot>
						<td></td>
						<td class="text-center"><b>Total Jumlah</b></td>
						<td class="text-right"><b><?php echo "Rp" . number_format($total_before, 2, ',', '.'); ?></b></td>
						<td class="text-right"><b><?php echo "Rp" . number_format($total, 2, ',', '.'); ?></b></td>
						<td class="text-right"><b><?php echo "Rp" . number_format($total_hasil, 2, ',', '.'); ?></b></td>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/vfs_fonts.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.print.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/bootstrap-datepicker.min.js"></script>
<script>
	$(document).ready(function() {
		$('#example').DataTable({
			dom: 'Bfrtip',
			"aLengthMenu": [100],
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
	$(document).ready(function() {
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
		fm_filter_tgl();

		$('#level').change(function() {
			doSearch();
		});

		var level = $('input[name=lev]').val();

		$('#level option[value="' + level + '"]').prop('selected', true);
	});

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
			<?php
			if (isset($tgl_dari) && isset($tgl_samp)) {
				echo "
				startDate: '" . $tgl_dari . "',
				endDate: '" . $tgl_samp . "'
				";
			} else {
				echo "
				startDate: moment().startOf('year').startOf('month'),
				endDate: moment().endOf('year').endOf('month')
				";
			}
			?>
		},

		function(start, end) {
			$('#reportrange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
			doSearch();
		});
	}

	function doSearch() {
		var tgl_dari = $('input[name=daterangepicker_start]').val();
		var tgl_samp = $('input[name=daterangepicker_end]').val();
		var level = $('#level').val();

		$('input[name=tgl_dari]').val(tgl_dari);
		$('input[name=tgl_samp]').val(tgl_samp);
		$('input[name=level]').val(level);
		$('#fmCari').attr('action', '<?php echo site_url('lap_balance'); ?>');
		$('#fmCari').submit();
	}

	function clearSearch() {
		window.location.href = '<?php echo site_url("lap_balance"); ?>';
	}
</script>