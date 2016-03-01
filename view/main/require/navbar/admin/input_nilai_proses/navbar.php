<?php
include_once "model/class/master.php";
$nip = $_GET['nip'];
$guru = new Guru($_GET['nip']);
$title_1 = $guru->getNamaMapel('ktsp').' '.$_GET['kelas'];
?>
<div class="the-box no-border" style="padding--right: 0px; padding--left: 0px; background: #FBFBFB; margin-bottom: 0px; padding-bottom: 0px;">
	<h2 class="page-heading text-center" style="margin-top: 0px; margin-bottom: 0px;">
		<?php echo $title_1; ?>
	</h2>
</div>
<div class="the-box toolbar no-border no-margin text-center" style="padding-bottom: 0px; padding-top: 0px; margin-bottom: 0px; margin-top: 0px; border-bottom-width: 0px; background: none repeat scroll 0% 0% rgb(251, 251, 251);">
	<div class="row" style="margin-top: 0px; padding-top: 20px; padding-bottom: 0px;">
		<div class="col-md-2">
		</div>
		<div class="col-md-3" style="padding-top: 0px; padding-bottom: 20px;">
			<div class="btn-group">
				<a class="btn btn-default " href='?p=input_nilai_pilih_kelas<?php echo "&nip=".$nip;?>' type="button" style="color: #3498db;"><i class="fa fa-chevron-left"></i>&nbsp; </a>
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
					$array_show_kelas = $_SESSION['session_kelas_tersedia'];
					foreach($array_show_kelas as $list){
						echo "<li><a href='?p=input_nilai_proses&nip=$nip&kelas=$list'>$list</a></li>";
					}
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
		<div class="col-md-3" style="margin-bottom: 0px; padding-bottom: 20px;">							
			<div class="btn-group">
				<div class="btn-group">
					<button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button">
					  	Edit Topik
					  	<span class="caret"></span>
					</button>
					<ul class="dropdown-menu success inline-popups">
					<?php
					$array_show_topik = array();
					// array_push($array_show_topik, "turu");
					// array_push($array_show_topik, "turuu");
					// array_push($array_show_topik, "turuuu");
					// array_push($array_show_topik, "turuuuu");
					// $size_array_show_topik = count($array_show_topik);
					$nip          = $_GET['nip'];
					$guru         = new Guru($nip);
					$kelas        = new Kelas($_GET['kelas'][0],$_GET['kelas'][1]);
					$mapel        = new Mapel($guru->getKodeMapel($kelas->getKurikulum()),$_GET['kelas'][0],$_GET['kelas'][1]);
					$daftarTopik  = $mapel->getTopik();
					$count=0;
					$banyakTopik  = sizeof($daftarTopik);

					if (sizeof($daftarTopik) != 0){
						while ($count<$banyakTopik) {
							if ($daftarTopik[$count]['afterUTS']=="1") {
								$daftarTopik[$count]['afterUTS']="setelah";
							}else{
								$daftarTopik[$count]['afterUTS']="sebelum";
							}

							echo "
							<li>
								<a class='edit-topik' topik-id='".$daftarTopik[$count]['topik_id']."' topik-nama='".$daftarTopik[$count]['topik_nama']."' topik-singkatan='".$daftarTopik[$count]['topik_nama_singkat']."' edit-uts='".$daftarTopik[$count]['afterUTS']."' data-toggle='modal' data-target='#ModalEditTopik'>
									".$daftarTopik[$count]['topik_nama']."[".$daftarTopik[$count]['topik_id']."]
								</a>
							</li>
							";
							$count++;
						}
					} else{
						echo "
							<li>
								<a>
									Topik Belum Ditambahkan
								</a>
							</li>
							";
					}					
					?>
					</ul>
			 	 </div>
			</div>	
			<button class="btn btn-success inline-popups" data-toggle="modal" data-target="#ModalTambahTopik" >Tambah Topik</button>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalTambahTopik" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 10%;">
		<div class="modal-content">
			<form method="GET">
				<input type="hidden" name="sajen" value="input_nilai_tambah_topik">
				<input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI'];?>">
				<input type="hidden" name="kelas" value="<?php echo $_GET['kelas'][0];?>">
				<input type="hidden" name="subkelas" value="<?php echo $_GET['kelas'][1];?>">
				<input type="hidden" name="nip" value="<?php echo $nip;?>">
				<div class="modal-header bg-success no-border">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title text-center">Tambah Topik</h3>
				</div>
				<div class="modal-body"style="color: rgba(1,1,1,0.6);">
					<div class="row">
						<div class="col-md-2">
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label>Nama Topik</label>
								<input name="topik" type="text" class="form-control" required>
								<p class="help-block"></p>
							</div>
							<div class="form-group">
								<label>Nama Topik Singkatan (10 Karakter)</label>
								<input name="topik_singkat" type="text" class="form-control" maxlength="10" required>
								<p class="help-block">Ini digunakan hanya untuk memudahkan pengunaan excel</p>
							</div>
							<p>Pilihan Tambah Topik</p>
							<div class="radio">
								<label>
									<input type="radio" value="sebelum" class="i-grey-square" name="UTS" checked>
									Sebelum UTS
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" value="setelah" class="i-grey-square" name="UTS">
									Setelah UTS
								</label>
							</div>							
						</div>
						<div class="col-md-2">
						</div>												
					</div>
				</div>
				<div class="modal-footer">
					<a type="button" class="btn btn-default" data-dismiss="modal">Tidak</a>
					<button type="submit" class="btn btn-success">Simpan</button>

				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="ModalEditTopik" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 10%;">
		<div class="modal-content">
			<div class="modal-header bg-success no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center">Edit Topik</h3>
			</div>
			<form>
				<input type="hidden" name="sajen" value="input_nilai_edit_topik_proses">
				<input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI'];?>">
				<input type="hidden" name="kelas" value="<?php echo $_GET['kelas'][0];?>">
				<input type="hidden" name="subkelas" value="<?php echo $_GET['kelas'][1];?>">

				<div class="modal-body"style="color: rgba(1,1,1,0.6);">					
					<div class="row daftar-isi-edit-topik">
						<div class="col-md-2">
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label>Nama Topik</label>
								<input name="topik" type="text" class="form-control" placeholder="sedang mengambil data..."required>
								<p class="help-block"></p>
							</div>
							<div class="form-group">
								<label>Nama Topik Singkatan (10 Karakter)</label>
								<input name="topik_singkat" type="text" placeholder="sedang mengambil data..." class="form-control " maxlength="10" required>
								<p class="help-block">Ini digunakan hanya untuk memudahkan pengunaan excel</p>
							</div>
							<p>Pilihan Tambah Topik</p>
							<div class="radio">
								<label>
									<input type="radio" value="sebelum" class="i-grey-square edit_UTS" name="UTS" checked>
									Sebelum UTS
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" value="setelah" class="i-grey-square edit_UTS" name="UTS">
									Setelah UTS
								</label>
							</div>			
						</div>
						<div class="col-md-2">
						</div>
					</div>					
				</div>
				<div class="modal-footer">
					<a type="button" class="btn btn-default" data-dismiss="modal">Tidak</a>
					<button type="submit" class="btn btn-success">Simpan</button>
					<a type="button" class="btn btn-danger hapus-topik">Hapus</a>

				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 15%;">
		<div class="modal-content">
			<div class="modal-header bg-danger no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center">Hapus Topik</h3>
			</div>
			<div class="modal-body"style="color: rgba(1,1,1,0.6);">					
				<h3 class="text-center">
					Apakah Anda Yakin Akan Menghapus Topik Ini ?
				</h3>
				<br />
			</div>	
			<div class="modal-footer">
				<a type="button" class="btn btn-default" data-dismiss="modal">Tidak</a>
				<a type="button" class="btn btn-danger konfirmasi-hapus-topik">Hapus</a>
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
</div>