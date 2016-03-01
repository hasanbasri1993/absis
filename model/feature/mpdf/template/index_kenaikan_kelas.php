<?php
//updated by fadhilimamk 26.05.15

$kelas=$_GET['kelas'];
$subkelas=$_GET['subkelas'];
$semester="1";


/// BUAT TANGGAL INDONESIA
        function DateToIndo($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
        // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
        $BulanIndo = array("Januari", "Februari", "Maret",
                           "April", "Mei", "Juni",
                           "Juli", "Agustus", "September",
                           "Oktober", "November", "Desember");
    
        $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
        $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
        $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
        
        $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
        return($result);
        }

        $tanggal_cetak="18 April 2015";


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


//// Catatan guru      
                function catatan_guru($nil,$kkm){
                        if($nil<$kkm){
                                $ket='Tidak tuntas';
                        }else if($nil>=$kkm){
                                $ket='Tuntas';
                        }
                        return $ket;
                }

////FUNGSI RATAAN KELAS




require "../../controller/config/config.php";
require "../../excel/class_ledger.php";

//include "../../view/main/proses_ledger.php";


include("mpdf.php");

$pelajaran=array(   "Pendidikan Agama",
                            "Pendidikan Kewarganegaraan",
                            "Bahasa Indonesia",
                            "Bahasa Inggris",
                            "Matematika",
                            "Ilmu Pengetahuan Alam",
                            "Ilmu Pengetahuan Sosial",
                            "Seni Budaya",
                            "Pendidikan Jasmani, Olahraga, dan Kesehatan",
                            "Teknologi Informasi dan Komunikasi",
                            "Bahasa Jawa");


$mpdf=new mPDF('win-1252','A4',0,'','15','15','10','3','',''); 
$mpdf->useOnlyCoreFonts = true;    // false is default
//$mpdf->SetProtection(array('copy','print'), '', 'ganesha3');
$mpdf->useSubstitutions=false;
$mpdf->simpleTables = true;
$mpdf->SetWatermarkImage('img/logo-smp1.png',0.2,63);
$mpdf->showWatermarkImage = true;


//for ($juml=0; $juml<=33; $juml++) { 
    function CariNilaiSB($array){
        $joss=array();
        for ($i=5; $i < 16; $i++) { 
            if ($array[0][$i]=="SB"){
                array_push($joss, $i);
            }
            
        }
        return $joss;
    }

    function HitungNilaiS($array){
        $joss=array();
        $nilaiSB=0;
        $nilaiB=0;
        for ($i=5; $i < 16; $i++) { 
            if ($array[0][$i]=="SB"){
                $nilaiSB+=1;;
            }
            
        }

        for ($i=5; $i < 16; $i++) { 
            if ($array[0][$i]=="B"){
                $nilaiB+=1;;
            }
            
        }

        if ($nilaiSB>$nilaiB){
            $nilai="SB";
        } elseif ($nilaiB>$nilaiSB){
            $nilai="B";
        } else{}

        return $nilai;
    }

    function CariNilaiB($array){
        $joss=array();
        for ($i=5; $i < 16; $i++) { 
            if ($array[0][$i]=="B"){
                array_push($joss, $i);
            }
            
        }
        return $joss;
    }



function searchMapelJO($id) {
    $id-=5;
    return $id;
}
function searchMapel($id) {
    //$id-=5;
   switch ($id) {
       case '8':
           return 0;
           break;
        case '9':
           return 0;
           break;
        case '10':
           return 0;
           break;
        case '11':
           return 0;
           break;
        case '13':
           return 1;
           break;
        case '1':
           return 2;
           break;
        case '7':
           return 3;
           break;
        case '5':
           return 4;
           break;
        case '6':
           return 5;
           break;
        case '2':
           return 6;
           break;
        case '15':
           return 7;
           break;
        case '12':
           return 8;
           break;
        case '14':
           return 9;
           break;
        case '3':
           return 10;
           break;
            
       default:
           # code...
           break;
   }
   //return null;
}

