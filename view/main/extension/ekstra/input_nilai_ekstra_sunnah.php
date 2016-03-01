
<style type="text/css">
	#content-r
	{
		position:absolute;
		width:auto;
		padding:10px;
		display:none;
		margin-top:-1px;
		border-top:0px;
		overflow:hidden;
		border:1px #CCC solid;
		background-color: white;
	}
	.content-result-show
	{
		padding:10px; 
		font-size:15px; 
		height:auto;
	}
	.content-result-show:hover
	{
		background:#3498DB;
		color:#FFF;
		cursor:pointer;
	}
</style>
<div class="row">
	<div class="col-md-2">
	</div>
	<div class="col-md-8">
		<div class="the-box no-border">
			<div class="content-snr">
				<div class="row">
					<div class="col-md-3">
						
					</div>
					<div class="col-md-6">
						<div class="form-group text-center">
							<input type="text" id="input-s" class="form-control input-lg input-s text-left" placeholder="Masukkan Nama atau NIS Siswa">
						</div>
						<div class="full">
							<div id="content-r">
								<p style="fon-size: 10px; text-align:center">Mengambil data...</p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						
					</div>
				</div>			

				<div class="table-responsive">
					<form action = "?sajen=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_save" method="POST">
						<table class="table table-th-block table-info table-striped table-hover">
							<thead>
								<tr>
									<th class="text-left" style="width:;">No</th>
									<th class="text-left" style="width:;">NIS</th>
									<th class="text-center" style="width:;">Kelas</th>
									<th class="text-center" style="width:;">Nama</th>
									<th class="text-center" style="width:10%;">Nilai</th>
									<th class="text-left" style="width:;">Keterangan</th>
									<th class="text-center" style="width:;">Hapus</th>
								</tr>						
							</thead>
								<tbody id="content-table">
									<tr>
										<td colspan="6" align="center">
											Mencoba Mengambil Data...home
										</td>
									</tr>
								</tbody>
						</table>
						<div class="row">
							<div class="text-center">
								<button type='submit' class='btn btn-info btn-lg' data-dismiss='modal'>Simpan Semua Nilai</button>
							</div>
						</div>
					</form>
				</div>				
			</div>
		</div>
	</div>
	<div class="col-md-2">
	</div>
</div>
<div class='modal fade' id='ModalDelete' tabindex='-1' role='dialog' aria-hidden='true'>
	<div class='modal-dialog' style='margin-top: 10%;'>
		<div class='modal-content'>
			<div class='modal-header bg-danger no-border'>
				<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
				<h3 class='modal-title text-center'>Hapus Siswa</h3>
			</div>
			<div class='modal-body'style='color: rgba(1,1,1,0.6);'>
				<div id='kontenDelete'>	
				<h3 class='text-center'>
					Hapus Siswa dari Ekstra ini ?
				</h3>
				</div>								
			</div>
			<div class='modal-footer text-center'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Tidak</button>
				<button type='button' class='btn btn-danger hapus-konfirm' data-dismiss='modal'>Hapus</button>
			</div>
		</div>
	</div>
</div>
