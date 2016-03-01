<?php
$title_1 = "Pengaturan Akademik";
$state_navbar = "akademik_pengaturan"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";
?>
<div class="row">
	<div class="col-md-3">
	</div>
	<div class="col-md-6">
		<div class="the-box no-border">
			<h2 class="text-center">
				Tahun Ajaran <?php echo $_SESSION['TA'] . "<br />Semester" . $_SESSION['semester'];?>
				<br />
				<br />
				<div class="btn-group">
					<a href="?p=home" class="btn btn-default" type="button"><i class="fa fa-chevron-left" style="color: #3498db;"></i>&nbsp; Kembali </a>
				</div>
				<button class="btn btn-info btn-md"  data-toggle="modal" data-target="#ModalTA">
					Ganti Tahun Ajaran
				</button>
			</h2>
			<hr />
			<h3>
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-8">
						<button class="btn btn-info btn-lg btn-block text-center" style="font-size:20px;">
							Tahun Ajaran & Kurikulum
						</button>
						<br />
						<button class="btn btn-info btn-lg btn-block text-center" style="font-size:20px;">
							Format Cetak Rapot
						</button>
						<br />
						<button class="btn btn-info btn-lg btn-block text-center" style="font-size:20px;">
							Tanggal Penting Input
						</button>
					</div>
					<div class="col-md-2">
					</div>
				</div>
		</div>
	</div>
	<div class="col-md-3">
	</div>
</div>