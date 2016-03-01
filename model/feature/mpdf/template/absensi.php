
<?php
	include $_SERVER['DOCUMENT_ROOT']."/model/feature/mpdf/mpdf.php";
	include_once "model/class/master.php";

	$mpdf=new mPDF('win-1252','A4',0,'','5','5','10','3','',''); 
	$mpdf->useOnlyCoreFonts = true;
	$mpdf->useSubstitutions=false;
	$mpdf->simpleTables = true;

	if (($kelas!="")AND($subkelas!="")){
		if ($subkelas=="all"){
			
			$sekolah = new Sekolah();
			$jml_kelas = $sekolah->getBanyakRombel($kelas);
			$data_text ="";
			$html = array();

			for ($count=0; $count < $jml_kelas; $count++) { 
				$subkelas = getNameFromNumber($count);
				$kelasx= new Kelas($kelas,$subkelas);
				$daftar_siswa= $kelasx->getSiswa();
			  	$jumlah_siswa= sizeof($daftar_siswa);
			  	$jumlah_L= $kelasx->getBanyakSiswaL();
			  	$jumlah_P= $kelasx->getBanyakSiswaP();
			  	$nip_wali= $kelasx->getWaliKelasNIP();
			  	$guru = new Guru($nip_wali);
			  	$nama_wali = $guru->getNama();
			  	//$daftar_siswa= json_decode(json_encode($daftar_siswa),true);

				$html[$count] = '
				    <table style="width:100%" >
				        <tr>
				            <td style="width:12%;text-align:right">
				                <img height="90px" src="assets/img/logo-pemkot.jpg">
				            </td>
				            <td style="width:*;text-align:center">
				                <strong><font size="3">PEMERINTAH KOTA SEMARANG<br>DINAS PENDIDIKAN</font><br><font size="5">SMP NEGERI 1 SEMARANG</font></strong><br>
				                <font size="2">Jl. Ronggolawe, Tlp.(024)7606340 fax.(024)7624850, Semarang 50149</font>
				            </td>
				            <td style="width:12%;text-align:left;">
				                <img height="90px" src="assets/img/logo-smp1.png">
				            </td>
				        </tr>
				    </table>
				    <hr style="height:2px;border:none;color:#333;background-color:#333;">
				    <h5 style="text-align:center">ABSENSI SISWA</h5>
				    <table style="width:100%;font-size:75%">
				    	<tr>
				    		<td style="width:50%">Kelas  : <b>'.$kelas.$subkelas.'</b></td>
				    		<td style="width:50%;text-align:right">Wali Kelas : <b>'.$nama_wali.'</b></td>
				    	</tr>
				    </table>
				    <table cellspacing="0" cellpadding="2" border="1" style="width:100%;border-collapse:collapse;font-size:75%">
				    	<tr>
				    		<th rowspan="2"  style="width:3%">No</th>
				    		<th rowspan="2"  style="width:6%">NIS</th>
				    		<th rowspan="2"  style="width:9%">NISN</th>
				    		<th rowspan="2"  style="width:25%">Nama</th>
				    		<th rowspan="2"  style="width:2%">L/P</th>
				    		<th colspan="31" style="width:55%">Tanggal</th>
				    	</tr>
				    	<tr>  	
				    ';
				$html[$count].='
				<td style="text-align:center;font-size:65%">&nbsp;1&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;2&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;3&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;4&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;5&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;6&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;7&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;8&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;9&nbsp;</th>
				<td style="text-align:center;font-size:65%">10</th>
				<td style="text-align:center;font-size:65%">11</th>
				<td style="text-align:center;font-size:65%">12</th>
				<td style="text-align:center;font-size:65%">13</th>
				<td style="text-align:center;font-size:65%">14</th>
				<td style="text-align:center;font-size:65%">15</th>
				<td style="text-align:center;font-size:65%">16</th>
				<td style="text-align:center;font-size:65%">17</th>
				<td style="text-align:center;font-size:65%">18</th>
				<td style="text-align:center;font-size:65%">19</th>
				<td style="text-align:center;font-size:65%">20</th>
				<td style="text-align:center;font-size:65%">21</th>
				<td style="text-align:center;font-size:65%">22</th>
				<td style="text-align:center;font-size:65%">23</th>
				<td style="text-align:center;font-size:65%">24</th>
				<td style="text-align:center;font-size:65%">25</th>
				<td style="text-align:center;font-size:65%">26</th>
				<td style="text-align:center;font-size:65%">27</th>
				<td style="text-align:center;font-size:65%">28</th>
				<td style="text-align:center;font-size:65%">29</th>
				<td style="text-align:center;font-size:65%">30</th>
				<td style="text-align:center;font-size:65%">31</th>'; 


				// for ($i=1; $i<=31; $i++) {
				// 	if($i<10){
				// 		$html[$count].='<td style="text-align:center;font-size:65%">&nbsp;'.$i.'&nbsp;</th>'; 
				// 	}else{
				// 		$html[$count].='<td style="text-align:center;font-size:65%">'.$i.'</th>'; 
				// 	}
				// }
				$html[$count] .='</tr>';
				for ($i=0; $i<$jumlah_siswa; $i++) {
					$no=$i+1;
					$html[$count].='<tr>
								<td style="text-align:center">'.$no.'</td>
								<td style="text-align:center">'.$daftar_siswa[$i][nis].'</td>
								<td style="text-align:center;font-size:80%">'.$daftar_siswa[$i][nisn].'</td>
								<td>'.ucwords(strtolower($daftar_siswa[$i][nama])).'</td>
								<td style="text-align:center">'.$daftar_siswa[$i][kelamin].'</td>';
							$html[$count].='</tr>';
				}
				$html[$count] .='<tr>
							<td colspan="3" rowspan="4"><b>Keterangan</b></td>
							<td colspan="2"><b>Sakit</b></td></tr>
						<tr>
							<td colspan="2"><b>Izin</b></td></tr>
						<tr>
							<td colspan="2"><b>Alpa</b></td></tr>
						<tr>
							<td colspan="2"><b>Hadir</b></td>
						</tr>
						</table>
						<br>
						<br>
						<div style="float:left;width:50%">
							<table border="1" style="width:40%;border-collapse:collapse;font-size:75%;margin-left:1cm">
								<tr>
									<td style="width:80%">&nbsp;&nbsp;Jumlah Siswa</td><td style="width:20%;text-align:center">'.$jumlah_siswa.'</td>
								</tr>
								<tr>
									<td>&nbsp;&nbsp;Laki-Laki</td><td style="width:20%;text-align:center">'.$jumlah_L.'</td>
								</tr>
								<tr>
									<td>&nbsp;&nbsp;Perempuan</td><td style="width:20%;text-align:center">'.$jumlah_P.'</td>
								</tr>
							</table>
						</div>
						<div style="float:right;width:50%">
							<table style="width:100%;font-size:75%;text-align:center">
								<tr>
									<td>Semarang,________________</td>
								</tr>
								<tr>
									<td>&nbsp;<br><br><br></td>
								</tr>
								<tr>
									<td><u>'.$nama_wali.'</u><br>NIP. '.$nip_wali.'</td>
								</tr>
							</table>
						</div>';
				$data_text .=$html[$count];
			}

			//nyetak absensi
			
			if($_GET['download']=="1"){
				//Buat pdf jika isinya tidak kosong
				$mpdf->WriteHTML($data_text);
				$mpdf->Output('Absensi Semua'.$kelas.'.pdf','D');
			}else{
                echo "
                  <head>
                    <style>
                        body {
                            background: #cccccc;
                        }

                        page[size='A4'] {
                            background: white;
                            width: 21cm;
                            height: 29.7cm;
                            display: block;
                            margin: 0 auto;
                            padding: 0.5cm;
                            margin-bottom: 0.5cm;
                            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
                        }

                        @media print {
                            body, page[size='A4'] {
                                margin: 0;
                                box-shadow: 0;
                            }
                        }
                    </style>
                </head>

                ";				
		 		for ($i=0; $i < $jml_kelas; $i++) { 
					echo '<page size="A4">'.$html[$i].'</page>';
		 		}			
			}


		}else{

			$kelasx= new Kelas($kelas,$subkelas);
			$daftar_siswa= $kelasx->getSiswa();
		  	$jumlah_siswa= sizeof($daftar_siswa);
		  	$jumlah_L= $kelasx->getBanyakSiswaL();
		  	$jumlah_P= $kelasx->getBanyakSiswaP();
		  	$nip_wali= trim($kelasx->getWaliKelasNIP());
		  	$guru = new Guru($nip_wali);
		  	$nama_wali = $guru->getNama();
		  	//$nama_wali = strtoupper($nama_wali);
		  	$daftar_siswa= json_decode(json_encode($daftar_siswa),true);

			$html ="";
			$html .= '
			    <table style="width:100%" >
			        <tr>
			            <td style="width:12%;text-align:left">
			                <img height="90px" src="assets/img/logo-pemkot.jpg">
			            </td>
			            <td style="width:*;text-align:center">
			                <strong><font size="3">PEMERINTAH KOTA SEMARANG<br>DINAS PENDIDIKAN</font><br><font size="5">SMP NEGERI 1 SEMARANG</font></strong><br>
			                <font size="2">Jl. Ronggolawe, Tlp.(024)7606340 fax.(024)7624850, Semarang 50149</font>
			            </td>
			            <td style="width:12%;text-align:right;">
			                <img height="90px" src="assets/img/logo-smp1.png">
			            </td>
			        </tr>
			    </table>
			    <hr style="height:2px;border:none;color:#333;background-color:#333;">
			    <h5 style="text-align:center">ABSENSI SISWA</h5>
			    <table style="width:100%;font-size:75%">
			    	<tr>
			    		<td style="width:50%">Kelas  : <b>'.$kelas.$subkelas.'</b></td>
			    		<td style="width:50%;text-align:right">Wali Kelas : <b>'.$nama_wali.'</b></td>
			    	</tr>
			    </table>
			    <table cellspacing="0" cellpadding="2" border="1" style="width:100%;border-collapse:collapse;font-size:75%">
			    	<tr>
			    		<th rowspan="2"  style="width:3%">No</th>
			    		<th rowspan="2"  style="width:6%">NIS</th>
			    		<th rowspan="2"  style="width:9%">NISN</th>
			    		<th rowspan="2"  style="width:25%">Nama</th>
			    		<th rowspan="2"  style="width:2%">L/P</th>
			    		<th colspan="31" style="width:55%">Tanggal</th>
			    	</tr>
			    	<tr>  	
			    ';
				$html.='
				<td style="text-align:center;font-size:65%">&nbsp;1&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;2&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;3&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;4&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;5&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;6&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;7&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;8&nbsp;</th>
				<td style="text-align:center;font-size:65%">&nbsp;9&nbsp;</th>
				<td style="text-align:center;font-size:65%">10</th>
				<td style="text-align:center;font-size:65%">11</th>
				<td style="text-align:center;font-size:65%">12</th>
				<td style="text-align:center;font-size:65%">13</th>
				<td style="text-align:center;font-size:65%">14</th>
				<td style="text-align:center;font-size:65%">15</th>
				<td style="text-align:center;font-size:65%">16</th>
				<td style="text-align:center;font-size:65%">17</th>
				<td style="text-align:center;font-size:65%">18</th>
				<td style="text-align:center;font-size:65%">19</th>
				<td style="text-align:center;font-size:65%">20</th>
				<td style="text-align:center;font-size:65%">21</th>
				<td style="text-align:center;font-size:65%">22</th>
				<td style="text-align:center;font-size:65%">23</th>
				<td style="text-align:center;font-size:65%">24</th>
				<td style="text-align:center;font-size:65%">25</th>
				<td style="text-align:center;font-size:65%">26</th>
				<td style="text-align:center;font-size:65%">27</th>
				<td style="text-align:center;font-size:65%">28</th>
				<td style="text-align:center;font-size:65%">29</th>
				<td style="text-align:center;font-size:65%">30</th>
				<td style="text-align:center;font-size:65%">31</th>'; 
			$html .='</tr>';
			for ($i=0; $i<$jumlah_siswa; $i++) {
				$no=$i+1;
				$html.='<tr>
							<td style="text-align:center">'.$no.'</td>
							<td style="text-align:center">'.$daftar_siswa[$i][nis].'</td>
							<td style="text-align:center;font-size:80%">'.$daftar_siswa[$i][nisn].'</td>
							<td>'.ucwords(strtolower($daftar_siswa[$i][nama])).'</td>
							<td style="text-align:center">'.$daftar_siswa[$i][kelamin].'</td>';
							for ($x=1; $x<=31; $x++) {
								$html.='<td>&nbsp;</td>';
							}
						$html.='</tr>';
			}
			$html .='<tr>
						<td colspan="3" rowspan="4"><b>Keterangan</b></td>
						<td colspan="2"><b>Sakit</b></td>';
			for ($i=1; $i<=31; $i++) {
				$html.='<td>&nbsp;</td>';
			}
			$html.='</tr>
					<tr>
						<td colspan="2"><b>Izin</b></td>';
			for ($i=1; $i<=31; $i++) {
				$html.='<td>&nbsp;</td>';
			}
			$html.='</tr>
					<tr>
						<td colspan="2"><b>Alpa</b></td>';
			for ($i=1; $i<=31; $i++) {
				$html.='<td>&nbsp;</td>';
			}
			$html.='</tr>
					<tr>
						<td colspan="2"><b>Hadir</b></td>';
			for ($i=1; $i<=31; $i++) {
				$html.='<td>&nbsp;</td>';
			}
			$html.='
					</tr>
					</table>';
			$html .='
					<br>
					<br>
					<div style="float:left;width:50%">
						<table border="1" style="width:40%;border-collapse:collapse;font-size:75%;margin-left:1cm">
							<tr>
								<td style="width:80%">&nbsp;&nbsp;Jumlah Siswa</td><td style="width:20%;text-align:center">'.$jumlah_siswa.'</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;Laki-Laki</td><td style="width:20%;text-align:center">'.$jumlah_L.'</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;Perempuan</td><td style="width:20%;text-align:center">'.$jumlah_P.'</td>
							</tr>
						</table>
					</div>
					<div style="float:right;width:50%">
						<table style="width:100%;font-size:75%;text-align:center">
							<tr>
								<td>Semarang,________________</td>
							</tr>
							<tr>
								<td>&nbsp;<br><br><br></td>
							</tr>
							<tr>
								<td><u>'.$nama_wali.'</u><br>NIP. '.$nip_wali.'</td>
							</tr>
						</table>
					</div>';

			if($_GET['download']=="1"){
				//Buat pdf jika isinya tidak kosong
				if(($html!=null)||($html!="")){
					$mpdf->WriteHTML($html);
					$mpdf->Output('Absensi '.$kelas.$subkelas.'.pdf','D');
				}
			}else{
                echo "
                  <head>
                    <style>
                        body {
                            background: #cccccc;
                        }

                        page[size='A4'] {
                            background: white;
                            width: 21cm;
                            height: 29.7cm;
                            display: block;
                            margin: 0 auto;
                            padding: 0.5cm;
                            margin-bottom: 0.5cm;
                            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
                        }

                        @media print {
                            body, page[size='A4'] {
                                margin: 0;
                                box-shadow: 0;
                            }
                        }
                    </style>
                </head>

                ";				
				echo '<page size="A4">'.$html.'</page>';
			}
		}
	}else if($kelas==""){
		echo '<page size="A4"><p style="text-align:center">Masukan data Kelas dan Sub Kelas terlebih dahulu</p></page>';
	}

	function getNameFromNumber($num) {
		$numeric = $num % 26;
		$letter = chr(65 + $numeric);
		$num2 = intval($num / 26);
		if ($num2 > 0) {
			return getNameFromNumber($num2 - 1) . $letter;
		} else {
			return $letter;
		}
	}

	exit;

?>