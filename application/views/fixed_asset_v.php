
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


<?php
// buaat tanggal sekarang
	$tanggal = date('Y-m-d H:i');
	$tanggal_arr = explode(' ', $tanggal);
	$txt_tanggal = jin_date_ina($tanggal_arr[0]);
	$txt_tanggal .= ' - ' . $tanggal_arr[1];
?>

<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#tambah" >Tambah</button>
<div style="padding: 25px;">
    <table id="example" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No. Transaksi</th>
                <th>Tanggal</th>
                <th>Akun</th>
                <th>Keterangan</th>
                <th>Total Akumulasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>FA-2018/01-0001</td>
                <td>18 Januari 2019</td>
                <td>7110</td>
                <td>Pemasukan abal-abal</td>
                <td>Rp 650.000</td>
                <td>
                    <a title="Detail" href="<?php echo site_url()?>transfer_kas/detail_fixed" class="btn-sm btn-primary" role="button"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a title="Posting" href="#" class="btn-sm btn-success"><i class="fa fa-share" aria-hidden="true"></i></a>
                    <a title="Unposting" href="#" class="btn-sm btn-secondary"><i class="fa fa-reply" aria-hidden="true"></i></a>
                    <a title="Edit" href="#" class="btn-sm btn-warning" data-toggle="modal" data-target="#"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a title="Hapus" href="#" class="btn-sm btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa fa-trash-o"></i></a>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr></tr>
        </tfoot>
    </table>
</div>


<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Fixed Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">No. Transaksi</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Akun</label><br>
                        <select type="text" class="form-control" style="width: 97%;">
                            <option value=""></option>
                            <option value="">7110</option>
                            <option value="">4110</option>
                            <option value="">3110</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Periode Penyusutan</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nilai Barang</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Posting CR</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Posting DR</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Keterangan</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger">Simpan</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Fixed Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">No. Transaksi</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Akun</label><br>
                        <select type="text" class="form-control" style="width: 97%;">
                            <option value=""></option>
                            <option value="">7110</option>
                            <option value="">4110</option>
                            <option value="">3110</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Periode Penyusutan</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nilai Barang</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Posting CR</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Posting DR</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Keterangan</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger">Simpan</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Fexed Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus data ini ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger">Ya</button>
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




<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
