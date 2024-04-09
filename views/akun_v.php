
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/asset/javascript/datatable/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


<?php
// buaat tanggal sekarang
$tanggal = date('Y-m-d H:i');
$tanggal_arr = explode(' ', $tanggal);
$txt_tanggal = jin_date_ina($tanggal_arr[0]);
$txt_tanggal .= ' - ' . $tanggal_arr[1];
?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah" >Tambah Jenis Akun</button>
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
        <th class="text-center">Grup Akun</th>
        <th class="text-center">Tipe</th>
        <th class="text-center">Level</th>
        <th class="text-center">Kas/Bank</th>
        <!--<th class="text-center">Fixed Asset</th>-->
        <th class="text-center">Normal Bal</th>
        <!--<th class="text-center">Saldo Awal</th>-->
        <th class="text-center">Tipe Report</th>
        <th class="text-center">Status</th>
        <th class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($data_akun as $akun) {
        ?>
        <tr>
          <td class="text-center"><?php echo $akun->vcCOACode?></td>
          <td class="text-left"><?php echo $akun->vcCOAName?></td>
          <td class="text-center"><?php echo $akun->vcGroupName?></td>
          <td class="text-center">
            <?php
            if($akun->itCOAType == '0'){
              echo 'Header';
            }else{
              echo 'Item';
            }
            ?>
          </td>
          <td class="text-center"><?php echo $akun->itCOALevel?></td>
          <td class="text-center">
            <?php
            if($akun->itCOACashBank == '0'){
              echo "Normal";
            }else{
              echo "Kas/Bank";
            }
            ?>
          </td>
          <!--<td class="text-center">
            <?php
            if($akun->itCOAFixedAsset == '0'){
              echo "Normal";
            }else{
              echo "Fixed Asset";
            }
            ?>
          </td>-->
          <td class="text-center">
            <?php
            if($akun->vcCOABalanceType == 'D'){
              echo 'Debet';
            }else{
              echo 'Kredit';
            }
            ?>
          </td>
          <!--<td class="text-center">
            <?php echo "Rp.".number_format($akun->cuCOABalanceValue,2,',','.');?>
          </td>-->
          <td class="text-center">
            <?php
            if($akun->itCOAReportType == '0'){
              echo "Balance";
            }else{
              echo "Income";
            }
            ?>
          </td>
          <td class="text-center">
            <?php
            if($akun->itActive == '0'){
              echo 'Aktif';
            }else{
              echo 'Non aktif';
            }
            ?>
          </td>
          <td class="text-center">
            <a title="Edit" href="#" class="btn-sm btn-primary" data-toggle="modal" data-target="#edit-<?php echo $akun->CoaId?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            <a title="Hapus" href="<?= site_url('akun/delete/'.$akun->vcCOACode)?>" class="btn-sm btn-danger" onClick="return confirm('Anda yakin akan menghapus data ini?')"><i class="fa fa-trash-o"></i></a>
          </td>
        </tr>


        <!-- looping modal start -->
        <div class="modal fade" id="edit-<?php echo $akun->CoaId?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Jenis Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="<?php echo site_url('akun/post_update_coa')?>" method="post">
                <div class="modal-body">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Kode</label>
                    <input type="text" class="form-control" id="vcCOACode" name="vcCOACode" style="height: 20%;" required="required" value="<?php echo $akun->vcCOACode?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Nama</label>
                    <input type="text" class="form-control" id="vcCOAName" name="vcCOAName" style="height: 20%;" required="required" value="<?php echo $akun->vcCOAName?>">
                  </div>
                  <div class="row">
                    <div class="col-sm-3" style="margin-left:-13px;">
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Tipe</label><br>
                        <select type="text" class="form-control" style="width: 120%;" id="itCOAType" name="itCOAType" required="required">
                          <option value="">-----Pilih tipe-----</option>
                          <?php
                          if($akun->itCOAType == '0'){
                            ?>
                            <option selected="selected" value="0">Header</option>
                            <option value="1">Detail</option>
                            <?php
                          }else{
                            ?>
                            <option value="0">Header</option>
                            <option selected="selected" value="1">Detail</option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group" style="margin-left:15px;">
                        <label for="recipient-name" class="col-form-label">Level</label><br>
                        <select type="text" class="form-control" style="width: 140%;" id="itCOALevel" name="itCOALevel" required="required">
                          <option value="">-----Pilih level-----</option>
                          <?php
                          for ($i=0; $i < 6 ; $i++) {
                            if($i == $akun->itCOALevel){
                              ?>
                              <option selected="selected" value="<?= $i ?>">Level <?= $i?></option>
                              <?php
                            }else{
                              ?>
                              <option value="<?= $i ?>">Level <?= $i?></option>
                              <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group" style="margin-left:35px;">
                        <label for="recipient-name" class="col-form-label">Kas Bank</label><br>
                        <select type="text" class="form-control" style="width: 155%;" name="itCOACashBank" id="itCOACashBank" required="required">
                          <option value="">-----Pilih kas bank-----</option>
                          <?php
                          if($akun->itCOACashBank == '0'){
                            ?>
                            <option selected="selected" value="0">Normal</option>
                            <option value="1">Kas/Bank</option>
                            <?php
                          }else{
                            ?>
                            <option value="0">Normal</option>
                            <option selected="selected" value="1">Kas/Bank</option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-3" style="margin-left:-13px;">
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Fixed Asset</label><br>
                        <select type="text" class="form-control" style="width: 120%;" name="itCOAFixedAsset" id="itCOAFixedAsset" required="required">
                          <option value="">-----Pilih fixed asset-----</option>
                          <?php
                          if($akun->itCOAFixedAsset == '0'){
                            ?>
                            <option selected="selected" value="0">Normal</option>
                            <option value="1">Fixed Asset</option>
                            <?php
                          }else{
                            ?>
                            <option value="0">Normal</option>
                            <option selected="selected" value="1">Fixed Asset</option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group" style="margin-left:15px;">
                        <label for="recipient-name" class="col-form-label">Normal Balance</label><br>
                        <select type="text" class="form-control" style="width: 140%;" id="vcCOABalanceType" name="vcCOABalanceType" required="required">
                          <option value="">-----Pilih normal balance-----</option>
                          <?php
                          if($akun->vcCOABalanceType == 'D'){
                            ?>
                            <option selected="selected" value="D">Debet</option>
                            <option value="K">Credit</option>
                            <?php
                          }else{
                            ?>
                            <option value="D">Debet</option>
                            <option selected="selected" value="K">Credit</option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group" style="margin-left:35px;">
                        <label for="recipient-name" class="col-form-label">Tipe Report</label><br>
                        <select type="text" class="form-control" style="width: 155%;" name="itCOAReportType" id="itCOAReportType" required="required">
                          <option value="">-----Pilih tipe report-----</option>
                          <?php
                          if($akun->itCOAReportType == '0'){
                            ?>
                            <option selected="selected" value="0">Balance</option>
                            <option value="1">Income</option>
                            <?php
                          }else{
                            ?>
                            <option selected="selected" value="0">Balance</option>
                            <option value="1">Income</option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-3" style="margin-left:-13px;">
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Status</label><br>
                        <select type="text" class="form-control" style="width: 120%;" id="itActive" name="itActive" required="required">
                          <option value="">-----Pilih status-----</option>
                          <?php
                          if($akun->itActive == '0'){
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
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group" style="margin-left:15px;">
                        <label for="recipient-name" class="col-form-label">Saldo Awal</label>
                        <input type="number" class="form-control" style="height: 20%; width: 120%;" id="cuCOABalanceValue" name="cuCOABalanceValue" value="<?= $akun->cuCOABalanceValue;?>">
                      </div>
                    </div>

                    <div class="col-sm-3" style="margin-left:35px;">
                      <div class="form-group">
                        <label for="vcGroupCode" class="col-form-label">Group COA</label><br>
                        <select type="text" class="form-control" style="width: 120%;" id="vcGroupCode" name="vcGroupCode" required="required">
                          <option value="">-----Pilih group COA-----</option>
                          <?php
                          foreach ($group_coa as $coa) {
                            if($coa->vcGroupCode == $akun->vcGroupCode){
                              ?>
                              <option selected="selected" value="<?php echo $coa->vcGroupCode?>"><?php echo $coa->vcGroupName?></option>
                              <?php
                            }else{
                              ?>
                              <option value="<?php echo $coa->vcGroupCode?>"><?php echo $coa->vcGroupName?></option>
                              <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Keterangan</label>
                    <textarea class="form-control" id="vcCOADesc" name="vcCOADesc" style="height: 40%;" maxlength="200"><?= $akun->vcCOADesc?></textarea>
                    <input type="hidden" id="vcUserID" name="vcUserID" value="<?php echo $akun->vcUserID?>" required="required">
                    <input type="hidden" id="CoaId" name="CoaId" value="<?php echo $akun->CoaId?>" required="required">
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo site_url('akun/post_coa')?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Kode</label>
            <input type="text" class="form-control" id="vcCOACode" name="vcCOACode" style="height: 20%;" required="required">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nama</label>
            <input type="text" class="form-control" id="vcCOAName" name="vcCOAName" style="height: 20%;" required="required">
          </div>
          <div class="row">
            <div class="col-sm-3" style="margin-left:-13px;">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Tipe</label><br>
                <select type="text" class="form-control" style="width: 120%;" id="itCOAType" name="itCOAType" required="required">
                  <option value="">-----Pilih tipe-----</option>
                  <option value="0">Header</option>
                  <option value="1">Detail</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group" style="margin-left:15px;">
                <label for="recipient-name" class="col-form-label">Level</label><br>
                <select type="text" class="form-control" style="width: 140%;" id="itCOALevel" name="itCOALevel" required="required">
                  <option value="">-----Pilih level-----</option>
                  <option value="0">Level 0</option>
                  <option value="1">Level 1</option>
                  <option value="2">Level 2</option>
                  <option value="3">Level 3</option>
                  <option value="4">Level 4</option>
                  <option value="5">Level 5</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group" style="margin-left:35px;">
                <label for="recipient-name" class="col-form-label">Kas Bank</label><br>
                <select type="text" class="form-control" style="width: 155%;" name="itCOACashBank" id="itCOACashBank" required="required">
                  <option value="">-----Pilih kas bank-----</option>
                  <option value="0">Normal</option>
                  <option value="1">KAs/Bank</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3" style="margin-left:-13px;">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Fixed Asset</label><br>
                <select type="text" class="form-control" style="width: 120%;" name="itCOAFixedAsset" id="itCOAFixedAsset" required="required">
                  <option value="">-----Pilih fixed asset-----</option>
                  <option value="0">Normal</option>
                  <option value="1">Fixed Asset</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group" style="margin-left:15px;">
                <label for="recipient-name" class="col-form-label">Normal Balance</label><br>
                <select type="text" class="form-control" style="width: 140%;" id="vcCOABalanceType" name="vcCOABalanceType" required="required">
                  <option value="">-----Pilih normal balance-----</option>
                  <option value="D">Debet</option>
                  <option value="K">Credit</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group" style="margin-left:35px;">
                <label for="recipient-name" class="col-form-label">Tipe Report</label><br>
                <select type="text" class="form-control" style="width: 155%;" name="itCOAReportType" id="itCOAReportType" required="required">
                  <option value="">-----Pilih tipe report-----</option>
                  <option value="0">Balance</option>
                  <option value="1">Income</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3" style="margin-left:-13px;">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Status</label><br>
                <select type="text" class="form-control" style="width: 120%;" id="itActive" name="itActive" required="required">
                  <option value="">-----Pilih status-----</option>
                  <option value="0">Aktif</option>
                  <option value="1">Non Aktif</option>
                </select>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group" style="margin-left:15px;">
                <label for="recipient-name" class="col-form-label">Saldo Awal</label>
                <input type="number" class="form-control" style="height: 20%; width: 120%;" id="cuCOABalanceValue" name="cuCOABalanceValue">
              </div>
            </div>

            <div class="col-sm-3" style="margin-left:35px;">
              <div class="form-group">
                <label for="vcGroupCode" class="col-form-label">Group COA</label><br>
                <select type="text" class="form-control" style="width: 120%;" id="vcGroupCode" name="vcGroupCode" required="required">
                  <option value="">-----Pilih group COA-----</option>
                  <?php
                  foreach ($group_coa as $coa) {
                    ?>
                    <option value="<?php echo $coa->vcGroupCode?>"><?php echo $coa->vcGroupName?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Keterangan</label>
            <textarea class="form-control" id="vcCOADesc" name="vcCOADesc" style="height: 40%;" maxlength="200"></textarea>
            <input type="hidden" id="vcUserID" name="vcUserID" value="<?php echo $u_name?>" required="required">
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
