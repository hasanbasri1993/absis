<?php
$title_1 = "Unduh Dokumen Sekolah";
$title_2 = "SMPN 1 SEMARANG";
$state_navbar = "pilihan_download"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";
?>
<div class="row">
	<div class="col-sm-4 col-md-3 col-lg-3">
	</div>
	<div class="col-sm-4 col-md-6 col-lg-6">	
		<!-- Start table -->
		<div class="the-box full no-border">
			<div class="table-responsive">
				<table class="table table-th-block table-info">
					<thead>
						<tr><th style="width:20%">Dokumen</th><th>Deskripsi</th><th>Unduh</th></tr>
					</thead>
					<tbody>
						<tr><td><b>Ledger Kelas</b></td><td>Berisi nilai lengkap tiap pelajaran, tiap siswa, dari setiap kelas.</td>
<!-- 							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
									Unduh &nbsp; <i class="fa fa-download"></i>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="?p=pilihan_download&tipe=ledger&state=download">Format Excel</a></li>
										<li class="divider"></li>
										<li><a href="#fakelink">Detail</a></li>
									</ul>
								</div>
							</td></tr> -->
							<td>
								<div class="btn-group">
									<a type="button" class="btn btn-info" href="?p=pilihan_download&tipe=ledger&state=download">
									Unduh &nbsp; <i class="fa fa-download"></i>
									</a>											
								</div>
							</td></tr>							
						<tr><td><b>Absensi Siswa</b></td><td>Berisi absensi siswa untuk semua kelas, dapat digunakan setiap saat.</td>
							<td>
								<div class="btn-group">
									<a type="button" class="btn btn-info" href="?p=pilihan_download&tipe=absensi&state=download">
									Unduh &nbsp; <i class="fa fa-download"></i>
									</a>											
								</div>
							</td></tr>
						<tr><td><b>Rapor UTS</b></td><td>Berisi rapor UTS untuk semua kelas, hanya bisa diunduh setelah semua nilai UTS selesai dimasukan</td>
							<td>
								<div class="btn-group">
									<a type="button" class="btn btn-info" href="?p=pilihan_download&tipe=uts&state=download">
									Unduh &nbsp; <i class="fa fa-download"></i>
									</a>											
								</div>
							</td></tr>
						<tr><td><b>Rapor UAS</b></td><td>Berisi rapor UAS untuk semua kelas, hanya bisa diunduh setelah nilai-nilai setiap topik dan nilai-nilai ujian telah selesai dimasukan</td>
							<td>
								<div class="btn-group">
									<a type="button" class="btn btn-info" href="?p=pilihan_download&tipe=uas&state=download">
									Unduh &nbsp; <i class="fa fa-download"></i>
									</a>											
								</div>
							</td></tr>
						<tr><td>Rapor Kenaikan Kelas</td><td>Berisi rapor kenaikan kelas yang menerangkan kenaikan kelas siswa menuju kelas berikutnya. Hanya bisa diakses untuk kelas 7 dan 8</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
									Unduh &nbsp; <i class="fa fa-download"></i>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="?p=pilihan_download&tipe=ukk&state=pdf">Format PDF</a></li>
										<li class="divider"></li>
										<li><a href="#fakelink">Detail</a></li>
									</ul>
								</div>
							</td></tr>
						<tr><td>Buku Induk Siswa</td><td>Berisi data-data siswa seperti nama, alamat, nama orang tua dan lainnya</td>
							<td>
								<div class="btn-group">
									<a type="button" class="btn btn-info" href="?p=pilihan_download&tipe=buku_induk&state=download">
									Unduh &nbsp; <i class="fa fa-download"></i>
									</a>											
								</div>
							</td></tr>
						<tr><td>Data Penghasilan Orang Tua</td><td>Berisi data penghasilan orang tua siswa, dapat digunakan sekolah untuk mengambil kebijakan</td><td>
										<div class="btn-group">
											<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
											Unduh &nbsp; <i class="fa fa-download"></i>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#fakelink">Format PDF</a></li>
												<li><a href="#fakelink">Format Excel</a></li>
												<li class="divider"></li>
												<li><a href="#fakelink">Detail</a></li>
											</ul>
										</div>
									</td></tr>
						<tr><td>Data Siswa Kurang Mampu</td><td>Berisi data siswa yang kurang mampu untuk keperluan sekolah</td><td>
										<div class="btn-group">
											<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
											Unduh &nbsp; <i class="fa fa-download"></i>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#fakelink">Format PDF</a></li>
												<li><a href="#fakelink">Format Excel</a></li>
												<li class="divider"></li>
												<li><a href="#fakelink">Detail</a></li>
											</ul>
										</div>
									</td></tr>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div>
		<!-- End table -->
	</div>
	<div class="col-sm-4 col-md-3 col-lg-3">
	</div>
</div>