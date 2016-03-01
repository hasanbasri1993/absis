<?php
include_once "model/class/master.php";
$nip = $_SESSION['username'];
$guru = new Guru($_SESSION['username']);
$title_1 = "Nilai Kehadiran ". $_GET['kelas'];
?>
<div class="the-box no-border" style="padding--right: 0px; padding--left: 0px; background: #FBFBFB; margin-bottom: 0px; padding-bottom: 0px;">
	<h2 class="page-heading text-center" style="margin-top: 0px; margin-bottom: 0px;">
		<?php echo $title_1; ?>
	</h2>
</div>
<div class="the-box toolbar no-border no-margin text-center" style="padding-bottom: 0px; padding-top: 0px; margin-bottom: 0px; margin-top: 0px; border-bottom-width: 0px; background: none repeat scroll 0% 0% rgb(251, 251, 251);">
	<div class="row" style="margin-top: 0px; padding-top: 20px; padding-bottom: 0px;">
		<div class="col-md-12 text-center" style="padding-top: 0px; padding-bottom: 20px;">
			<div class="btn-group">
				<a class="btn btn-default " href="?p=input_kehadiran" type="button"><i class="fa fa-chevron-left" style="color: #3498db;"></i>&nbsp; Kembali</a>
			</div>
			<div class="btn-group">
				<a class="btn btn-default" href="?p=home" type="button"><i class="fa fa-home" style="color: #3498db;"></i>&nbsp; Home</a>
			</div>
			&nbsp; &nbsp;
			<div class="btn-group">
				<button data-toggle="dropdown" class="btn btn-danger dropdown-toggle" type="button">
				  	Pilih Kelas
				  	<span class="caret"></span>
				</button>
				<ul class="dropdown-menu danger">
					<?php
					$array_show_kelas = $_SESSION['session_kelas_tersedia'];
					foreach($array_show_kelas as $list){
						echo "<li><a href='?p=input_kehadiran_proses&kelas=$list'>$list</a></li>";
					}
					?>			 		
				</ul>
		 	</div>
		</div>
	</div>
</div>