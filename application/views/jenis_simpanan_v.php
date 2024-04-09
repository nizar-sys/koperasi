
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


<?php
// buaat tanggal sekarang
$tanggal = date('Y-m-d H:i');
$tanggal_arr = explode(' ', $tanggal);
$txt_tanggal = jin_date_ina($tanggal_arr[0]);
$txt_tanggal .= ' - ' . $tanggal_arr[1];
?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah" >Tambah Jenis Simpanan</button>
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
        <th class="text-center">No</th>
        <th class="text-center">Jenis Simpanan</th>
        <th class="text-center">Chart Of Account</th>
        <th class="text-center">Jumlah</th>
        <th class="text-center">Status</th>
        <th class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i=0;
      foreach ($data_jsimpan as $jsimpan) {
        $i++;
        ?>
        <tr>
          <td class="text-center"> <?= $i;?></td>
          <td class="text-left"><?php echo $jsimpan->jns_simpan?></td>
          <td class="text-left"><?php echo $jsimpan->vcCOAName?></td>
          <td class="text-right"><?php echo "Rp.".number_format($jsimpan->jumlah,2,',','.');?></td>          
          <td class="text-center">
            <?php
            if($jsimpan->tampil == 'Y'){
              echo 'Aktif';
            }else{
              echo 'Tidak aktif';
            }
            ?>
          </td>
        </td>
        <td class="text-center">
          <a title="Edit" href="#" class="btn-sm btn-primary" data-toggle="modal" data-target="#edit-<?php echo $jsimpan->id?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
          <a title="Hapus" href="<?= site_url('jenis_simpanan/delete/'.$jsimpan->id)?>" class="btn-sm btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa fa-trash-o"></i></a>
        </td>
      </tr>

      <!-- looping modal start -->
      <div class="modal fade" id="edit-<?php echo $jsimpan->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ubah Jenis Simpanan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="<?php echo site_url('jenis_simpanan/post_update_jenis_simpanan')?>" method="post">
              <div class="modal-body">
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Jenis Simpanan</label>
                  <input type="text" class="form-control" id="jns_simpan" name="jns_simpan" style="height: 20%;" required="required" value="<?php echo $jsimpan->jns_simpan?>">
                  <input type="hidden" class="form-control" id="id" name="id" style="height: 20%;" required="required" value="<?php echo $jsimpan->id?>">
                </div>
                <div class="form-group">
                  <label for="vcCOACode" class="col-form-label">Chart Of Account</label><br>
                  <select type="text" class="form-control" id="vcCOACode" name="vcCOACode" style="height: 20%;" required="required">
                    <option value="">-----Pilih COA-----</option>
                    <?php
                    foreach ($coa as $code) {
                      if($code->vcCOACode == $jsimpan->vcCOACode){
                        ?>
                        <option selected="selected" value="<?php echo $code->vcCOACode?>"><?php echo $code->vcCOAName?></option>
                        <?php
                      }else{
                        ?>
                        <option value="<?php echo $code->vcCOACode?>"><?php echo $code->vcCOAName?></option>
                        <?php
                      }
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Jumlah Simpanan</label>
                  <input type="text" class="form-control" id="jumlah" name="jumlah" style="height: 20%;" required="required" value="<?php echo $jsimpan->jumlah?>">
                </div>
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Status</label><br>
                  <select type="text" class="form-control" id="tampil" name="tampil" style="height: 20%;" required="required">
                    <option value="">-----Pilih Status-----</option>
                    <?php
                    if($jsimpan->tampil == 'Y'){
                      ?>
                      <option selected="selected" value="Y">Ya</option>
                      <option value="T">Tidak</option>
                      <?php
                    }else{
                      ?>
                      <option value="Y">Ya</option>
                      <option selected="selected" value="T">Tidak</option>
                      <?php
                    }
                    ?>
                  </select>
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
      <!-- looping modal end -->


      <?php
    }
    ?>
  </tbody>
</table>
</div>


<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Simpanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo site_url('jenis_simpanan/post_jenis_simpan')?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Jenis Simpanan</label>
            <input type="text" class="form-control" id="jns_simpan" name="jns_simpan" style="height: 20%;" required="required" value="">
          </div>
          <div class="form-group">
            <label for="vcCOACode" class="col-form-label">Chart Of Account</label><br>
            <select type="text" class="form-control" id="vcCOACode" name="vcCOACode" style="height: 20%;" required="required">
              <option value="">-----Pilih COA-----</option>
              <?php
              foreach ($coa as $code) {
                ?>
                <option value="<?php echo $code->vcCOACode?>"><?php echo $code->vcCOAName?></option>
                <?php
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Jumlah Simpanan</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" style="height: 20%;" required="required" value="">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Status</label><br>
            <select type="text" class="form-control" id="tampil" name="tampil" style="height: 20%;" required="required">
              <option value="">-----Pilih Status-----</option>
              <option value="Y">Ya</option>
              <option value="T">Tidak</option>
            </select>
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




<script>
  $(document).ready(function() {
    $('#example').DataTable( {
      'ordering' : false,
      dom: 'Bfrtip',
      buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    } );
  } );
</script>
