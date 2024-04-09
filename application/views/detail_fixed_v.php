	
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />	
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
  

<?php 
// buaat tanggal sekarang
	$tanggal = date('Y-m-d H:i');
	$tanggal_arr = explode(' ', $tanggal);
	$txt_tanggal = jin_date_ina($tanggal_arr[0]);
	$txt_tanggal .= ' - ' . $tanggal_arr[1];
?>

<div class="container">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-2">
                <label for="recipient-name" class="col-form-label">Fixed Asset</label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="recipient-name" style="height: 20px; margin-top: -7px;" value="01.0001 &nbsp; : &nbsp; Lemari" readonly >
                
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-2">
                <label for="recipient-name" class="col-form-label">Akun</label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="recipient-name" style="height: 20px; margin-top: -7px;" value="Lemari" readonly >
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-2">
                <label for="recipient-name" class="col-form-label">Tanggal</label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="recipient-name" style="height: 20px; margin-top: -7px;" readonly >
                <h4><span class="label label-success">Posted</span></h4>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-2">
                <label for="recipient-name" class="col-form-label">Penyusutan</label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="recipient-name" style="height: 20px; margin-top: -7px;" readonly >
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-2">
                <label for="recipient-name" class="col-form-label">Harga Buku</label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="recipient-name" style="height: 20px; margin-top: -7px;" readonly >
            </div>
        </div><br>
    </div>
</div>



<div style="padding: 25px;">
    <table id="example" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Periode</th>
                <th>Akumulasi</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>01/2018</td>
                <td>Rp 0</td>
                <td>Rp 100.000 &nbsp; | &nbsp; 100%</td>
            </tr>
            <tr>
                <td>02/2018</td>
                <td>Rp 416.000</td>
                <td>Rp 800.000 &nbsp; | &nbsp; 100%</td>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Detail Pengeluaran Accounting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
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
                        <label for="recipient-name" class="col-form-label">Jumlah</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Deskripsi</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Detail Pengeluaran Accounting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
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
                        <label for="recipient-name" class="col-form-label">Jumlah</label>
                        <input type="text" class="form-control" id="recipient-name" style="height: 20%;" >
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Deskripsi</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin ingin menghapus data ini ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Ya</button>
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