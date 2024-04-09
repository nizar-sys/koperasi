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
	$level = $_REQUEST['level'];
} else {
	$tgl_dari = date('Y') . '-01-01';
	$tgl_samp = date('Y') . '-12-31';
	$level = '';
}
$tgl_dari_txt = jin_date_ina($tgl_dari, 'p');
$tgl_samp_txt = jin_date_ina($tgl_samp, 'p');
$tgl_periode_txt = $tgl_dari_txt . ' - ' . $tgl_samp_txt;
?>


<div class="row">
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header">
				<h3 class="box-title"> Laporan Trial Balance</h3>
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
								&nbsp;<select id="level" name="level" style="width:170px; height:27px" >
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
				<p style="text-align:center; font-size: 15pt; font-weight: bold;">  Laporan Trial Balance </p>
			</div>
			<div style="padding: 25px;">
				<table id="example" class="display nowrap" style="width:100%">
					<thead>
						<tr>
							<th class="text-center">Akun</th>
							<th class="text-center">Nama Akun</th>
							<th class="text-center">Saldo Awal</th>
							<th class="text-center">Debet</th>
							<th class="text-center">Kredit</th>
							<th class="text-center">Saldo Akhir</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$total_beginning = 0;
						$total_debit = 0;
						$total_credit = 0;
						$total_ending = 0;
						foreach ($data_akun as $akun) {
							$awal = 0;
							$debit_sebelum = 0;
							$credit_sebelum = 0;
							$data_sebelum = $jurnal_umum_m->get_data_trial_balance_before_by_id($akun->vcCOACode)->result();

							foreach ($data_sebelum as $balance_before) {
								$debit_sebelum += $balance_before->cuJournalDebet;
								$credit_sebelum += $balance_before->cuJournalCredit;
								$awal = $debit_sebelum-$credit_sebelum;
							}

							$debit = 0;
							$credit = 0;
							$akhir = 0;
							$data = $jurnal_umum_m->get_data_trial_balance_by_id($akun->vcCOACode)->result();

							foreach ($data as $balance) {
								$debit += $balance->cuJournalDebet;
								$credit += $balance->cuJournalCredit;
								$akhir = $debit-$credit;
							}
							?>
							<tr>
								<td><?= $akun->vcCOACode?></td>
								<td><?= $akun->vcCOAName?></td>
								<td class="text-right">
									<?php
									if ($awal != 0) {
										echo "Rp" . number_format($awal, 2, ',', '.');
									} else {
										echo '-';
									}
									?>
								</td>
								<td class="text-right">
									<?php
									if ($debit != 0) {
										echo "Rp" . number_format($debit, 2, ',', '.');
									} else {
										echo '-';
									}
									?>
								</td>
								<td class="text-right">
									<?php
									if ($credit != 0) {
										echo "Rp" . number_format($credit, 2, ',', '.');
									} else {
										echo '-';
									}
									?>
								</td>
								<td class="text-right">
									<?php
									if ($akhir != 0) {
										echo "Rp" . number_format($akhir, 2, ',', '.');
									} else {
										echo '-';
									}
									?>
								</td>
							</tr>
							<?php
							$total_beginning += $awal ;
							$total_debit += $debit; 
							$total_credit += $credit;
							$total_ending += $akhir;
						}
						?>
					</tbody>
					<tfoot>
						<td></td>
						<td class="text-center"><b>Total Jumlah</b></td>
						<td class="text-right"><b><?php echo "Rp" . number_format($total_beginning, 2, ',', '.'); ?></b></td>
						<td class="text-right"><b><?php echo "Rp" . number_format($total_debit, 2, ',', '.'); ?></b></td>
						<td class="text-right"><b><?php echo "Rp" . number_format($total_credit, 2, ',', '.'); ?></b></td>
						<td class="text-right"><b><?php echo "Rp" . number_format($total_ending, 2, ',', '.'); ?></b></td>
					</tfoot>
				</table>
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
		$('#example').DataTable({
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

		$('#level option[value="'+level+'"]').prop('selected',true);
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
			if(isset($tgl_dari) && isset($tgl_samp)) {
				echo "
				startDate: '".$tgl_dari."',
				endDate: '".$tgl_samp."'
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
		$('#fmCari').attr('action', '<?php echo site_url('lap_trialbalance'); ?>');
		$('#fmCari').submit();
	}

	function clearSearch() {
		window.location.href = '<?php echo site_url("lap_trialbalance"); ?>';
	}
</script>