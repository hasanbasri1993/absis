<?php
include_once "model/class/master.php";
$nip = $_SESSION['username'];
$title_1 =  "Penilaian Sikap " . $_GET['kelas'];
?>
<div class="the-box no-border" style="padding--right: 0px; padding--left: 0px; background: #FBFBFB; margin-bottom: 0px; padding-bottom: 0px;">
	<h2 class="page-heading text-center" style="margin-top: 0px; margin-bottom: 0px;">
		<?php echo $title_1; ?>
	</h2>
</div>
<!-- <div class="the-box toolbar no-border no-margin text-center" style="padding-bottom: 0px; padding-top: 0px; margin-bottom: 0px; margin-top: 0px; border-bottom-width: 0px; background: none repeat scroll 0% 0% rgb(251, 251, 251);">
	<div class="row" style="margin-top: 0px; padding-top: 20px; padding-bottom: 0px;">
		<div class="col-md-2">
		</div>
		<div class="col-md-3" style="padding-top: 0px; padding-bottom: 20px;">
			<div class="btn-group">
				<a class="btn btn-default " href="?p=penilaian_sikap" type="button" style="color: #3498db;"><i class="fa fa-chevron-left"></i>&nbsp; </a>
			</div>
			<div class="btn-group">
				<a class="btn btn-default" href="?p=home" type="button"><i class="fa fa-home" style="color: #3498db;"></i>&nbsp;</a>
			</div>
			&nbsp; &nbsp;
			<div class="btn-group">
				<button data-toggle="dropdown" class="btn btn-danger dropdown-toggle" type="button">
				  	Pilih Kelas
				  	<span class="caret"></span>
				</button>
				<ul class="dropdown-menu danger">
					<?php
					// $array_show_kelas = $_SESSION['session_kelas_tersedia'];
					// foreach($array_show_kelas as $list){
					// 	echo "<li><a href='?p=input_nilai_proses&kelas=$list'>$list</a></li>";
					// }
					?>			 		
				</ul>
		 	</div>
		</div>
		<div class="col-md-2">
			<div class="btn-group">
				<div class="btn-group">
					<button class="btn btn-info inline-popups" data-toggle="modal" data-target="#ModalTombolSakti" >
					  	<p id="status" style="margin:0px;">OK</p>
					</button>
			 	 </div>
			</div>	
		</div>
	</div>
</div>

<div class="modal fade" id="ModalTombolSakti" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 15%;">
		<div class="modal-content">
			<div class="modal-header bg-info no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center">Hello</h3>
			</div>
			<div class="modal-body"style="color: rgba(1,1,1,0.6);">					
				<h3 class="text-center">
					 . Tombol Sakti .
				</h3>
				<br />
			</div>	
			<div class="modal-footer">
				<a type="button" class="btn btn-default" data-dismiss="modal">Keluar</a>
			</div>
		</div>
	</div>
</div> -->
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
						echo "<li><a href='?p=penilaian_sikap_jenis&kelas=$list'>$list</a></li>";
					}
					?>			 		
				</ul>
		 	</div>
		</div>
	</div>
</div>