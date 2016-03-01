<?php
$title_1 = "Dewa<sup>ne</sup> Admin";
$state_navbar = "home"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";
?>
<div class="row">
	<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">				
		<div class="panel panel-info panel-square panel-no-border text-center">
		  <div class="panel-body bg-info">
			<h2>Akademik</h2>
			<hr />
			<div class="row">
				<div class="col-sm-3 col-md-2">
				</div>
				<div class="col-sm-6 col-md-8">
					<a href="?p=akademik_penugasan_guru" class="btn  btn-info btn-block btn-round" style="color: white;"><strong>PENUGASAN GURU</strong></a>
				</div>
			</div>
			<div class="row" style="margin-top: 5px; margin-bottom: 5px;">
				<div class="col-sm-3 col-md-2">
				</div>
				<div class="col-sm-6 col-md-8">
					<a href="?p=akademik_penempatan_siswa" class="btn  btn-info btn-block btn-round" style="color: white;"><strong>PENEMPATAN SISWA</strong></a>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3 col-md-2">
				</div>
				<div class="col-sm-6 col-md-8">
					<a href="?p=akademik_pengaturan" class="btn  btn-info btn-block btn-round" style="color: white;"><strong>PENGATURAN</strong></a>
				</div>
			</div>				
		  </div>
		</div>
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">				
		<div class="panel panel-info panel-square panel-no-border text-center">
		  <div class="panel-body bg-info">
			<h2>Data Umum</h2>
			<hr />
			<div class="row">
				<div class="col-sm-3 col-md-3">
				</div>
				<div class="col-sm-6 col-md-6">
					<a href="?p=data_umum_siswa" class="btn  btn-warning btn-block btn-round" style="color: white;"><strong>SISWA</strong></a>
				</div>
			</div>
			<div class="row" style="margin-top: 5px; margin-bottom: 5px;">
				<div class="col-sm-3 col-md-3">
				</div>
				<div class="col-sm-6 col-md-6">
					<a href="?p=data_umum_guru" class="btn  btn-warning btn-block btn-round" style="color: white;"><strong>GURU</strong></a>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3 col-md-3">
				</div>
				<div class="col-sm-6 col-md-6">
					<a href="?p=data_umum_sekolah" class="btn  btn-warning btn-block btn-round" style="color: white;"><strong>SEKOLAH</strong></a>
				</div>
			</div>				
		  </div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">				
		<div class="panel panel-info panel-square panel-no-border text-center">

		  <div class="panel-body bg-info">
			<h2>Input Nilai</h2>
			<hr />
			<p>
				Masukkan Semua Nilai Siswa
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
				Lihat Semua Nilai Siswa
			</p>					
		  </div>
			<a href="?p=lihat_nilai" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-2 col-md-4">
	</div>
	<div class="col-sm-8 col-md-4">				
		<div class="panel panel-info panel-square panel-no-border text-center">
		  <div class="panel-body bg-info">
			<h2 style="margin-top: 10px;">Pilihan Download</h2>
			<hr />
			<p>
				Download Rapor, Ledger Kelas, Ledger Mapel
		  </div>
			<a href="?p=pilihan_download" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
		</div>
	</div>
</div>