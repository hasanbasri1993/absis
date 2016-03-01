<?php
$title_1 = "Penugasan Guru";
$state_navbar = "akademik_penugasan_guru"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";
?>
<div class="row">
	<div class="col-sm-1 col-md-1">
	</div>
	<div class="col-sm-10 col-md-10">
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
							<th class="text-left" style="width:;">NIP</th>
							<th class="text-left" style="width:;">Nama | Tugas Tambahan</th>
							<th class="text-left" style="width:;">Mapel</th>
							<th class="text-center" style="width:;">Qty Kelas</th>
							<th class="text-center" style="">Penugasan</th>
							<th class="text-center" style="">Tambahan</th>	
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
	<div class="col-sm-1 col-md-1">
	</div>
</div>

<div class="modal fade" id="ModalGuru" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 10%;">
		<div class="modal-content">
			<div class="modal-header bg-success no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center">Kelas yang Diajar</h3>
			</div>
			<div class="modal-body"style="color: rgba(1,1,1,0.6);">
				<div id="TugasGuru">
					
				</div>								
			</div>
			<div class="modal-footer text-center">
				<button type="button" class="btn btn-success" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="ModalTambahan" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 10%;">
		<div class="modal-content">
			<div class="modal-header bg-info no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center"><span class="guru-title"></span></h3>
			</div>
			<div class="modal-body"style="color: rgba(1,1,1,0.6);">
				<div>
					<div class="row">
						<div class="col-md-5">
							<h4 class="text-left">
								Wali Kelas
							</h4>
						</div>
						<div class="col-md-7">
							<div class="form-group">
								<select class="pilih-penugasan-wali form-control" tabindex="1">
									<option value="0">Wali Kelas Tidak Di Set</option>
									<option value="1">Set Wali Kelas</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5">
						</div>
						<div class="col-md-7">
							<div class="content-tipe-penugasan-wali">
							</div>
						</div>
					</div>
					<div>
						<h4 class="text-danger text-center warning-wali">
						</h4>
					</div>
				</div>

					<hr />

				<div>
					<div class="row">
						<div class="col-md-5">
							<h4 class="text-left">
								Ekstrakurikuler
							</h4>
						</div>
						<div class="col-md-7 content-tipe-penugasan-ekstra">
							<h5 class="text-left">Sedang mengambil data...</h5>
						</div>
					</div>
					<div>
						<h4 class="text-danger text-center warning-ekstra">
						</h4>
					</div>
				</div>
			</div>
			<div class="modal-footer text-center">
				<button type="button" class="btn btn-info simpan-penugasan" data-dismiss="modal">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>