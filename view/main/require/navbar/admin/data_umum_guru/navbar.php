<div class="the-box no-border" style="padding--right: 0px; padding--left: 0px; background: #FBFBFB; margin-bottom: 0px; padding-bottom: 0px;">
	<h2 class="page-heading text-center" style="margin-top: 0px; margin-bottom: 0px;">
	<?php echo $title_1;?>
	</h2>
</div>
<div class="the-box toolbar no-border no-margin text-center" style="padding-bottom: 20px; padding-top: 0px; margin-bottom: 30px; margin-top: 0px; border-bottom-width: 0px; background: #FBFBFB">
	<div class="row" style="margin-top: 0px; padding-top: 20px; padding-bottom: 0px;">
		<div class="col-md-3 col-sm-3">
		</div>
		<div class="col-md-3 col-sm-3" style="padding-top: 0px; padding-bottom: 0px;">
			<div class="btn-group">
				<a class="btn btn-default" href="?p=home" type="button"><i class="fa fa-chevron-left" style="color: #3498db;"></i>&nbsp; Kembali</a>
			</div>
			<div class="btn-group">
				<a class="btn btn-default" href="?p=home" type="button"><i class="fa fa-home" style="color: #3498db;"></i>&nbsp; Home</a>
			</div>
			&nbsp; &nbsp;			
		</div>
		<div style="margin-bottom: 0px; padding-bottom: 0px;" class="col-md-4 col-sm-4">							
			<div class="btn-group inline-popups">
				<button type="button" class="btn btn-success tambah-guru-btn" data-toggle="modal" data-target="#ModalTambahGuru">Tambah Guru</button>
			</div>
			<div class="btn-group">
				<button type="button" class="btn btn-success">Input Lewat Excel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalTambahGuru" tabindex="-1" role="dialog" aria-hidden="true" style="margin-top: 5vh; overflow:hidden;">
	<div class="modal-dialog">
		<div class="modal-content" >
			<div class="modal-header bg-info no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center">Tambah Data Guru</h3>
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
								<div class="col-md-3">
									<input type="text" class="tambah-nip-guru form-control input-md bold-border" placeholder="Placeholder here">
								</div>
								<div class="col-md-7">
									<div class="row">
										<div class="col-md-4">
											<div class="text-center">
												<button class="btn btn-info">
													tombol 1
												</button>
											</div>
										</div>
										<div class="col-md-4">
											<div class="text-center">
												<button class="btn btn-info">
													tombol 2
												</button>
											</div>
										</div>
										<div class="col-md-4">
											<div class="text-center">
												<button class="btn btn-info">
													tombol 3
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
									<input type="text" class="tambah-nama-guru form-control input-md bold-border" placeholder="Placeholder here">
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
									<input type="text" class="tambah-nama-guru form-control input-md bold-border" placeholder="Placeholder here">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-2">
									<h4>
										K 2013
									</h4>
								</div>
								<div class="col-md-6">
									<input type="text" class="tambah-k2013-guru form-control input-md bold-border" placeholder="Placeholder here">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
				<button type="button" class="btn btn-info tambah-guru-proses" data-dismiss="modal">Simpan</button>
			</div>
		</div>
	</div>
</div>
