    
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
                <label for="recipient-name" class="col-form-label">No. Transaksi</label>
            </div>
            <div class="col-md-6">
                <a href="<?php echo site_url('kas_keluar/')?>"><?php echo $data_ap_header->vcApHeaderCode?></a>
            </div>
            <br>
            <br>
        </div>
        <div class="row">
            <div class="col-md-2">
                <label for="recipient-name" class="col-form-label">Jumlah (01)</label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="jumlah_atas" style="height: 20px; margin-top: -7px;" readonly >
                <?php
                if($data_ap_header->itPostApHeader == '1'){
                    ?>
                    <h4><span class="label label-success">Posted</span></h4>
                    <?php
                }else{
                    ?>
                    <h4><span class="label label-default">Unposted</span></h4>
                    <?php
                }
                ?>
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-2">
                <label for="recipient-name" class="col-form-label">Tanggal</label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="recipient-name" style="height: 20px; margin-top: -7px;" readonly value="<?php echo date_indo(date('Y-m-d', strtotime($data_ap_header->dtApDate)))?>">
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-2">
                <label for="recipient-name" class="col-form-label">Akun</label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="recipient-name" style="height: 20px; margin-top: -7px;" readonly value="<?php echo $data_ap_header->vcCOAName?>">
            </div>
        </div><br>
    </div>
</div>



<div class="text-right" style="margin-right:2%;">
    <?php 
    if($data_ap_header->itPostApHeader == '1'){
        ?>
        <button disabled="disabled" type="button" class="btn btn-primary">Tambah</button>
        <?php
    }else{
        ?>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah" >Tambah</button>
        <?php
    }
    ?>
</div>


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
                <th class="text-center">Akun</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $jumlah = 0;
            foreach ($detail_header as $detail) {
                ?>
                <tr>
                    <td class="text-center"><?php echo $detail->vcCOAName?></td>
                    <td class="text-center"><?php echo $detail->vcApItemDesc?></td>
                    <td class="text-right"><?php echo "Rp.".number_format($detail->cuApItemValue,2,',','.');?></td>
                    <td class="text-center">
                        <?php
                        if ($data_ap_header->itPostApHeader == '1'){
                            ?>
                            <button disabled="disabled" title="Edit" type="button" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></button>
                            <button disabled="disabled" title="Hapus" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
                            <?php
                        }else{
                            ?>
                            <a title="Edit" href="#" class="btn-sm btn-success" data-toggle="modal" data-target="#edit-<?php echo $detail->IDItemAP;?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a title="Hapus" href="<?php echo site_url('kas_keluar/delete_ap_item/').'/'.$detail->IDItemAP.'/'.$detail->cuApItemValue.'/'.$detail->vcApHeaderCode;?>" class="btn-sm btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa fa-trash-o"></i></a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>

                <div class="modal fade" id="edit-<?php echo $detail->IDItemAP;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Detail Pengeluaran Accounting</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?php echo site_url('kas_keluar/update_ap_item')?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" name="IDItemAP" id="IDItemAP" value="<?php echo $detail->IDItemAP?>">
                                        <input type="hidden" name="vcApHeaderCode" id="vcApHeaderCode" value="<?php echo $detail->vcApHeaderCode?>">
                                        <label for="recipient-name" class="col-form-label">Akun</label><br>
                                        <select type="text" class="form-control" style="width: 97%;" name="vcCOAApItemCode" id="vcCOAApItemCode" required="required">
                                            <option value="">----- Pilih Akun -----</option>
                                            <?php
                                            foreach ($akun as $ak) {
                                                if($ak->itCOAType == 1 && $ak->vcCOACode != $data_ap_header->vcCOACode){
                                                    if($ak->vcCOACode == $detail->vcCOAApItemCode){
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
                                        <label for="recipient-name" class="col-form-label">Jumlah</label>
                                        <input type="text" class="form-control" id="cuApItemValue" name="cuApItemValue" style="height: 20%;" value="<?php echo $detail->cuApItemValue?>" required="required">
                                        <input type="hidden" class="form-control" id="cuApItemValue_before" name="cuApItemValue_before" style="height: 20%;" value="<?php echo $detail->cuApItemValue?>" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Deskripsi</label>
                                        <textarea class="form-control" id="vcApItemDesc" name="vcApItemDesc" required="required"><?php echo $detail->vcApItemDesc?></textarea>
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

                <?php
                $jumlah+=$detail->cuApItemValue;
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td class="text-center"><strong>Total Jumlah</strong></td>
                <td class="text-right" style="padding-right:10px"><strong><?php echo "Rp.".number_format($jumlah,2,',','.');?></strong></td>
                <td></td>
            </tr>
            <input type="hidden" name="jumlah_bawah" id="jumlah_bawah" value="<?php echo "Rp.".number_format($jumlah,2,',','.');?>">
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
            <form method="post" action="<?php echo site_url('kas_keluar/insert_ap_item')?>">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="vcUserID" value="<?php echo $u_name?>" required="required">
                        <input type="hidden" name="vcApHeaderCode" id="vcApHeaderCode" value="<?php echo $data_ap_header->vcApHeaderCode?>">
                        <label for="recipient-name" class="col-form-label">Akun</label><br>
                        <select type="text" class="form-control" style="width: 97%;" name="vcCOAApItemCode" id="vcCOAApItemCode" required="required">
                            <option value="">----- Pilih Akun -----</option>
                            <?php
                            foreach ($akun as $ak) {
                                if($ak->itCOAType == 1 && $ak->vcCOACode != $data_ap_header->vcCOACode){
                                    ?>
                                    <option value="<?php echo $ak->vcCOACode?>"><?php echo $ak->vcCOAName?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Jumlah</label>
                        <input type="number" min="1" class="form-control" id="cuApItemValue" name="cuApItemValue" style="height: 20%;" required="required">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Deskripsi</label>
                        <textarea class="form-control" id="vcApItemDesc" name="vcApItemDesc" required="required" maxlength="35"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <input type="submit" class="btn btn-primary" name="submit" value="Simpan">
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




<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            'ordering' : false,
            dom: 'Bfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
        var jumlah_bawah = $('#jumlah_bawah').val();
        $('#jumlah_atas').val(jumlah_bawah);

    } );
</script>