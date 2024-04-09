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
                <a href="<?php echo site_url('jurnal_umum') ?>"><?php echo $data_memo_header->vcMemoHeaderCode ?></a>
                <?php
                if($data_memo_header->itPostMemoHeader == '1'){
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
        </div>
        <br>
        <div class="row">
            <div class="col-md-2">
                <label for="recipient-name" class="col-form-label">Keterangan </label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="recipient-name" style="height: 20px; margin-top: -7px;" readonly value="<?php echo $data_memo_header->vcMemoHeaderDesc ?>">
                <!-- <textarea class="form-control" id="vcMemoHeaderDesc" name="vcMemoHeaderDesc" maxlength="35" readonly><?php echo $data_memo_header->vcMemoHeaderDesc?></textarea> -->
            </div>
        </div><br>
        <div class="row">
            <div class="col-md-2">
                <label for="recipient-name" class="col-form-label">Tanggal </label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="recipient-name" style="height: 20px; margin-top: -7px;" readonly value="<?php echo date_indo(date('Y-m-d', strtotime($data_memo_header->dtMemoDate)))?>">
            </div>
        </div><br>
    </div>
</div>

<div class="text-right" style="margin-right:2%;">
    <?php
    if($data_memo_header->itPostMemoHeader == '1'){
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
                <th class="text-center">DK</th>
                <th class="text-center">Debet</th>
                <th class="text-center">Kredit</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $jumlah_kredit = 0;
            $jumlah_debet = 0;
                foreach($detail_header as $detail){
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $detail->vcCOAName?></td>
                        <td class="text-center"><?php echo $detail->vcMemoItemDesc?></td>
                        <th class="text-center"><?php echo $detail->debet_or_kredit?></th>
                        <?php
                            if($detail->debet_or_kredit == "D"){
                                $debet = $detail->cuMemoItemValue;
                                $kredit = 0;
                            }else{
                                $debet = 0;
                                $kredit = $detail->cuMemoItemValue;
                            }
                        ?>
                        <td class="text-right"><?php echo "Rp".number_format($debet,2,',','.');?></td>
                        <td class="text-right"><?php echo "Rp".number_format($kredit,2,',','.');?></td>
                        <td class="text-center">
                        <?php
                        if ($data_memo_header->itPostMemoHeader == '1'){
                            ?>
                            <button disabled="disabled" title="Edit" type="button" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></button>
                            <button disabled="disabled" title="Hapus" type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
                            <?php
                        }else{
                            ?>
                            <a title="Edit" href="#" class="btn-sm btn-success" data-toggle="modal" data-target="#edit-<?php echo $detail->IDItemMemo;?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a title="Hapus" href="<?php echo site_url('jurnal_umum/delete_memo_item/').'/'.$detail->IDItemMemo?>" class="btn-sm btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa fa-trash-o"></i></a>
                            <?php
                        }
                        ?>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="edit-<?php echo $detail->IDItemMemo;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Detail Jurnal Umum</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="<?php echo site_url('jurnal_umum/update_memo_item')?>">
                                    <div class="modal-body">
                                            <div class="form-group">
                                                <input type="hidden" name="vcUserID" value="<?php echo $u_name?>" required="required">
                                                <input type="hidden" name="vcMemoHeaderCode" id="vcMemoHeaderCode" value="<?php echo $detail->vcMemoHeaderCode?>">
                                                <input type="hidden" name="IDItemMemo" id="IDItemMemo" value="<?php echo $detail->IDItemMemo?>">
                                                <input type="hidden" name="cuMemoItemValue_before" id="cuMemoItemValue_before" value="<?php echo $detail->cuMemoItemValue?>">

                                                <label for="recipient-name" class="col-form-label">Akun</label><br>
                                                <select type="text" class="form-control" style="width: 97%;" name="vcCOAMemoItemCode" id="vcCOAMemoItemCode" required="required">
                                                    <option value="">----- Pilih Akun -----</option>
                                                    <?php
                                                    foreach ($akun as $ak) {
                                                        if($ak->itActive == '0' && $ak->itCOAType == '1'){
                                                            if($ak->vcCOACode == $detail->vcCOACode){
                                                                ?>
                                                                <option selected value="<?php echo $ak->vcCOACode?>"><?php echo $ak->vcCOAName?></option>
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
                                                <input type="number" min="1" class="form-control" id="cuMemoItemValue" name="cuMemoItemValue" style="height: 20%;" required="required" value="<?php echo $detail->cuMemoItemValue?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label">Jenis</label><br>
                                                <select type="text" class="form-control" style="width: 97%;" name="debet_or_kredit" id="debet_or_kredit" required="required">
                                                    <option value="">-----Pilih jenis-----</option>
                                                    <?php 
                                                        if($detail->debet_or_kredit == "D"){
                                                            ?>
                                                            <option selected value="D">Debit</option>
                                                            <option value="K">Kredit</option>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option value="D">Debit</option>
                                                            <option selected value="K">Kredit</option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Deskripsi</label>
                                                <textarea class="form-control" id="vcMemoItemDesc" name="vcMemoItemDesc" required="required" maxlength="35"><?php echo $detail->vcMemoItemDesc?></textarea>
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

                    <?php
                    $jumlah_debet +=$debet;
                    $jumlah_kredit +=$kredit;
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td class="text-center"><b>Total Jumlah</b></td>
                <td class="text-right"><b><?php echo "Rp".number_format($jumlah_debet,2,',','.');?></b></td>
                <td class="text-right"><b><?php echo "Rp".number_format($jumlah_kredit,2,',','.');?></b></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>




<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Detail Jurnal Umum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo site_url('jurnal_umum/insert_memo_item')?>">
                <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="vcUserID" value="<?php echo $u_name?>" required="required">
                            <input type="hidden" name="vcMemoHeaderCode" id="vcMemoHeaderCode" value="<?php echo $data_memo_header->vcMemoHeaderCode?>">

                            <label for="recipient-name" class="col-form-label">Akun</label><br>
                            <select type="text" class="form-control" style="width: 97%;" name="vcCOAMemoItemCode" id="vcCOAMemoItemCode" required="required">
                                <option value="">----- Pilih Akun -----</option>
                                <?php
                                foreach ($akun as $ak) {
                                    if($ak->itActive == 0 && $ak->itCOAType == '1'){
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
                            <input type="number" min="1" class="form-control" id="cuMemoItemValue" name="cuMemoItemValue" style="height: 20%;" required="required">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Jenis</label><br>
                            <select type="text" class="form-control" style="width: 97%;" name="debet_or_kredit" id="debet_or_kredit" required="required">
                                <option value="">-----Pilih jenis-----</option>
                                <option value="D">Debit</option>
                                <option value="K">Kredit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Deskripsi</label>
                            <textarea class="form-control" id="vcMemoItemDesc" name="vcMemoItemDesc" required="required" maxlength="35"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <input type="submit" class="btn btn-danger" name="submit" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Detail Jurnal Umum</h5>
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
                        <label for="recipient-name" class="col-form-label">Jenis</label><br>
                        <select type="text" class="form-control" style="width: 97%;">
                            <option value=""></option>
                            <option value="">Debit</option>
                            <option value="">Kredit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Deskripsi</label>
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

<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/jszip.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/pdfmake.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/vfs_fonts.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/asset/javascript/datatable/js/buttons.print.min.js" type="text/javascript"></script>




<script>
    $(document).ready(function() {
        $('#example').DataTable({
            'ordering' : false,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script> 