function searchForId($id, $array) {
   foreach ($array as $key => $val) {
       if ($val['mata_pelajaran_id'] === $id) {
           return $key;
       }
   }
   return null;
}

function nilaiPredikat($nilai){
    if ($nilai>3.83 AND $nilai<=4){
        return "A";
    } elseif ($nilai>3.50 AND $nilai<=3.83) {
        return "A-";
    } elseif ($nilai>3.17 AND $nilai<=3.50) {
        return "B+";
    } elseif ($nilai>2.83 AND $nilai<=3.17) {
        return "B";
    } elseif ($nilai>2.50 AND $nilai<=2.83) {
        return "B-";
    } elseif ($nilai>2.17 AND $nilai<=2.50) {
        return "C+";
    } elseif ($nilai>1.83 AND $nilai<=2.17) {
        return "C";
    } elseif ($nilai>1.50 AND $nilai<=1.83) {
        return "C-";
    } elseif ($nilai>1.17 AND $nilai<=1.50) {
        return "D+";
    } elseif ($nilai>1 AND $nilai<=1.17) {
        return "D";
    } else {
        return "ERROR";
    }
    return null;
}

$resultGuru = $dbo->prepare("SELECT * FROM walikelas_2014 WHERE kelas=:kelas AND subkelas=:subkelas");
$resultGuru->bindValue(":kelas",$kelas,PDO::PARAM_STR);
$resultGuru->bindValue(":subkelas",$subkelas,PDO::PARAM_STR);
$resultGuru->execute();
$guruCount= $resultGuru->rowCount();
$guruData = $resultGuru->FetchAll();

$NIP_WALI=$guruData[0]['nip'];
$NAMA_WALI=$guruData[0]['nama'];


$resultGuru = $dbo->prepare("SELECT * FROM user_guru_2014 WHERE kelas=:kelas AND subkelas=:subkelas");
$resultGuru->bindValue(":kelas",$kelas,PDO::PARAM_STR);
$resultGuru->bindValue(":subkelas",$subkelas,PDO::PARAM_STR);
$resultGuru->execute();
$guruCount= $resultGuru->rowCount();
$guruData = $resultGuru->FetchAll();

$resultSiswa = $dbo->prepare("SELECT * FROM user_siswa_2014 WHERE kelas =:kelas AND subkelas =:subkelas");
$resultSiswa->bindParam(":kelas",$kelas,PDO::PARAM_STR);
$resultSiswa->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);
$resultSiswa->execute();
$siswaCount= $resultSiswa->rowCount();
$siswaData = $resultSiswa->FetchAll();

