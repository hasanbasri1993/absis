<?php
$title_1 = "Data Umum Guru";
$state_navbar = "data_umum_guru"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";
?>
<div class="row">
	<div class="col-sm-1 col-md-2">
	</div>
	<div class="col-sm-10 col-md-8">
		<div class="the-box no-border">
			<div class="row">
				<div class="col-md-4 col-sm-3">
					<div class="form-group text-center" style="margin-top: 23px;margin-bottom: 23px;">
						<input type="text" id="search-guru" class="form-control bold-border search-guru" placeholder="Cari Guru">
					</div>
				</div>
				<div class="col-md-8 col-sm-3 text-right">
					<div class="page-numb">
						<ul class="pagination square">
							<li class="active"><a href="#">0</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="table-responsive">
			<table class="table table-striped table-hover table-info table-th-block">
				<thead class="the-box dark full">
					<tr>
						<th class="text-left" style="width:">No.</th>
						<th class="text-left" style="width: 46%;">Nama</th>
						<th class="text-left" style="width: 17%;">NIP</th>
						<th class="text-center" style="width: %;">state</th>
						<th class="text-center" style="width: 5%;">Ubah</th>
						<th class="text-center" style="width: 5%;">Hapus</th>									
					</tr>
				</thead>
				<tbody id="data-guru-tabel">
				<tr>
					<td colspan='8' class="text-center">
						<h3>Sedang Mengambil Data...</h3>
					</td>					
				</tr>
				</tbody>
			</table>
			</div>
		</div>
	</div>
	<div class="col-sm-1 col-md-2">
	</div>
</div>
<div class="modal fade" id="ModalUbahGuru" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 5vh; overflow:hidden;">
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header bg-info no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center">Ubah Data Guru</h3>
			</div>
			<div class="modal-body" style="color: rgba(1,1,1,0.6); max-height: 60vh; overflow:auto;" >
				<div class="row">
					<div class="col-md-12 col-sm-6">
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">
									<h4>
										NIP
									</h4>
								</div>
								<div class="col-md-5">
									<input type="text" class="ubah-nip-guru form-control input-md bold-border" placeholder="Placeholder here">
								</div>
								<div class="col-md-5">
									<div class="row">
										<div class="col-md-6">
											<div class="text-center">
												<button class="btn btn-info">
													tombol 1
												</button>
											</div>
										</div>
										<div class="col-md-6">
											<div class="text-center">
												<button class="btn btn-info">
													tombol 2
												</button>
											</div>
										</div>
									
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">
									<h4>
										Nama
									</h4>
								</div>
								<div class="col-md-6">
									<input type="text" class="ubah-nama-guru form-control input-md bold-border" placeholder="Placeholder here">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">
									<h4>
										KTSP
									</h4>
								</div>
								<div class="col-md-6">
									<input type="text" class="ubah-ktsp-guru form-control input-md bold-border" placeholder="Placeholder here">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">
									<h4>
										K2013
									</h4>
								</div>
								<div class="col-md-6">
									<input type="text" class="ubah-k2013-guru form-control input-md bold-border" placeholder="Placeholder here">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
				<button type="button" class="btn btn-info ubah-guru-save" data-dismiss="modal">Simpan</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalHapusGuru" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 15%;">
		<div class="modal-content">
			<div class="modal-header bg-danger no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Hapus Guru</h4>
			</div>
			
			<div class="modal-body" style="color: rgba(1,1,1,0.6);">
				<h3 class="text-center">Hapus Guru <span class="hapus-guru-nip-text"></span> - <span class="hapus-guru-nama-text"></span></h3>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
				<button type="button" class="btn btn-danger hapus-guru-konfirmasi" data-dismiss="modal">Hapus</button>
			</div>

		</div>
	</div>
</div>
