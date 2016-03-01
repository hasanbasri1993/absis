<?php
$title_1 = "Input Nilai (Semua)";
$state_navbar = "input_nilai"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";

$dbTA=new DB($_SESSION['database']);

$sqlGuru = "SELECT DISTINCT nip FROM guru_aktif";
$guru = $dbTA->prepare("$sqlGuru");
//$guru->bindParam(":kunci",$kurikulumKelas,PDO::PARAM_STR);	
$guru->execute();
$daftarGuru = $guru->fetchAll();

//print_r($daftarGuru);
//echo $daftarGuru[1][0];
?>
<div class="row">
	<div class="col-md-2"></div>

	<div class="col-md-8">
		<div class="the-box full no-border">
						<div class="table-responsive">
							<table class="table table-th-block table-striped table-info">
								<thead>
									<tr>
										<th style="width: 30px;">
											NIP
										</th>
										<th>Nama Guru</th>
										<th>Mapel</th>
										<th>Action</th>
										<th class="text-center">Persentase Input</th>
									</tr>
								</thead>
							<tbody>

							<?php 
							$jumlahGuru = sizeof($daftarGuru);
							$i=0;
							while($i<$jumlahGuru){
							
								$guru=new Guru($daftarGuru[$i][0]);

								echo "<tr>
										<td>
											<b>".$daftarGuru[$i][0]."</b>
										</td>
										<td>
											".$guru->getNama()."
										</td>
										<td>
											".$guru->getNamaMapel('ktsp')."
										</td>
										<td>
											<a class='btn btn-success text-center btn-block' href='?p=input_nilai_pilih_kelas&nip=".$daftarGuru[$i][0]."'>
												GO!
											</a>
										</td>
										<td class='text-center'>
											<span class='label label-danger'>
												%
											</span>
										</td>
									</tr>";
								$i++;
							}

							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2"></div>
</div>