echo $siswaCount;
$siswaCountProcess=0;
while ($siswaCountProcess<>$siswaCount)
{
    if ($siswaData[$siswaCountProcess]['agama']==="ISLAM")
        {
            $id_agama="9";
        }    
    elseif ($siswaData[$siswaCountProcess]['agama']==="KRISTEN" OR $siswaData[$siswaCountProcess]['agama']==="KRISTEN/PROTESTAN")
        {
            $id_agama="11";
        } 
    elseif ($siswaData[$siswaCountProcess]['agama']==="KATOLIK")
        {
            $id_agama="10";
        } 
    elseif ($siswaData[$siswaCountProcess]['agama']==="HINDU")
        {
            $id_agama="8";
        } 
    else {$id_agama="9";}

    //$nis="1";
    $resultNilaiP = $dbo->prepare("SELECT * FROM ledger_pengetahuan_2014 WHERE nis=:nis");
    $resultNilaiP->bindParam(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);
    $resultNilaiP->execute();
    //$nilaiCount= $resultSiswa->rowCount();
    $nilaiDataP = $resultNilaiP->FetchAll();
    $jumlahNilai=0;
    $jumlahNilai=$nilaiDataP[0]['agama_p']+$nilaiDataP[0]['pkn_p']+$nilaiDataP[0]['bi_p']+$nilaiDataP[0]['bing_p']+$nilaiDataP[0]['mat_p']+$nilaiDataP[0]['ipa_p']+$nilaiDataP[0]['ips_p']+$nilaiDataP[0]['seni_p']+$nilaiDataP[0]['jasmani_p']+$nilaiDataP[0]['prakarya_p']+$nilaiDataP[0]['jawa_p'];
   // for ($o=0; $o <10 ; $o++) { 
   //     $jumlahNilai=$jumlahNilai+$nilaiDataP[0][$o];
   // }
    
    //echo $siswaData[$siswaCountProcess]['nis'];
    //print_r($nilaiDataP);

    $resultNilaiR = $dbo->prepare("SELECT AVG(agama_p),AVG(pkn_p),AVG(bi_p),AVG(bing_p),AVG(mat_p),AVG(ipa_p),AVG(ips_p),AVG(seni_p),AVG(jasmani_p),AVG(prakarya_p),AVG(jawa_p) FROM ledger_pengetahuan_2014 WHERE kelas=:kelas and subkelas=:subkelas");
    $resultNilaiR->bindParam(":kelas",$kelas,PDO::PARAM_STR);
    $resultNilaiR->bindParam(":subkelas",$subkelas,PDO::PARAM_STR);
    $resultNilaiR->execute();
    //$nilaiCount= $resultSiswa->rowCount();
    $nilaiDataR = $resultNilaiR->FetchAll();

  


   
    

   

   



//////////////////////////////////////////////////////////////VARIABEL YANG DIBUTUHKAN///////////////////////////////////////////////

        $nama = $siswaData[$siswaCountProcess]['nama'];
        $induk = $siswaData[$siswaCountProcess]['nis_fix'];
        $sekolah = 'SMP NEGERI 1 SEMARANG';
        $_kelas=$kelas." ".strtoupper($subkelas);
        $semester ='2 / GENAP';
        $tahun_pelajaran = '2014 / 2015';
        $bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $date =date(" d ").$bulan[(int)date('m')].date(" Y"); // Tanggal pembuatan rapot
        $pelajaran=array(   "Pendidikan Agama",
                            "Pendidikan Kewarganegaraan",
                            "Bahasa Indonesia",
                            "Bahasa Inggris",
                            "Matematika",
                            "Ilmu Pengetahuan Alam",
                            "Ilmu Pengetahuan Sosial",
                            "Seni Budaya",
                            "Pendidikan Jasmani, Olahraga, dan Kesehatan",
                            "Teknologi Informasi dan Komunikasi",
                            "Bahasa Jawa");
        $pelajaranRataan=array(   "AVG(agama_p)","AVG(pkn_p)","AVG(bi_p)","AVG(bing_p)","AVG(mat_p)","AVG(ipa_p)","AVG(ips_p)","AVG(seni_p)","AVG(jasmani_p)","AVG(prakarya_p)","AVG(jawa_p)");
        $pelajaranNilai=array(   "agama_p",
                            "pkn_p",
                            "bi_p",
                            "bing_p",
                            "mat_p",
                            "ipa_p",
                            "ips_p",
                            "seni_p",
                            "jasmani_p",
                            "prakarya_p",
                            "jawa_p");
        $_KKM=array(80,80,80,80,78,78,80,80,80,80,80,81,80,80,80,80,78,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80,80);

        ///// IKI HURUNG BENER!!!!! 
        //-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        $guru_pelajaran=array($guruData[searchForId($id_agama,$guruData)]['nama'],
                            $guruData[searchForId('13',$guruData)]['nama'],
                            $guruData[searchForId('1',$guruData)]['nama'],
                            $guruData[searchForId('2',$guruData)]['nama'],
                            $guruData[searchForId('7',$guruData)]['nama'],
                            $guruData[searchForId('5',$guruData)]['nama'],
                            $guruData[searchForId('6',$guruData)]['nama'],
                            $guruData[searchForId('15',$guruData)]['nama'],
                            $guruData[searchForId('12',$guruData)]['nama'],
                            $guruData[searchForId('14',$guruData)]['nama'],
                            $guruData[searchForId('3',$guruData)]['nama']);
        $angka_mapel=array($id_agama,'13','1','7','5','6','2','15','12','14','3');
        //Diisi sama wali kelas!!!!
        //Guru Pelajaran Keterampilan Sama Guru TIK belum diganti

        $sqlb = "
        SELECT * FROM ekskul_nilai_2014
        INNER JOIN daftar_ekskul
        ON ekskul_nilai_2014.ekskul_id=daftar_ekskul.ekskul_id
        WHERE nis=:nis
        ";
        $b = $dbo->prepare("$sqlb");
        $b->bindParam(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);    
        $b->execute();
        $rowNB = $b->rowCount();
        $rowb = $b->fetchAll();

       $ekstrakurikuler=null;

        if ($rowNB==1){
            $ekstrakurikuler[0][0]=$rowb[0]['nama_ekskul'];
            $ekstrakurikuler[0][1]=$rowb[0]['keterangan'];
            $ekstrakurikuler[0][2]=$rowb[0]['nilai'];
        } elseif ($rowNB==2){
           $ekstrakurikuler[0][0]=$rowb[0]['nama_ekskul'];
           $ekstrakurikuler[0][1]=$rowb[0]['keterangan'];
           $ekstrakurikuler[0][2]=$rowb[0]['nilai'];
           $ekstrakurikuler[1][0]=$rowb[1]['nama_ekskul'];
           $ekstrakurikuler[1][1]=$rowb[1]['keterangan'];
           $ekstrakurikuler[1][2]=$rowb[1]['nilai'];
           
        } elseif ($rowNB==3){
            $ekstrakurikuler[0][0]=$rowb[0]['nama_ekskul'];
           $ekstrakurikuler[0][1]=$rowb[0]['keterangan'];
           $ekstrakurikuler[0][2]=$rowb[0]['nilai'];
           $ekstrakurikuler[1][0]=$rowb[1]['nama_ekskul'];
           $ekstrakurikuler[1][2]=$rowb[1]['nilai'];
           $ekstrakurikuler[1][1]=$rowb[1]['keterangan'];
           $ekstrakurikuler[2][0]=$rowb[2]['nama_ekskul'];
           $ekstrakurikuler[2][1]=$rowb[2]['keterangan'];
           $ekstrakurikuler[2][2]=$rowb[2]['nilai'];
        } elseif ($rowNB==0){
           $ekstrakurikuler[0][0]="-";
           $ekstrakurikuler[0][1]= "-";
           $ekstrakurikuler[0][2]="-";
           
        }
        

        $resultHadir = $dbo->prepare("SELECT * FROM daftarhadir_2014 WHERE nis=:nis");
        $resultHadir->bindValue(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);
        $resultHadir->execute();
        $hadirData=$resultHadir->FetchAll();

        if ($hadirData[0]['sakit']==null){
            $hadirData[0]['sakit']=0;
        }
        if ($hadirData[0]['izin']==null){
            $hadirData[0]['izin']=0;
        }
        if ($hadirData[0]['alpha']==null){
            $hadirData[0]['alpha']=0;
        }

        $ketidakhadiran=array(  "Sakit",$hadirData[0]['sakit'],
                                "Izin",$hadirData[0]['izin'],
                                "Tanpa Keterangan",$hadirData[0]['alpha']);
        //MULTIDIMENSIIONAL ARRAY UNTUK CATATAN SIKAP PER MAPEL(3)
       
   
     
       

