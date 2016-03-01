<?php
$title_1 = "Input Nilai " . $_GET['nip'];
$state_navbar = "input_nilai_pilih_kelas"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";
include_once "model/class/master.php";
//echo $_GET['nip'];
$nip = $_GET['nip'];
$guru = new Guru($_GET['nip']);
$title_1 = $guru->getNamaMapel('ktsp');
$kel7 = "";
$kel8 = "";
$kel9 = "";
$content_kel7 = "";
$content_kel8 = "";
$content_kel9 = "";
$button_content_7 = "";
$button_content_8 = "";
$button_content_9 = "";
$button_k13 = "
<div class='right-button'>
	<button class='btn btn-info btn-lg' type='submit'>S</button>
	<button class='btn btn-info btn-lg' type='submit'>K</button>
	<button class='btn btn-info btn-lg' type='submit'>P</button>
</div>
";
$button_ktsp = "
<div class='right-button'>
	<button class='btn btn-info' type='submit'>Input <i class='fa fa-chevron-right'></i></button>
</div>
";
$guru = new Guru($nip);
$data_kelas = $guru -> getHanyaKelas();
foreach($data_kelas as $show_data_kelas){

	$list_kelas = $show_data_kelas['kelas'];
	$kelas = new Kelas($list_kelas);
	$kurikulum=$kelas->getKurikulum();
	if ($kurikulum == "ktsp"){

		if ($list_kelas == "7") {

			$button_content_7 = $button_ktsp;
		} elseif ($list_kelas == "8") {

			$button_content_8 = $button_ktsp;
		} elseif ($list_kelas == "9") {

			$button_content_9 = $button_ktsp;
		}


	} elseif ($kurikulum == "k13") {

		if ($list_kelas == "7") {

			$button_content_7 = $button_k13;
		} elseif ($list_kelas == "8") {

			$button_content_8 = $button_k13;
		} elseif ($list_kelas == "9") {

			$button_content_9 = $button_k13;
		}
	} else {
		echo "N/A";
	}

	$data_subkelas = $guru -> getSubkelas("$list_kelas");
	foreach($data_subkelas as $show_data_subkelas){

		$list_subkelas = $show_data_subkelas['subkelas'];

		if ($list_kelas == "7") {
			$kel7 = "1";
			$kelas_subkelas = "$list_kelas$list_subkelas";
			$content_kel7 = $content_kel7 . "
			<div class='the-box no-border'>
				<form method='GET' action='?p=input_nilai_proses'>
					<div class='media user-card-sm'>
						<a href='#' class='pull-left'>
							<i class='fa icon-square icon-md icon-danger'>
								<p style='font-family: lato;'>$list_subkelas</p>
							</i>
							<input type='hidden' value='input_nilai_proses' id='a' name='p'>
							<input type='hidden' value='$kelas_subkelas' id='kelas' name='kelas'>
							<input type='hidden' value='$nip' id='nip' name='nip'>
						</a>
						" . $button_content_7 . "
					</div>
				</form>
			</div>
			";
		} elseif ($list_kelas == "8") {
			$kel8 = "1";
			$kelas_subkelas = "$list_kelas$list_subkelas";
			$content_kel8 = $content_kel8 . "
			<div class='the-box no-border'>
				<form method='GET' action='?p=input_nilai_proses'>
					<div class='media user-card-sm'>
						<a href='#' class='pull-left'>
							<i class='fa icon-square icon-md icon-warning'>
								<p style='font-family: lato;'>$list_subkelas</p>
							</i>
							<input type='hidden' value='input_nilai_proses' id='a' name='p'>
							<input type='hidden' value='$nip' id='nip' name='nip'>
							<input type='hidden' value='$kelas_subkelas' id='kelas' name='kelas'>
						</a>
						" . $button_content_8 . "
					</div>
				</form>
			</div>
			";
		} elseif ($list_kelas == "9") {
			$kel9 = "1";
			$kelas_subkelas = "$list_kelas$list_subkelas";
			$content_kel9 = $content_kel9 . "
			<div class='the-box no-border'>
				<form method='GET' action='?p=input_nilai_proses'>
					<div class='media user-card-sm'>
						<a href='#' class='pull-left'>
							<i class='fa icon-square icon-md icon-success'>
								<p style='font-family: lato;'>$list_subkelas</p>
							</i>
							<input type='hidden' value='input_nilai_proses' id='a' name='p'>
							<input type='hidden' value='$nip' id='nip' name='nip'>
							<input type='hidden' value='$kelas_subkelas' id='kelas' name='kelas'>
						</a>
						" . $button_content_9 . "
					</div>
				</form>
			</div>
			";
		} else {
			echo "Kesalahan Sistem, Harap Hubungi Admin";
		}
		//echo $list_kelas.$list_subkelas;
	}
}
?>
<div class="row">
	<?php
	if ($kel7 == "1"){

		?>
		<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
		</div>
		<div class="col-sm-5 col-md-4 col-lg-3" id="7">
			<div class="the-box bg-danger no-border card-info text-center" style="z-index: 0">
				<h4><br></h4>
				<h1><i class="fa fa-bank icon-square icon-lg icon-danger"></i></h1>
				<h1>KELAS 7</h1>
				<p>&nbsp; </p>
			</div>
		</div>
		<div class="col-sm-5 col-md-4 col-lg-3">
			<?php
			echo $content_kel7;
			?>
		</div>
		<?php
	}
	?>
</div>
<div class="row">
	<?php
	if ($kel8 == "1"){

		?>
		<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
		</div>
		<div class="col-sm-5 col-md-4 col-lg-3" id="8">
			<div class="the-box bg-warning no-border card-info text-center" style="z-index: 0">
				<h4><br></h4>
				<h1><i class="fa fa-bank icon-square icon-lg icon-warning"></i></h1>
				<h1>KELAS 8</h1>
				<p>&nbsp; </p>
			</div>
		</div>
		<div class="col-sm-5 col-md-4 col-lg-3">
			<?php
			echo $content_kel8;
			?>
		</div>
		<?php
	}
	?>
</div>
<div class="row">
	<?php
	if ($kel9 == "1"){

		?>
		<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
		</div>
		<div class="col-sm-5 col-md-4 col-lg-3" id="9">
			<div class="the-box bg-success no-border card-info text-center" style="z-index: 0">
				<h4><br></h4>
				<h1><i class="fa fa-bank icon-square icon-lg icon-success"></i></h1>
				<h1>KELAS 9</h1>
				<p>&nbsp; </p>
			</div>
		</div>
		<div class="col-sm-5 col-md-4 col-lg-3">
			<?php
			echo $content_kel9;
			?>
		</div>
		<?php
	}
	?>
</div>
