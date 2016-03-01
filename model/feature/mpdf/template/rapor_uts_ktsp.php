

<?php
	/*
		rapor_uts_ktsp.php | fadhilimamk | 20 Sept 2015
		Membuat pdf rapor uts
	*/

  include $_SERVER['DOCUMENT_ROOT']."/model/feature/mpdf/mpdf.php";
  include_once "model/class/master.php";

  $mpdf=new mPDF('win-1252','A4',0,'','5','5','10','3','','');
  $mpdf->useOnlyCoreFonts = true;
  $mpdf->useSubstitutions=false;
  $mpdf->simpleTables = true;
  $mpdf->SetWatermarkImage('assets/img/logo-smp1.png',0.2,63);
  $mpdf->showWatermarkImage = true;

  $pelajaran=array(   array('mapel' => "Pendidikan Agama", 'kode_nama' => '') ,
                      array('mapel' => "Pendidikan Kewarganegaraan", 'kode_nama' => 'PKN') ,
                      array('mapel' => "Bahasa Indonesia", 'kode_nama' => 'BINDO') ,
                      array('mapel' => "Bahasa Inggris", 'kode_nama' => 'BING') ,
                      array('mapel' => "Matematika", 'kode_nama' => 'MAT') ,
                      array('mapel' => "Ilmu Pengetahuan Alam", 'kode_nama' => 'IPA') ,
                      array('mapel' => "Ilmu Pengetahuan Sosial", 'kode_nama' => 'IPS') ,
                      array('mapel' => "Seni Budaya", 'kode_nama' => 'SENI') ,
                      array('mapel' => "Pendidikan Jasmani, Olahraga, dan Kesehatan", 'kode_nama' => 'JASMANI') ,
                      array('mapel' => "Teknologi Informasi dan Komunikasi", 'kode_nama' => 'TIK') ,
                      array('mapel' => "Bahasa Jawa", 'kode_nama' => 'BAJA')
                      );
  //ini KKM kelas 7 8 9
  $_KKM=array(80,80,80,80,78,78,80,80,80,80,80,
              81,80,80,80,80,78,80,80,80,80,80,
              80,80,80,80,80,80,80,80,80,80,80);

  $tanggal_cetak = getdate();
  $tanggal_cetak = $tanggal_cetak['mday'].' '.$tanggal_cetak['month'].' '.$tanggal_cetak['year'];
  $tanggal_cetak = '30 Oktober 2015';
  $semester = '1';
  $tahun_ajaran = '2015/2016';


  ///   KONVERSI KE HURUF
	function angka_huruf($angka){
	    $x = array('satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh');
	    if($angka==0){
	        $s='Nol';
	    }else if($angka==100){
	        $s='Seratus';
	    }else if($angka<=10){
	        $s=$x[$angka-1];
	    }else if(($angka>10)and($angka<20)){
	        if($angka==11){
	            $s='sebelas';
	        }
	        $s=$x[($angka%10)-1].'belas';
	    }else if(($angka>=20)and($angka<100)){
	        $s=$x[($angka/10)-1].' puluh '.$x[($angka%10)-1];
	    }else{$s='ERROR!';}
	return ucwords($s);
	}
	function angka_huruf_2($angka){
	    $x = array('satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan','sepuluh');
	    if($angka==0){
	        $s='Nol';
	    }else if($angka==100){
	        $s='Seratus';
	    }else if($angka<=10){
	        $s=$x[$angka-1];
	    }else if(($angka>10)and($angka<20)){
	        if($angka==11){
	            $s='sebelas';
	        }
	        $s=$x[($angka%10)-1].'belas';
	    }else if(($angka>=20)and($angka<100)){
	        $s=$x[($angka/10)-1].' puluh '.$x[($angka%10)-1];
	    }else if(($angka>100)and($angka<110)){
	    	$s='seratus '.$x[($angka%10)-1];
	    }else if($angka==110){
	    	$s='seratus sepuluh';
	    }else if(($angka>110)and($angka<1000)){
	    	$s=$x[($angka/100)-1].' ratus '.$x[(($angka%100)/10)-1].' puluh '.$x[($angka%10)-1];
	    }else if($angka==1000){
	    	$s='seribu';
	    }else if(($angka>1000) and ($angka<1010)){
	    	$s='seribu '.$x[$angka%10-1];
	    }else if($angka==1010){
	    	$s='Seribu sepuluh';
	    }else if(($angka>1010) and ($angka<10000)){
	    	$s='seribu '.$x[(($angka%1000)/100) - 1].' ratus '.$x[(($angka/10)%10) - 1].' puluh '.$x[$angka%10-1];
	    }
	return ucwords($s);
	}

            function Dibaca($x) {
                $angkaBaca = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
                switch ($x) {
                    case ($x < 12):
                    	$s= " " . $angkaBaca[$x];
                        break;
                    case ($x < 20):
                        $s= Dibaca($x - 10) . " belas";
                        break;
                    case ($x < 100):
                        $s= Dibaca($x / 10);
                        $s.= " puluh ";
                        $s.= Dibaca($x % 10);
                        break;
                    case ($x < 200):
                        $s= " seratus ";
                        $s.= Dibaca($x - 100);
                        break;
                    case ($x < 1000):
                        $s= Dibaca($x / 100);
                        $s.= " ratus";
                        $s.= Dibaca($x % 100);
                        break;
                    case ($x < 2000):
                        $s= " seribu ";
                        $s.= Dibaca($x - 1000);
                        break;
                    case ($x < 1000000):
                        $s= Dibaca($x / 1000);
                        $s.= " ribu ";
                        $s.= Dibaca($x % 1000);
                        break;
                    case ($x < 1000000000):
                        $s.= Dibaca($x / 1000000);
                        $s.= " juta ";
                        $s.= Dibaca($x % 1000000);
                        break;
                }
                return ucwords($s);
            }
  function keterangan($nilai,$kkm){
      if ($nilai >= $kkm){
          return "Tuntas";
      }else{
          return "Tidak tuntas";
      }
  }

  //cek kalo udah dipilih kelas& subkelas
  $html= array();
  if(($kelas!="")&&($subkelas!="")){
      if ($subkelas=="all") {
          echo '<page size="A4"><p style="text-align:center">Masukan data Kelas dan Sub Kelas terlebih dahulu, cetak untuk semua kelas '.$kelas.' belum bisa dilakukan</p></page>';
      }else{

          //getting data...
          $kelasx= new Kelas($kelas,$subkelas);
          $daftar_siswa= $kelasx->getSiswa();
          $jumlah_siswa= sizeof($daftar_siswa);
          $nip_wali= $kelasx->getWaliKelasNIP();
          $guru = new Guru($nip_wali);
          $nama_wali = $guru->getNama();
          $data_text='';

          //Menghitung Rataan Kelas Sekali
          for ($x=0; $x<=10; $x++) {
            //hitung rataan agama
            //$_agm=$_siswa->getAgama();
            if ($x==0) {
              
              $_mapel = new Mapel('AGAMAIS',$kelas,$subkelas);

              $rata[$x]['uts']=$_mapel->getRataKelasUTS($kelas,$subkelas,1);
              continue;

            }else{
                $kode_mapel = $pelajaran[$x]['kode_nama'];
            }

            $_mapel = new Mapel($kode_mapel,$kelas,$subkelas);

            //hitung rataan mapel lainnya
            $rata[$x]['uts']=$_mapel->getRataKelasUTS($kelas,$subkelas);


          }

          for ($siswa_count=0; $siswa_count < $jumlah_siswa; $siswa_count++) {
                  $_siswa = new Siswa($daftar_siswa[$siswa_count][nis]);
                  $html[$siswa_count]='';
                  $html[$siswa_count] .= '
                          <table style="width:100%" >
                              <tr>
                                  <td style="width:12%">
                                      <img width="60px" src="assets/img/logo-pemkot.jpg">
                                  </td>
                                  <td style="width:*;text-align:center">
                                      <strong>PEMERINTAH KOTA SEMARANG<br>DINAS PENDIDIKAN<br>SMP NEGERI 1 SEMARANG<br>
                                      <font size="2">Jl. Ronggolawe, Tlp.(024)7606340 fax.(024)7624850, Semarang 50149</font></strong>
                                  </td>
                                  <td style="width:12%;text-align:right;">
                                      <img width="60px">
                                  </td>
                              </tr>
                          </table>
                          <hr>
                          <h5 style="text-align:center">LAPORAN HASIL BELAJAR PESERTA DIDIK TENGAH SEMESTER GASAL</h5>
                          <table style="font-size:75%" >
                              <tr>
                                  <td style="width:20%">NAMA PESERTA DIDIK</td>
                                  <td style="width:45%">: '.$daftar_siswa[$siswa_count][nama].'</td>
                                  <td style="width:20%">KELAS</td>
                                  <td style="width:15%">: '.$kelas.$subkelas.'</td>
                              </tr>
                              <tr>
                                  <td>NOMOR INDUK</td>
                                  <td>: '.$daftar_siswa[$siswa_count][nis].'</td>
                                  <td>SEMESTER</td>
                                  <td>: '.$semester.'</td>
                              </tr>
                              <tr>
                                  <td>NAMA SEKOLAH</td>
                                  <td>: SMPN 1 SEMARANG</td>
                                  <td>TAHUN PELAJARAN</td>
                                  <td>: '.$tahun_ajaran.'</td>
                              </tr>
                          </table>

                          <table cellspacing="0" cellpadding="1" border="1" style="width:100%;font-size:75%;border-collapse:collapse;">
                              <tr style="background-color:#E8E8E8;text-align:center;" class="center">
                                  <th rowspan="2" style="width:5%">NO</th>
                                  <th rowspan="2" style="width:30%">MATA PELAJARAN</th>
                                  <th rowspan="2" style="width:6%">KKM</th>
                                  <th colspan="3" style="width:34%">NILAI</th>
                                  <th rowspan="2" style="width:25%">CATATAN GURU</th>
                              </tr>
                              <tr style="background-color:#E8E8E8;text-align:center">
                                  <th style="width:7%">ANGKA</th>
                                  <th style="width:20%">HURUF</th>
                                  <th style="width:7%">RATAAN KELAS</th>
                              </tr>
                          ';


                  $jumlahNilai=0;
                  for ($x=0; $x<=10; $x++) {
                      $c=$x+1;

                      // Konfigurasi array KKM
                      if($kelas==7){
                          $xyz=$x;
                      }else if($kelas==8){
                          $xyz=$x+11;
                      }else if($kelas==9){
                          $xyz=$x+12;
                      }
                      //end konfigurasi array KKM

                      //Konfigurasi objek per mapel
                        //Agama
                        $_agm=$_siswa->getAgama();
                        if ($x==0) {
                          if ($_agm=='ISLAM'){
                              $kode_mapel = 'AGAMAIS';
                          }else if ($_agm=='KRISTEN'){
                              $kode_mapel = 'AGAMAKRIS';
                          }else if ($_agm=='KATOLIK'){
                              $kode_mapel = 'AGAMAKAT';
                          }else if ($_agm=='HINDU'){
                              $kode_mapel = 'AGAMAHIN';
                          }
                        }else{
                            $kode_mapel = $pelajaran[$x][kode_nama];
                        }
                      $_mapel = new Mapel($kode_mapel,$kelas,$subkelas);
                      $_nip_mapel = $_mapel->getNIP();
                      $_guru = new Guru($_nip_mapel);
                      //End Konfigurasi objek per mapel

                      if($x==9){
                          $html[$siswa_count] .='<tr><td style="text-align:center;">'.$c.'.</td><td colspan="6">Pilihan *)</td></tr>
                                   <tr><td style="text-align:center;"> </td><td><strong>'.$pelajaran[$x][mapel].'</strong><br />'.$_guru->getNama().'</td><td align="center">'.$_KKM[$xyz].'</td><td align="center">'.$_siswa->getNilaiUTS($kode_mapel).'</td><td align="center">'.angka_huruf($_siswa->getNilaiUTS($kode_mapel)).'</td><td align="center">'.$rata[$x]['uts'].'</td><td align="center">'.keterangan($_siswa->getNilaiUTS($kode_mapel),$_KKM[$xyz]).'</td>';
                      }else if($x==10){
                          $html[$siswa_count] .='<tr><td style="text-align:center;">'.$c.'.</td><td colspan="6">Mulok **)</td></tr>
                                   <tr><td style="text-align:center;"> </td><td><strong>'.$pelajaran[$x][mapel].'</strong><br />'.$_guru->getNama().'</td><td align="center">'.$_KKM[$xyz].'</td><td align="center">'.$_siswa->getNilaiUTS($kode_mapel).'</td><td align="center">'.angka_huruf($_siswa->getNilaiUTS($kode_mapel)).'</td><td align="center">'.$rata[$x]['uts'].'</td><td align="center">'.keterangan($_siswa->getNilaiUTS($kode_mapel),$_KKM[$xyz]).'</td>';
                      }else{
                          $html[$siswa_count] .= '<tr><td style="text-align:center;">'.$c.'.</td><td><strong>'.$pelajaran[$x][mapel].'</strong><br />'.$_guru->getNama().'</td><td align="center">'.$_KKM[$xyz].'</td><td align="center">'.$_siswa->getNilaiUTS($kode_mapel).'</td><td align="center">'.angka_huruf($_siswa->getNilaiUTS($kode_mapel)).'</td><td align="center">'.$rata[$x]['uts'].'</td><td align="center">'.keterangan($_siswa->getNilaiUTS($kode_mapel),$_KKM[$xyz]).'</td>';
                          $html[$siswa_count] .="</tr>";
                      }
                      $jumlahNilai=$jumlahNilai+$_siswa->getNilaiUTS($kode_mapel);
                  }
                  $html[$siswa_count] .='<tr><td></td><th style="text-align:center;">JUMLAH</th><td></td><td style="text-align:center;">'.$jumlahNilai.'</td><td colspan="3" style="text-align:center"><b>'.Dibaca($jumlahNilai).'</b></td></tr>';

                  $html[$siswa_count] .='   </table>
                    <br />
                    <br />
                    <br />
                    <br />
                    <table style="text-align:center;width:100%;font-size:75%;">
                        <tr>
                            <td style="width:33%"> </td><td style="width:33%"> </td><td style="width:34%">Semarang, 31 Oktober 2015</td>
                        </tr>
                        <tr>
                            <td>Kepala Sekolah</td><td>Orang Tua/Wali</td><td style="width:50%">Wali Kelas</td>
                        </tr>
                        <tr>
                            <td><br><img width="150px" src="assets/img/ttd_smp1.png"><br>Drs. H. Nusantara, MM</td><td><br><br><br><br><br><br>___________________________</td><td style="width:50%"><br><br><br><br><br><br>'.$nama_wali.'</td>
                        </tr>
                        <tr nobr="true">
                            <td>NIP. 196010101988031015</td><td></td><td>NIP. '.$nip_wali.'</td>
                        </tr>
                    </table>
                    <pagebreak />';
                    $data_text.=$html[$siswa_count];
          }

          if($_GET['download']=="1"){
            $mpdf->WriteHTML($data_text);
            $mpdf->Output('Laporan Hasil Belajar Kelas '.$kelas.$subkelas.'.pdf','D');
          }else{
              //Show ke web
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
              for ($i=0; $i < $jumlah_siswa; $i++) {
                  echo '<page size="A4">'.$html[$i].'</page>';
              }
          }

      }
  }else{
      echo '<page size="A4"><p style="text-align:center">Masukan data Kelas dan Sub Kelas terlebih dahulu</p></page>';
  }

  exit;
?>
