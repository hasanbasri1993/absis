<?php
$title_1 = "FISIKA";
$title_2 = "SMPN 1 SEMARANG";
$state_navbar = "home"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";
?>
<div class="row">
	<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">				
		<div class="panel panel-info panel-square panel-no-border text-center">
		  <div class="panel-body bg-info">
			<h2>Input Nilai</h2>
			<hr />
			<p>
				Masukkan Nilai Siswa
			</p>					
		  </div>
			<a href="?p=input_nilai" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
		</div>
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">				
		<div class="panel panel-info panel-square panel-no-border text-center">
		  <div class="panel-body bg-info">
			<h2>Lihat Nilai</h2>
			<hr />
			<p>
				Lihat Nilai Siswa
			</p>					
		  </div>
			<a href="?p=lihat_nilai" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">				
		<div class="panel panel-info panel-square panel-no-border text-center">
		  <div class="panel-body bg-info">
			<h3 style="margin-top: 10px;">Download Ledger Kelas</h3>
		  </div>
			<a href="?p=download_ledger_kelas" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
		</div>
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">				
		<div class="panel panel-info panel-square panel-no-border text-center">
		  <div class="panel-body bg-info">
			<h3 style="margin-top: 10px;">Download Ledger Mapel</h3>
		  </div>
			<a href="?p=download_ledger_mapel" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-2 col-md-4">
	</div>
	<div class="col-sm-8 col-md-4">				
		<div class="panel panel-info panel-square panel-no-border text-center">
		  <div class="panel-body bg-info">
			<h2 style="margin-top: 10px;">Cetak Rapor</h2>
		  </div>
			<a href="?p=cetak_rapor" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
		</div>
	</div>
</div>