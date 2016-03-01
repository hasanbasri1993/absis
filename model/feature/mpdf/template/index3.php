<?php
	$kelas=$_GET['kelas'];
	$subkelas=$_GET['subkelas'];
	$semester="1";
	require "../../controller/config/config.php";
	
	include("mpdf.php");
	
	$mpdf=new mPDF('win-1252','A4','','');
	$mpdf->ignore_invalid_utf8 = true;
	$mpdf->useOnlyCoreFonts = true;    // false is default
	$mpdf->useSubstitutions=false;
	$mpdf->simpleTables = true;
	
	
	$resultSiswa = $dbo->prepare("SELECT * FROM user_siswa_2014 WHERE kelas =:kelas AND subkelas =:subkelas");
	$resultSiswa->bindParam(":kelas",$kelas,PDO::PARAM_STR);
	$resultSiswa->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);
	$resultSiswa->execute();
	$siswaCount= $resultSiswa->rowCount();
	$siswaData = $resultSiswa->FetchAll();
	
	$count=0;
	$html="";
	//foreach ($nisn as $nisnx) {
	//	$count++;
	//echo $siswaCount;
	//$siswaData[$siswaCountProcess]['nama'];
	$siswaCountProcess=0;
	while ($siswaCountProcess<>$siswaCount){
		
			//VARIABEL
			$sekolah="SMP Negeri 1 Semarang";
			$induk=$siswaData[$siswaCountProcess]['nis'];
			$nama=$siswaData[$siswaCountProcess]['nama'];
			$nisn=$siswaData[$siswaCountProcess]['nisn'];
			$alamat="JALAN RONGGOLAWE";
			$kode_pos="50149";
			$telepon="(024)7606340";
			$kelurahan="GISIKDRONO";
			$kecamatan="SEMARANG TENGAH";
			$kota="KOTA SEMARANG";
			$provinsi="JAWA TENGAH";
			$ttl=$siswaData[$siswaCountProcess]['tempat_lahir'].", ".$siswaData[$siswaCountProcess]['tanggal_lahir'];
			//kelamin
			if($siswaData[$siswaCountProcess]['kelamin']=="L"){
					$kelamin="LAKI-LAKI";
				};
			if($siswaData[$siswaCountProcess]['kelamin']=="P"){
					$kelamin="PEREMPUAN";
				};
			$agama=$siswaData[$siswaCountProcess]['agama'];
			$status_keluarga="";
			$anak_ke="";
			$alamat_siswa="";
			$sekolah_asal="";
			$diterima_dikelas="";
			$tgl_masuk="1 Juni 2014";
			$nama_ayah=$siswaData[$siswaCountProcess]['orang_tua'];
			$nama_ibu="";
			$alamat_ortu=$siswaData[$siswaCountProcess]['alamat'];
			$telepon_ortu="";
			$pekerjaan_ayah="";
			$pekerjaan_ibu="";
			$nama_wali="";
			$alamat_wali="";
			$telepon_wali;
			$pekerjaan_wali="";
			
			$nama_kepsek="Drs. H. Nusantara, M.M.";
			$nip_kepsek="196010101988031015";
		
		
		$html .= '<br>
					<p style="text-align:center">
						<img width="140px" src="img/garuda.jpg"><br><br><br>
						<h2 style="text-align:center">    
							LAPORAN<br>
							HASIL BELAJAR PESERTA DIDIK<br>
							SEKOLAH MENENGAH PERTAMA<br>
							( SMP )
						</h2>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<table align="center" border="0" cellspacing="8" cellpadding="5" style="width:70%;font-size:100%;">
							<tr>     <td style="width:30%">Nama Sekolah   </td><td>: '.$sekolah.'</td>      </tr>
							<tr>     <td>NIS/NSS/NDS    </td><td>: '.$induk.' / '.$nisn.' </td>      </tr>
							<tr>     <td>Alamat         </td><td>: '.ucwords(strtolower($alamat)).' </td>      </tr>
							<tr>     <td>               </td><td> Kode Pos '.$kode_pos.' Telepon '.$telepon.' </td>      </tr>
							<tr>     <td>Kelurahan      </td><td>: '.ucwords(strtolower($kelurahan)).' </td>      </tr>
							<tr>     <td>Kecamatan      </td><td>: '.ucwords(strtolower($kecamatan)).' </td>      </tr>
							<tr>     <td>Kota/Kabupaten </td><td>: '.ucwords(strtolower($kota)).' </td>      </tr>
							<tr>     <td>Provinsi       </td><td>: '.ucwords(strtolower($provinsi)).' </td>      </tr>
						</table>
					</p>';
			$html .= '<pagebreak />
					<h5 align="center">PETUNJUK PENGGUNAAN</h5>
					<table style="width:100%;font-size:100%;padding-left:1cm;padding-right:1cm">
						<tr><td valign="top">1.</td><td>Buku Laporan Hasil Belajar ini dipergunakan selama peserta didik mengikuti pelajaran di Sekolah Menengah Pertama (SMP).</td></tr>
						<tr><td valign="top">2.</td><td>Apabila peserta didik pindah sekolah, buku Laporan Hasil Belajar dibawa oleh peserta didik yang bersangkutan untuk dipergunakan sebagai bukti pencapaian kompetensi.</td></tr>
						<tr><td valign="top">3.</td><td>Apabila buku Laporan Hasil Belajar peserta didik yang bersangkutan hilang, dapat diganti dengan buku Laporan Hasil Belajar Pengganti dan diisi dengan nilai-nilai yang dikutip dari Buku Induk Sekolah asal peserta didik dan disahkan oleh Kepala Sekolah yang bersangkutan.</td></tr>
						<tr><td valign="top">4.</td><td>Buku Laporan Hasil Belajar peserta didik ini harus dilengkapi dengan pas foto ukuran 3 x 4 cm, dan pengisiannya dilakukan oleh wali kelas.</td></tr>
					</table>
					<h5 style="padding-left:1cm;padding-right:1cm">KETERANGAN NILAI KUANTITATIF</h5>
					<p style="font-size:100%;padding-left:1cm;padding-right:1cm"> Nilai Kuantitatif dengan Skala 1 &#45; 4 (berlaku kelipatan 0,33) digunakan untuk Nilai Pengetahuan (KI 3) dan Nilai Keterampilan (KI 4). Indeks Nilai Kuantitatif dengan Skala 1 &#45; 4 adalah:</p>
					<table align="center" border="1" cellspacing="0" style="font-size:90%;border: 1px;border-collapse:collapse;border-color:black;">
						<tr><th>No.</th><th>Rentang Nilai</th><th>Keterangan</th></tr>
						<tr><td>1.</td><td>0 &lt; D = 1,00</td><td>Nilai D = lebih dari 0 dan kurang dari atau sama dengan 1.</td></tr>
						<tr><td>2.</td><td>1,00 &lt; D+ = 1,33</td><td>Nilai D+ = lebih dari 1 dan kurang dari atau sama dengan 1,33.</td></tr>
						<tr><td>3.</td><td>1,33 &lt; C- = 1,66</td><td>Nilai C- = lebih dari 1,33 dan kurang dari atau sama dengan 1,66.</td></tr>
						<tr><td>4.</td><td>1,66 &lt; C = 2,00</td><td>Nilai C = lebih dari 1,66 dan kurang dari atau sama dengan 2,00.</td></tr>
						<tr><td>5.</td><td>2,00 &lt; C+ = 2,33</td><td>Nilai C+ = lebih dari 2,00 dan kurang dari atau sama dengan 2,33.</td></tr>
						<tr><td>6.</td><td>2,33 &lt; B- = 2,66</td><td>Nilai B- = lebih dari 2,33 dan kurang dari atau sama dengan 2,66.</td></tr>
						<tr><td>7.</td><td>2,66 &lt; B = 3,00</td><td>Nilai B = lebih dari 2,66 dan kurang dari atau sama dengan 3,00.</td></tr>
						<tr><td>8.</td><td>3,00 &lt; B+ = 3,33</td><td>Nilai B+ = lebih dari 3,00 dan kurang dari atau sama dengan 3,33.</td></tr>
						<tr><td>9.</td><td>3,33 &lt; A- = 3,66</td><td>Nilai A- = lebih dari dan kurang dari 3,33 atau sama dengan 3,66.</td></tr>
						<tr><td>10.</td><td>3,66 &lt; A = 4,00</td><td>Nilai A = lebih dari 3,66 dan kurang dari atau sama dengan 4,00.</td></tr>
					</table>
					<h5 style="padding-left:1cm;padding-right:1cm">KETERANGAN NILAI KUALITATIF</h5>
					<p style="font-size:100%;padding-left:1cm;padding-right:1cm">Nilai kualitatif yang digunakan untuk nilai sikap spiritual (KI 1), dan sikap sosial (KI 2), serta kegiatan ekstrakurikuler, adalah:</p>
					<p style="font-size:100%;padding-left:1cm;padding-right:1cm">SB = Sangat Baik</p>
					<p style="font-size:100%;padding-left:1cm;padding-right:1cm">B  = Baik</p>
					<p style="font-size:100%;padding-left:1cm;padding-right:1cm">C  = Cukup</p>
					<p style="font-size:100%;padding-left:1cm;padding-right:1cm">K  = Kurang</p>

					';
			$html .= '<pagebreak />
					
					<h5 align="center">KETERANGAN TENTANG DIRI SISWA</h5>
					<p style="padding-left:1cm">
						<br>
						<table align="center" cellpadding="5" style="width:80%;font-size:90%;">
							<tr><td style="width:5%">1.</td><td style="width:35%">Nama Siswa               </td><td>: '.ucwords(strtolower($nama)).'</td></tr>
							<tr><td>2.</td><td>Nomor Induk              </td><td>: '.$induk.'</td></tr>
							<tr><td>3.</td><td>Tempat dan Tanggal Lahir </td><td>: '.ucwords(strtolower($ttl)).'</td></tr>
							<tr><td>4.</td><td>Jenis Kelamin            </td><td>: '.ucwords(strtolower($kelamin)).'</td></tr>
							<tr><td>5.</td><td>Agama                    </td><td>: '.ucwords(strtolower($agama)).'</td></tr>
							<tr><td>6.</td><td>Status dalam Keluarga    </td><td>: '.ucwords(strtolower($status_keluarga)).'</td></tr>
							<tr><td>7.</td><td>Anak ke                  </td><td>: '.$anak_ke.'</td></tr>
							<tr><td>8.</td><td>Alamat Siswa             </td><td>: '.ucwords(strtolower($alamat_siswa)).'</td></tr>
							<tr><td>  </td><td>Telepon                  </td><td>: '.$telepon_siswa.'</td></tr>
							<tr><td>9.</td><td>Sekolah Asal             </td><td>: '.ucwords(strtolower($sekolah_asal)).'</td></tr>
							<tr><td>10.</td><td>Diterima di Sekolah ini  </td><td>           </td></tr>
							<tr><td>   </td><td>Di Kelas                 </td><td>: '.$diterima_dikelas.'</td></tr>
							<tr><td>   </td><td>Pada Tanggal              </td><td>: '.$tgl_masuk.'</td></tr>
							<tr><td>11.</td><td>Nama Orang Tua            </td><td>           </td></tr>
							<tr><td>   </td><td>a. Ayah                   </td><td>: '.ucwords(strtolower($nama_ayah)).'</td></tr>
							<tr><td>   </td><td>b. Ibu                    </td><td>: '.ucwords(strtolower($nama_ibu)).'</td></tr>
							<tr><td>12.</td><td>Alamat Orang Tua          </td><td>: '.ucwords(strtolower($alamat_ortu)).'</td></tr>
							<tr><td>   </td><td>Telepon                   </td><td>: '.$telepon_ortu.'</td></tr>
							<tr><td>13.</td><td>Pekerjaan Orang Tua       </td><td>           </td></tr>
							<tr><td>   </td><td>a. Ayah                   </td><td>: '.ucwords(strtolower($pekerjaan_ayah)).'</td></tr>
							<tr><td>   </td><td>b. Ibu                    </td><td>: '.ucwords(strtolower($pekerjaan_ibu)).'</td></tr>
							<tr><td>14.</td><td>Nama Wali                 </td><td>: '.ucwords(strtolower($nama_wali)).'</td></tr>
							<tr><td>15.</td><td>Alamat Wali               </td><td>: '.ucwords(strtolower($alamat_wali)).'</td></tr>
							<tr><td>   </td><td>Telepon                   </td><td>: '.$telepon_wali.'</td></tr>
							<tr><td>16.</td><td>Pekerjaan Wali            </td><td>: '.ucwords(strtolower($pekerjaan_wali)).'</td></tr>

						</table>
						<br>
						<br>
						<div style="width:3cm;height:4cm;border:1px solid #000;float:left;margin-left:20%;text-align:center;display: table-cell; vertical-align: middle;display: table;"><p>foto<br>3x4</p></div>
						<div>
							<table align="center" cellpadding="5" style="margin-left:20%;width:100%;font-size:100%;">
								<tr><td align="center">'.ucwords(strtolower($kota)).', '.$tgl_masuk.'</td></tr>
								<tr><td align="center">Kepala Sekolah</td></tr>
								<tr><td align="center"><br><br><br><br></td></tr>
								<tr><td align="center"><u>'.$nama_kepsek.'</u></td></tr>
								<tr><td align="center">NIP : '.$nip_kepsek.' </td></tr>
							</table>
						</div>
					</p> 
					<pagebreak />';
		$siswaCountProcess++;
	}
	
	$mpdf->WriteHTML($html);

	$mpdf->Output('RAPOT HALAMAN DEPAN KELAS '.$kelas.' '.$subkelas.'.pdf','D'); 
	exit;

exit;



?>