/////////////////////////////////////////////////////////////////RAPOT UTAMA SISWA///////////////////////////////////////////////////////////////////////////


if($siswaCountProcess<>0){
    $html.='<pagebreak />';
}

$html .= '
    <table style="width:100%" >
        <tr>
            <td style="width:12%">
                <img width="60px" src="img/logo-pemkot.jpg">
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
    <h5 style="text-align:center">LAPORAN HASIL BELAJAR PESERTA DIDIK AKHIR SEMESTER GENAP</h5>
    <table style="font-size:75%" >
        <tr>
            <td style="width:20%">NAMA PESERTA DIDIK</td>
            <td style="width:45%">: '.$nama.'</td>
            <td style="width:20%">KELAS</td>
            <td style="width:15%">: '.$_kelas.'</td>
        </tr>
        <tr>
            <td>NOMOR INDUK</td>
            <td>: '.$induk.'</td>
            <td>SEMESTER</td>
            <td>: '.$semester.'</td>
        </tr>
        <tr>
            <td>NAMA SEKOLAH</td>
            <td>: '.$sekolah.'</td>
            <td>TAHUN PELAJARAN</td>
            <td>: '.$tahun_pelajaran.'</td>
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

for ($x=0; $x<=10; $x++) { 
    $c=$x+1;
    if($kelas==7){
        $xyz=$x;
    }else if($kelas==8){
        $xyz=$x+11;
    }else if($kelas==9){
        $xyz=$x+12;
    }
    if($x==9){
        $html .='<tr><td style="text-align:center;">'.$c.'.</td><td colspan="6">Pilihan *)</td></tr>
                 <tr><td style="text-align:center;"> </td><td><strong>'.$pelajaran[$x].'</strong><br /> '.$guru_pelajaran[$x].'</td><td align="center">'.$_KKM[$xyz].'</td><td align="center">'.$nilaiDataP[0][$pelajaranNilai[$x]].'</td><td align="center">'.angka_huruf($nilaiDataP[0][$pelajaranNilai[$x]]).'</td><td align="center">'.round($nilaiDataR[0][$pelajaranRataan[$x]], 0).'</td><td align="center">'.catatan_guru($nilaiDataP[0][$pelajaranNilai[$x]],$_KKM[$xyz]).'</td>';
    }else if($x==10){
        $html .='<tr><td style="text-align:center;">'.$c.'.</td><td colspan="6">Mulok **)</td></tr>
                 <tr><td style="text-align:center;"> </td><td><strong>'.$pelajaran[$x].'</strong><br /> '.$guru_pelajaran[$x].'</td><td align="center">'.$_KKM[$xyz].'</td><td align="center">'.$nilaiDataP[0][$pelajaranNilai[$x]].'</td><td align="center">'.angka_huruf($nilaiDataP[0][$pelajaranNilai[$x]]).'</td><td align="center">'.round($nilaiDataR[0][$pelajaranRataan[$x]], 0).'</td><td align="center">'.catatan_guru($nilaiDataP[0][$pelajaranNilai[$x]],$_KKM[$xyz]).'</td>';
    }else{
        $html .= '<tr><td style="text-align:center;">'.$c.'.</td><td><strong>'.$pelajaran[$x].'</strong><br />'.$guru_pelajaran[$x].'</td><td align="center">'.$_KKM[$xyz].'</td><td align="center">'.$nilaiDataP[0][$pelajaranNilai[$x]].'</td><td align="center">'.angka_huruf($nilaiDataP[0][$pelajaranNilai[$x]]).'</td><td align="center">'.round($nilaiDataR[0][$pelajaranRataan[$x]], 0).'</td><td align="center">'.catatan_guru($nilaiDataP[0][$pelajaranNilai[$x]],$_KKM[$xyz]).'</td>';
        $html .="</tr>"; 
    }
}
    $html .='<tr><td></td><th style="text-align:center;">JUMLAH</th><td></td><td style="text-align:center;">'.$jumlahNilai.'</td><td></td><td></td><td></td></tr>'; 

           
 $html .='   </table>
    <br />
    <table cellspacing="0" cellpadding="1" border="1" style="width:100%;font-size:75%;border: 1px;border-collapse:collapse;border-color:black">
        <tr>
            <td style="width:30%;text-align:center;">Kegiatan</td><td style="width:30%;text-align:center;">Jenis</td><td style="width:5%;text-align:center;">Nilai</td><td style="width:35%;text-align:center;">Keterangan</td>
        </tr>';
          $html.="<tr><td rowspan='3'>Pengembangan Diri :</td>";
            for ($xx=0; $xx<=1; $xx++) { 
              if($ekstrakurikuler[$xx][0]<>''){
                if($xx<>0){
                    $html .="<tr>";
                }
                $html .= "<td>".$ekstrakurikuler[$xx][0]."</td><td align='center'>".$ekstrakurikuler[$xx][2]."</td><td>".$ekstrakurikuler[$xx][1]."</td></tr>";
              }else{
                $html .= "<tr><td>-</td><td align='center'>-</td><td>-</td></tr>";
              }
            }
 $html .='</table>
    <br />
    <div style="float:left;width:48%">
        <table border="1" style="width:100%;font-size:75%;border: 1px;border-collapse:collapse;border-color:black;outline: thin solid black;">
          <tr><td colspan="3" style="text-align:center;">AKHLAK DAN KEPRIBADIAN</td>
          <tr><td>Kejujuran</td><td> (A/B/C) </td><td> (Deskripsi) </td></tr>
          <tr><td>Kedisiplinan</td><td> (A/B/C) </td><td> (Deskripsi) </td></tr>
          <tr><td>Tanggung Jawab</td><td> (A/B/C) </td><td> (Deskripsi) </td></tr>
        </table>
    </div>
    <div style="float:right;width:48%">
        <table border="1" style="width:100%;font-size:75%;border: 1px;border-collapse:collapse;border-color:black;outline: thin solid black;">
        <tr><td colspan="2" style="text-align:center;">KETIDAKHADIRAN</td></tr>';    
            $ket = array('Sakit','Izin','Tanpa Keterangan');
            for ($xxx=0; $xxx<=2; $xxx=$xxx+1) { 
                $html .= "<tr><td>".$ket[$xxx]."</td><td> xx hari</td></tr>";
            }
 $html .='</table></div>';
 $kelas_next=$kelas+1;
 $html .='
    <br />
    <br />
    <br />
    <br />
    <div style="width:26%;float:left;font-size:80%;padding:5px">
        <br /><br /><br />
        <article style="text-align:center">
        <br>
        <br><br>
        Orangtua/Wali
        <br><br><br><br><br>________________________<br><br>
        </article>
    </div>
    <div style="width:26%;float:left;font-size:80%;padding:5px">
        <br /><br /><br />
        <article style="text-align:center">
        <br>
        <br><br>
        Wali Kelas
        <br><br><br><br><br>'.$NAMA_WALI.'<br>NIP. '.$NIP_WALI.'
        </article>
    </div>
    <div style="width:40%;float:right;font-size:80%;border-style: solid;border-width: 2px;border-color: black;padding:5px">
        <b>Keputusan : </b><br />
        Berdasarkan hasil yang dicapai pada semester 1 dan 2 maka peserta didik ditetapkan
        <article style="text-align:center">
        <b>Naik ke kelas '.$kelas_next.' / Tinggal di kelas '.$kelas.'</b>
        <br><br>
        Semarang, '.$tanggal_cetak.'<br />
        Kepala Sekolah
        <br><img width="130px" src="img/ttd.png"><br>Drs. H. Nusantara, MM<br>NIP. 196010101988031015
        </article>
    </div>
    ';
 //$html.='<pagebreak />';

$siswaCountProcess++;
}
$mpdf->WriteHTML($html);

$mpdf->Output('KENAIKAN KELAS '.$kelas.' '.$subkelas.'.pdf','D'); exit;

exit;

?>