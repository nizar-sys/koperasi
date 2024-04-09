<link rel="stylesheet" href="<?php echo base_url(); ?>assets/asset/css/bootstrap-datepicker.min.css">
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />   
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


<?php 
// buaat tanggal sekarang
$tanggal = date('Y-m-d H:i');
$tanggal_arr = explode(' ', $tanggal);
$txt_tanggal = jin_date_ina($tanggal_arr[0]);
$txt_tanggal .= ' - ' . $tanggal_arr[1];
// print_r($data_ap_header);
?>

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

    <table id="example" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th class="text-center">No. Transaksi</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Akun</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Total</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($data_ap_header as $header) {
                ?>
                <tr>
                    <td class="text-center"><?php echo $header->vcApHeaderCode?></td>
                    <td class="text-center"><?php echo date_indo(date('Y-m-d', strtotime($header->dtApDate)))?></td>
                    <td class="text-center"><?php echo $header->vcCOAName?></td>
                    <td class="text-center"><?php echo $header->vcApHeaderDesc?></td>
                    <td class="text-right"><?php echo "Rp.".number_format($header->cuItemApTotal,2,',','.');?></td>
                    <td class="text-center">
                        <a title="Detail" href="<?php echo site_url('detail_kas_keluar').'/'.$header->vcApHeaderCode?>" class="btn-sm btn-primary" role="button"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <?php 
                        if($header->itPostApHeader == 0){
                            ?>
                            <a title="Posting" href="<?php echo site_url('kas_keluar/posting_ap_header').'/'.$header->IDHeaderAP;?>" class="btn-sm btn-success"><i class="fa fa-share" aria-hidden="true"></i></a>
                            <a title="Edit" href="#" class="btn-sm btn-warning" data-toggle="modal" data-target="#edit-<?php echo $header->vcApHeaderCode;?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a title="Hapus" href="<?php echo site_url('kas_keluar/delete_ap_header').'/'.$header->IDHeaderAP.'/'.$header->vcApHeaderCode;?>" class="btn-sm btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa fa-trash-o"></i></a>
                            <?php
                        }else{
                            ?>
                            <a title="Unposting" href="<?php echo site_url('kas_keluar/unposting_ap_header').'/'.$header->IDHeaderAP;?>" class="btn-sm btn-secondary"><i class="fa fa-reply" aria-hidden="true"></i></a>
                            <a title="Edit" href="#" class="btn-sm btn-warning" disabled><i class="fa fa-pencil"></i></a>
                            <a title="Hapus" href="#" class="btn-sm btn-danger" disabled><i class="fa fa-trash-o"></i></a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>

                <div class="modal fade" id="edit-<?php echo $header->vcApHeaderCode;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Pemasukan Accounting</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="<?php echo site_url('kas_keluar/update_ap_header')?>">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">No. Transaksi</label>
                                        <input type="text" class="form-control" id="vcApHeaderCode" name="vcApHeaderCode" style="height: 20%;" readonly value="<?php echo $header->vcApHeaderCode ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Tanggal Transaksi</label>
                                        <input type="text" class="form-control" id="datepicker2" name="dtApDate" style="height: 20%;" value="<?php echo date('m/d/Y', strtotime($header->dtApDate))?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Akun</label><br>
                                        <select type="text" class="form-control" style="width: 97%;" name="vcCOACode" id="vcCOACode" required="required">
                                            <option value="">----- Pilih Akun -----</option>
                                            <?php
                                            foreach ($akun as $ak) {
                                                if($ak->itCOACashBank == 1){
                                                    if($ak->vcCOACode == $header->vcCOACode){
                                                        ?>
                                                        <option selected="selected" value="<?php echo $ak->vcCOACode?>"><?php echo $ak->vcCOAName?></option>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <option value="<?php echo $ak->vcCOACode?>"><?php echo $ak->vcCOAName?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Mata Uang</label><br>
                                        <select type="text" class="form-control" style="width: 97%;" name="vcCurrCode" id="vcCurrCode" required="required">
                                            <option value="">-----Pilih Mata Uang-----</option>
                                            <?php
                                            foreach ($mata_uang as $mata) {
                                                if($mata->vcCurrCode == $header->vcCurrCode){
                                                    ?>
                                                    <option selected="selected" value="<?php echo $mata->vcCurrCode?>"><?php echo $mata->vcCurrName?></option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value="<?php echo $mata->vcCurrCode?>"><?php echo $mata->vcCurrName?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Keterangan</label>
                                        <textarea class="form-control" id="vcApHeaderDesc" name="vcApHeaderDesc" required="required" maxlength="30"><?php echo $header->vcApHeaderDesc?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <input type="submit" name="Submit" class="btn btn-primary" value="Simpan">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pengeluaran Accounting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo site_url('kas_keluar/insert_ap_header')?>">
                <div class="modal-body">
                    <?php
                    $tahun = date('Y-m');
                    if($header_code->num_rows() == 0){
                        $no_urut = 1;
                    }else{
                        $tahun_header = date('Y', strtotime($header_code->result()[0]->dtApDate));
                        $tahun_sekarang = date('Y');
                        if($tahun_header == $tahun_sekarang){
                            $array = explode("-",$header_code->result()[0]->vcApHeaderCode);
                            $kode_sekarang = $array[3];
                            $no_urut = (int)$kode_sekarang + 1;
                        }else{
                            $no_urut = 1;
                        }
                    }
                    ?>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">No. Transaksi</label>
                        <input type="text" class="form-control" id="vcApHeaderCode" name="vcApHeaderCode" style="height: 20%;" value="AP-<?php echo $tahun.'-'.$no_urut?>" readonly required="required">
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="vcUserID" value="<?php echo $u_name?>" required="required">
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="cuRateValue" value="<?php echo $curr_def->cuRateValue?>" required="required">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" class="form-control" id="datepicker" name="dtApDate" style="height: 20%;" required="required">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Akun</label><br>
                        <select type="text" class="form-control" style="width: 97%;" name="vcCOACode" id="vcCOACode" required="required">
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
                        <select type="text" class="form-control" style="width: 97%;" name="vcCurrCode" id="vcCurrCode" required="required">
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
                        <textarea class="form-control" id="vcApHeaderDesc" name="vcApHeaderDesc" maxlength="30" required="required"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
                </div>
            </form>
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
            'ordering' : false,
            dom: 'Bfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
     //Date picker
     $('#datepicker').datepicker({
      autoclose: true
  });

     $('#datepicker2').datepicker({
      autoclose: true
  });
 } );
</script>