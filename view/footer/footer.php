<?php
if($_GET['p']=="input_nilai_proses"){
?>
<footer class="bg-home" style="position: fixed; right: 0; left: 0; bottom: 0; background: #2980b9; line-height: 67%; z-index: 1024;padding-top: 3px;padding-bottom: 3px;">
	<div class="row">
		<div class="col-md-3 col-sm-3 col-xs-3">
			<div class="text-left">
				<button class="btn btn-info btn-sm"  data-toggle="modal" data-target="#ModalBantuanFooter" style="color:#fff;border: 0px;margin-top: 10px;margin-bottom: 10px;"><i class="fa fa-question-circle"></i> Bantuan</button>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="text-center inline-popups">
				<button class="btn btn-warning active btn-perspective" data-toggle="modal" data-target="#ModalDownload" style="border: 0px;margin-top: 4px;margin-bottom: 4px;padding-top: 10px;padding-bottom: 10px;">Donwload Sebagai Excel</button>
			</div>
		</div>
		<div class="col-md-3 col-sm-3 col-xs-3">			
		</div>
	</div>
</footer>
<div class="modal fade" id="ModalDownload" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 15%;">
		<div class="modal-content">
			<div class="modal-header bg-warning no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-center">Download Excel</h4>
			</div>
			<div class="modal-body"style="color: rgba(1,1,1,0.6);">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel-body bg-info">
							<h4 class="text-center"><strong>Kelas Ini</strong></h4>
							<hr>
							<p class="text-center">Hanya mengunduh draft nilai kelas <?php echo $_GET['kelas'];?> saja</p>
							<a href="?sajen=download_daftar_nilai&kelas=<?php echo $_GET['kelas'];?>" class="btn  btn-success btn-block btn-round" style="color: white;"><strong>UNDUH</strong></a>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel-body bg-info">
							<h4 class="text-center"><strong>Semua Kelas</strong></h4>
							<hr>
							<p class="text-center">Mengunduh draft nilai semua kelas yang anda ajar</p>
							<a href="?sajen=download_daftar_nilai&kelas=all" class="btn  btn-success btn-block btn-round" style="color: white;"><strong>UNDUH</strong></a>
						</div>
					</div>					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Keluar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="ModalBantuanFooter" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 15%;">
		<div class="modal-content">
			<div class="modal-header bg-info no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center">Bantuan</h3>
			</div>
			<div class="modal-body"style="color: rgba(1,1,1,0.6);">
				<h3 class="text-center">Bantuan Untuk Halaman <?php echo $title_1;?></h3>
				<?php
				echo md5(uniqid("a", true));
				?>				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Keluar</button>
			</div>
		</div>
	</div>
</div>

<!-- <footer class="bg-home" style="position: fixed; right: 0; left: 0; bottom: 0; background: #2980b9; line-height: 67%; z-index:1024;">
	<div class="th-box no-border transparent text-center">
		<button class="btn btn-warning">Donwload Sebagai Excel</button>
	</div>
</footer> -->
<?php
} else {
?>
<footer class="bg-home" style="position: fixed; right: 0; left: 0; bottom: 0; background: #2980b9; line-height: 67%; z-index: 1024;padding-top: 3px;padding-bottom: 3px;">
	<div class="row">
		<div class="col-md-3 col-sm-3 col-xs-3">
			<div class="text-left">
				<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalBantuanFooter" style="color:#fff;border: 0px;margin-top: 3px;margin-bottom: 2px;"><i class="fa fa-question-circle"></i> Bantuan</a>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="text-center">
				<a class="btn btn-info btn-md" style="border: 0px; color: #fff; background: rgb(41,128,185);padding-top: 4px;padding-bottom: 4px;margin-top: 3px;margin-bottom: 2px;">
					© 2015 Bimadev
				</a>
			</div>
		</div>
		<div class="col-md-3 col-sm-3 col-xs-3">			
		</div>
	</div>
</footer>
<div class="modal fade" id="ModalBantuanFooter" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 15%;">
		<div class="modal-content">
			<div class="modal-header bg-info no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center">Bantuan</h3>
			</div>
			<div class="modal-body"style="color: rgba(1,1,1,0.6);">
				<h3 class="text-center">Bantuan Untuk Halaman <?php echo $title_1;?></h3>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Keluar</button>
			</div>
		</div>
	</div>
</div>
<?php
}
?>