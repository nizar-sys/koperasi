
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


<?php
// buaat tanggal sekarang
$tanggal = date('Y-m-d H:i');
$tanggal_arr = explode(' ', $tanggal);
$txt_tanggal = jin_date_ina($tanggal_arr[0]);
$txt_tanggal .= ' - ' . $tanggal_arr[1];
?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah" >Tambah Grup Akun</button>
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
              <th class="text-center">Kode</th>
              <th class="text-center">Nama</th>
              <th class="text-center">Status</th>
              <th class="text-center">Aksi</th>
          </tr>
      </thead>
      <tbody>
          <?php
          foreach ($data_grup_akun as $grup) {
                ?>
                <tr>
                    <td class="text-center"><?php echo $grup->vcGroupCode?></td>
                    <td class="text-center"><?php echo $grup->vcGroupName?></td>
                    <td class="text-center">
                      <?php
                      if($grup->itStatus == '0'){
                        echo '<span class="label label-primary">Aktif</span>';
                      }else{
                        echo '<span class="label label-danger">Tidak aktif</span>';
                      }
                      ?>
                    </td>
                    <td class="text-center">
                      <a title="Edit" href="#" class="btn-sm btn-warning" data-toggle="modal" data-target="#edit-<?php echo $grup->GroupId;?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                      <a title="Hapus" href="<?php echo site_url('grup_akun/delete/'.$grup->GroupId)?>" class="btn-sm btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa fa-trash-o"></i></a>
                    </td>
                </tr>

                <div class="modal fade" id="edit-<?php echo $grup->GroupId;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Grup Akun</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <form method="post" action="<?php echo site_url('grup_akun/update')?>">
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="recipient-name" class="col-form-label">Kode</label>
                              <input type="text" class="form-control" id="vcGroupCode" name="vcGroupCode" value="<?php echo $grup->vcGroupCode?>" style="height: 20%;" required="required" readonly>
                            </div>
                            <div class="form-group">
                              <label for="recipient-name" class="col-form-label">Nama</label>
                              <input type="text" class="form-control" id="vcGroupName" name="vcGroupName" value="<?php echo $grup->vcGroupName?>" style="height: 20%;" required="required">
                            </div>
                            <div class="form-group">
                              <label for="recipient-name" class="col-form-label">Status</label><br>
                              <select type="text" class="form-control" id="itStatus" name="itStatus" style="width: 97%;" required="required">
                                <option value="">-----Pilih status-----</option>
                                <?php
                                if($grup->itStatus == '0'){
                                  ?>
                                  <option selected="selected" value="0">Aktif</option>
                                  <option value="1">Non Aktif</option>
                                  <?php
                                }else{
                                  ?>
                                  <option value="0">Aktif</option>
                                  <option selected="selected" value="1">Non Aktif</option>
                                  <?php
                                }
                                ?>
                              </select>
                              <input type="hidden" id="vcUserID" name="vcUserID" value="<?php echo $u_name?>" required="required">
                              <input type="hidden" id="GroupId" name="GroupId" value="<?php echo $grup->GroupId?>" required="required">
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
              <h5 class="modal-title" id="exampleModalLabel">Tambah Grup Akun</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action="<?php echo site_url('grup_akun/post_group_akun')?>" method="post">
            <div class="modal-body">
              <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Kode</label>
                  <input type="text" class="form-control" id="vcGroupCode" name="vcGroupCode" style="height: 20%;" required="required">
              </div>
              <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Nama</label>
                  <input type="text" class="form-control" id="vcGroupName" name="vcGroupName" style="height: 20%;" required="required">
              </div>
              <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Status</label><br>
                  <select type="text" class="form-control" id="itStatus" name="itStatus" style="width: 97%;" required="required">
                      <option value="">-----Pilih status-----</option>
                      <option value="0">Aktif</option>
                      <option value="1">Non Aktif</option>
                  </select>
                  <input type="hidden" id="vcUserID" name="vcUserID" value="<?php echo $u_name?>" required="required">
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <input type="submit" class="btn btn-primary" value="Simpan" name="submit">
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
