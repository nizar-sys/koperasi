<link rel="stylesheet" href="<?php echo base_url(); ?>assets/asset/css/bootstrap-datepicker.min.css">	
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />	
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


<?php 
// buaat tanggal sekarang
$tanggal = date('Y-m-d H:i');
$tanggal_arr = explode(' ', $tanggal);
$txt_tanggal = jin_date_ina($tanggal_arr[0]);
$txt_tanggal .= ' - ' . $tanggal_arr[1];
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
                <th class="text-center">Total Debet</th>
                <th class="text-center">Total Kredit</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($data_memo_header as $header) {
                ?>
                <tr>
                    <td><?php echo $header->vcMemoHeaderCode?></td>
                    <td><?php echo date_indo(date('Y-m-d', strtotime($header->dtMemoDate)))?></td>
                    <td class="text-right"><?php echo "Rp.".number_format($header->cuMemoHeaderDebet,2,',','.');?></td>
                    <td class="text-right"><?php echo "Rp.".number_format($header->cuMemoHeaderCredit,2,',','.');?></td>
                    <td><?php echo $header->vcMemoHeaderDesc?></td>
                    <td class="text-center">
                        <a title="Detail" href="<?php echo site_url('detail_jurnal_umum').'/'.$header->vcMemoHeaderCode?>" class="btn-sm btn-primary" role="button"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <?php 
                        if($header->itPostMemoHeader == 0){
                            ?>
                            <a title="Posting" href="<?php echo site_url('jurnal_umum/posting_memo_header').'/'.$header->IDHeaderMemo;?>" class="btn-sm btn-success"><i class="fa fa-share" aria-hidden="true"></i></a>
                            <a title="Edit" href="#" class="btn-sm btn-warning" data-toggle="modal" data-target="#edit-<?php echo $header->vcMemoHeaderCode;?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a title="Hapus" href="<?php echo site_url('jurnal_umum/delete_memo_header/').'/'.$header->IDHeaderMemo;?>" class="btn-sm btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa fa-trash-o"></i></a>
                            <?php
                        }else{
                            ?>
                            <a title="Unposting" href="<?php echo site_url('jurnal_umum/unposting_memo_header').'/'.$header->IDHeaderMemo;?>" class="btn-sm btn-secondary"><i class="fa fa-reply" aria-hidden="true"></i></a>
                            <a title="Edit" href="#" class="btn-sm btn-warning" disabled><i class="fa fa-pencil"></i></a>
                            <a title="Hapus" href="#" class="btn-sm btn-danger" disabled><i class="fa fa-trash-o"></i></a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>

                <div class="modal fade" id="edit-<?php echo $header->vcMemoHeaderCode;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Jurnal Umum</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= site_url('jurnal_umum/update_memo_header')?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">No. Transaksi</label>
                                        <input type="text" class="form-control" id="vcMemoHeaderCode" name="vcMemoHeaderCode" readonly value="<?php echo $header->vcMemoHeaderCode ?>" style="height: 20%;" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Tanggal Transaksi</label>
                                        <input type="text" class="form-control" id="datepicker2" name="dtMemoDate" style="height: 20%;" value="<?php echo date('m/d/Y', strtotime($header->dtMemoDate))?>">
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
                                        <textarea class="form-control" id="vcMemoHeaderDesc" name="vcMemoHeaderDesc" maxlength="35"><?php echo $header->vcMemoHeaderDesc?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <input type="submit" class="btn btn-primary" value="Simpan">
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Jurnal Umum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo site_url('jurnal_umum/insert_memo_header')?>">
                <div class="modal-body">
                    <?php
                    $tahun = date('Y-m');
                    if($header_code->num_rows() == 0){
                        $no_urut = 1;
                    }else{
                        $tahun_header = date('Y', strtotime($header_code->result()[0]->dtMemoDate));
                        $tahun_sekarang = date('Y');
                        if($tahun_header == $tahun_sekarang){
                            $array = explode("-",$header_code->result()[0]->vcMemoHeaderCode);
                            $kode_sekarang = $array[3];
                            $no_urut = (int)$kode_sekarang + 1;
                        }else{
                            $no_urut = 1;
                        }
                    }
                    ?>
                    <div class="form-group">
                        <input type="hidden" name="vcUserID" value="<?php echo $u_name?>" required="required">
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="cuMemoRateValue" value="<?php echo $curr_def->cuRateValue?>" required="required">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">No. Transaksi</label>
                        <input type="text" class="form-control" id="vcMemoHeaderCode" name="vcMemoHeaderCode" style="height: 20%;" value="GL-<?php echo $tahun.'-'.$no_urut?>" readonly required="required">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tanggal Transaksi</label>
                        <input type="text" class="form-control" id="datepicker" name="dtMemoDate" style="height: 20%;">
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
                        <textarea class="form-control" id="vcMemoHeaderDesc" name="vcMemoHeaderDesc" maxlength="35"></textarea>
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


<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Jurnal Umum</h5>
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