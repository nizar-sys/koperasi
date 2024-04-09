<!-- search form -->
<a href="<?php echo site_url();?>" class="logo">
			<!-- Add the class icon to your logo image or logo icon to add the margining -->
		</a>
<!-- /.search form -->

<ul class="sidebar-menu">
<li class="<?php
	 $menu_home_arr= array('home', '');
	 if(in_array($this->uri->segment(1), $menu_home_arr)) {echo "active";}?>">
		<a href="<?php echo base_url(); ?>home">
			<img height="20" src="<?php echo base_url().'assets/theme_admin/img/home.png'; ?>"> <span>Beranda</span>
		</a>
</li>

<!-- Menu Transaksi -->
<?php if($level != 'pinjaman') { ?>
<li  class="treeview <?php
	 $menu_trans_arr= array('kas_masuk','kas_keluar', 'jurnal_umum','fixed_asset','detail_kas_masuk','detail_kas_keluar','detail_jurnal_umum');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/transaksi.png'; ?>">
		<span>Transaksi Kas</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'kas_masuk' || $this->uri->segment(1) == 'detail_kas_masuk') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>kas_masuk"> <i class="fa fa-folder-open-o"></i> Cash/Bank Receipt </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'kas_keluar' || $this->uri->segment(1) == 'detail_kas_keluar') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>kas_keluar"> <i class="fa fa-folder-open-o"></i> Cash/Bank Payment </a></li>
		<li class="<?php if ($this->uri->segment(1) == 'jurnal_umum' || $this->uri->segment(1) == 'detail_jurnal_umum') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>jurnal_umum"> <i class="fa fa-folder-open-o"></i> General Journal </a></li>
		<!--<li class="<?php if ($this->uri->segment(1) == 'fixed_asset' || $this->uri->segment(2) == 'detail') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>fixed_asset"> <i class="fa fa-folder-open-o"></i> Fixed Asset </a></li>-->
	</ul>
</li>
<?php } ?>

<?php if($level != 'pinjaman') { ?>
<!-- Menu Simpanan -->
<li  class="treeview <?php
	 $menu_trans_arr= array('simpanan','penarikan');
	 if(in_array($this->uri->segment(1), $menu_trans_arr)) {echo "active";}?>">

	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/uang.png'; ?>">
		<span>Simpanan</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
		<li class="<?php if ($this->uri->segment(1) == 'simpanan') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>simpanan"> <i class="fa fa-folder-open-o"></i> Setoran Tunai </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'penarikan') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>penarikan"> <i class="fa fa-folder-open-o"></i> Penarikan Tunai</a></li>
	</ul>
</li>
<?php } ?>

<!-- menu pinjaman -->
<li  class="treeview <?php
$menu_pinjam_arr= array('pengajuan','pinjaman','bayar','pelunasan', 'angsuran','angsuran_detail','angsuran_lunas');
if(in_array($this->uri->segment(1), $menu_pinjam_arr)) {echo "active";}?>">

<a href="#">
	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/pinjam.png'; ?>">
	<span>Pinjaman</span>
	<i class="fa fa-angle-left pull-right"></i>
</a>
<ul class="treeview-menu">
	<li class="<?php if ($this->uri->segment(1) == 'pengajuan' || $this->uri->segment(1) == 'pengajuan'){ echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>pengajuan"> <i class="fa fa-folder-open-o"></i> Data Pengajuan </a></li>
	<?php if($level != 'pinjaman') { ?>
	<li class="<?php if ($this->uri->segment(1) == 'pinjaman' || $this->uri->segment(1) == 'angsuran_detail'){ echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>pinjaman"> <i class="fa fa-folder-open-o"></i> Data Pinjaman </a></li>
	<li class="<?php if ($this->uri->segment(1) == 'bayar' || $this->uri->segment(1) == 'angsuran') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>bayar"> <i class="fa fa-folder-open-o"></i> Bayar Angsuran</a></li>

	<li class="<?php if ($this->uri->segment(1) == 'pelunasan' || $this->uri->segment(1) == 'angsuran_lunas') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>pelunasan"> <i class="fa fa-folder-open-o"></i> Pinjaman Lunas </a></li>
	<?php } ?>
</ul>
</li>

