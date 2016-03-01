
<?php
$title_1 = "Bimbingan Konseling";
$state_navbar = "home"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";
?>
<div class="row">
	<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">				
		<div class="panel panel-info panel-square panel-no-border text-center">

		  <div class="panel-body bg-info">
			<h2>Input Kehadiran</h2>
			<hr />
			<p>
				Masukkan Nilai Kehadiran Siswa
			</p>					
		  </div>
			<a href="?p=input_kehadiran" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
		</div>
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">				
		<div class="panel panel-info panel-square panel-no-border text-center">
		  <div class="panel-body bg-info">
			<h2>Penilaian Sikap</h2>
			<hr />
			<p>
				Input Nilai Sikap Siswa
			</p>					
		  </div>
			<a href="?p=penilaian_sikap" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
		</div>
	</div>
</div>
<?php
if ((isset($get_wali))&&($get_wali != null)){
	
	$show_wali_kelas = $get_wali[0][0];
	$show_wali_subkelas = $get_wali[0][1];
	//echo "$show_wali_kelas$show_wali_subkelas";
} else {

	//echo "not wali";
}

if ($get_ekstra != null){
	
	$show_ekstra = $get_ekstra[0][1];
	$show_ekstra_tipe = $get_ekstra[0][2];
	//print_r($_SESSION['array_page_fix']);
	if (isset($get_ekstra[1][1])){


		$ida = $get_ekstra[0][2];
		$idb = $get_ekstra[1][2];
		?>
		<div class="row">
			<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
			</div>
			<div class="col-sm-5 col-md-4 col-lg-3">				
				<div class="panel panel-info panel-square panel-no-border text-center">
				  <div class="panel-body bg-info">
					<h2>Input Nilai <?php echo $get_ekstra[0][1];?></h2>
					<hr />
					<p>
						Masukkan Nilai <?php echo $get_ekstra[0][1];?>
					</p>					
				  </div>
					<a href="?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra&ekstra=<?php echo $ida;?>" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
				</div>
			</div>
			<div class="col-sm-5 col-md-4 col-lg-3">				
				<div class="panel panel-info panel-square panel-no-border text-center">
				  <div class="panel-body bg-info">
					<h2>Input Nilai <?php echo $get_ekstra[1][1];?></h2>
					<hr />
					<p>
						Masukkan Nilai <?php echo $get_ekstra[1][1];?>
					</p>					
				  </div>
					<a href="?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra&ekstra=<?php echo $idb;?>" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
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
		<?php

	} else {
		?>
		<div class="row">
			<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
			</div>
			<div class="col-sm-5 col-md-4 col-lg-3">				
				<div class="panel panel-info panel-square panel-no-border text-center">
				  <div class="panel-body bg-info">
					<h2>Input Nilai <?php echo $show_ekstra;?></h2>
					<hr />
					<p>
						Masukkan Nilai <?php echo $show_ekstra;?>
					</p>					
				  </div>
					<a href="?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
				</div>
			</div>
			<div class="col-sm-5 col-md-4 col-lg-3">				
				<div class="panel panel-info panel-square panel-no-border text-center">
				  <div class="panel-body bg-info">
					<h2>Pilihan Download</h2>
					<hr />
					<p>
						Download Rapor, Ledger, dsb.
					</p>					
				  </div>
					<a href="?p=pilihan_download" class="btn  btn-warning btn-block btn-lg btn-square">MASUK</a>
				</div>
			</div>
		</div>
		<?php
	}

	?>
			
	<?php
} else {
	?>
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
	<?php
}

?>