<!-- laporan -->
<li  class="treeview <?php
	 $menu_lap_arr= array('lap_anggota','lap_kas_anggota','lap_simpanan','lap_kas_pinjaman','lap_tempo','lap_macet','lap_trans_kas','lap_buku_besar','lap_saldo','lap_laba','lap_shu','lap_jurnal','lap_jurnalumum','lap_trialbalance','lap_fixed','lap_balance');
	 if(in_array($this->uri->segment(1), $menu_lap_arr)) {echo "active";}?>">


	<a href="#">
		<img height="20" src="<?php echo base_url().'assets/theme_admin/img/laporan.png'; ?>">
		<span>Laporan</span>
		<i class="fa fa-angle-left pull-right"></i>
	</a>
	<ul class="treeview-menu">
	<?php if($level != 'pinjaman') { ?>
		<li class="<?php if ($this->uri->segment(1) == 'lap_anggota') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_anggota"><i class="fa fa-folder-open-o"></i> Data Anggota </a></li>
	<?php } ?>
		<li class="<?php if ($this->uri->segment(1) == 'lap_kas_anggota') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lap_kas_anggota"> <i class="fa fa-folder-open-o"></i> Kas Anggota </a></li>

	<?php if($level != 'pinjaman') { ?>
		<li class="<?php if ($this->uri->segment(1) == 'lap_tempo') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_tempo"><i class="fa fa-folder-open-o"></i> Jatuh Tempo </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_macet') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_macet"><i class="fa fa-folder-open-o"></i> Kredit Macet</a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_trans_kas') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_trans_kas"><i class="fa fa-folder-open-o"></i> Transaksi Kas</a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_buku_besar') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_buku_besar"><i class="fa fa-folder-open-o"></i> Buku Besar</a></li>

	<!--	<li class="<?php if ($this->uri->segment(1) == 'lap_neraca') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_neraca"><i class="fa fa-folder-open-o"></i> Neraca Saldo</a></li> -->

		<li class="<?php if ($this->uri->segment(1) == 'lap_simpanan') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lap_simpanan"> <i class="fa fa-folder-open-o"></i> Kas Simpanan </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_kas_pinjaman') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>lap_kas_pinjaman"> <i class="fa fa-folder-open-o"></i> Kas Pinjaman </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_saldo') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_saldo"><i class="fa fa-folder-open-o"></i> Saldo Kas </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_laba') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_laba"><i class="fa fa-folder-open-o"></i> Laba Rugi </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_shu') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_shu"><i class="fa fa-folder-open-o"></i> SHU </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_jurnalumum') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_jurnalumum"><i class="fa fa-folder-open-o"></i> Jurnal Umum </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_trialbalance') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_trialbalance"><i class="fa fa-folder-open-o"></i> Trial Balance </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_fixed') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_fixed"><i class="fa fa-folder-open-o"></i> Fixed Asset </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_jurnal') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_jurnal"><i class="fa fa-folder-open-o"></i> Jurnal </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'lap_balance') { echo 'active'; } ?>"> <a href="<?php echo base_url(); ?>lap_balance"><i class="fa fa-folder-open-o"></i> Balance Sheet </a></li>

		<?php } ?>
	</ul>
</li>

<?php if($level != 'pinjaman') { ?>
<!-- Master data -->
<li  class="treeview <?php
$menu_data_arr= array('jenis_pinjaman','jenis_simpanan','jenis_kas','grup_akun','akun','jenis_angsuran','data_barang','anggota','user');
if(in_array($this->uri->segment(1), $menu_data_arr)) {echo "active";}?>">

<a href="#">
	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/data.png'; ?>">
	<span>Master Data</span>
	<i class="fa fa-angle-left pull-right"></i>
</a>
<ul class="treeview-menu">
	<?php if($level == 'admin') { ?>
		<li class="<?php if ($this->uri->segment(1) == 'jenis_pinjaman') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_pinjaman"> <i class="fa fa-folder-open-o"></i> Jenis Pinjaman </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'jenis_simpanan') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_simpanan"> <i class="fa fa-folder-open-o"></i> Jenis Simpanan </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'jenis_kas') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_kas"> <i class="fa fa-folder-open-o"></i> Jenis Kas </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'jenis_angsuran') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>jenis_angsuran"> <i class="fa fa-folder-open-o"></i> Lama Angsuran </a></li>

	  <?php } ?>
  	<li class="<?php if ($this->uri->segment(1) == 'data_barang') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>data_barang"> <i class="fa fa-folder-open-o"></i> Data Barang </a></li>

  	<li class="<?php if ($this->uri->segment(1) == 'anggota') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>anggota"> <i class="fa fa-folder-open-o"></i> Data Anggota</a></li>

		<li class="<?php if ($this->uri->segment(1) == 'grup_akun') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>grup_akun"> <i class="fa fa-folder-open-o"></i> Grup C.O.A </a></li>

		<li class="<?php if ($this->uri->segment(1) == 'akun') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>akun"> <i class="fa fa-folder-open-o"></i> Chart Of Account (C.O.A)</a></li>


  	<?php if($level == 'admin') { ?>
		<li class="<?php if ($this->uri->segment(1) == 'user') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>user"> <i class="fa fa-folder-open-o"></i> Data Pengguna </a></li>
	<?php } ?>
</ul>
</li>
<?php } ?>

<!-- MENU Setting -->
<?php if($level == 'admin') { ?>
<li  class="treeview <?php
$menu_sett_arr= array('profil','suku_bunga');
if(in_array($this->uri->segment(1), $menu_sett_arr)) {echo "active";}?>">

<a href="#">
	<img height="20" src="<?php echo base_url().'assets/theme_admin/img/settings.png'; ?>">
	<span>Setting</span>
	<i class="fa fa-angle-left pull-right"></i>
</a>

<ul class="treeview-menu">
	<li class="<?php if ($this->uri->segment(1) == 'profil') { echo 'active'; } ?>"><a href="<?php echo base_url(); ?>profil"> <i class="fa fa-folder-open-o"></i> Identitas Koperasi </a></li>

	<li class="<?php if ($this->uri->segment(1) == 'suku_bunga') { echo 'active'; } ?>">  <a href="<?php echo base_url(); ?>suku_bunga"> <i class="fa fa-folder-open-o"></i> Suku Jasa Pinjaman </a></li>
</ul>
</li>
<?php } ?>

</ul>
