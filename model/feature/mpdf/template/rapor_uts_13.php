  <head>
    <style>
      body {
        background: #cccccc;
      }

      page[size="A4"] {
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
        body, page[size="A4"] {
          margin: 0;
          box-shadow: 0;
        }
      }
    </style>
  </head>

<?php

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


include $_SERVER['DOCUMENT_ROOT']."/model/feature/mpdf/mpdf.php";
include_once "model/class/master.php";

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

$mpdf=new mPDF('win-1252','A4',0,'','5','5','10','3','',''); 
$mpdf->useOnlyCoreFonts = true;
$mpdf->useSubstitutions=false;
$mpdf->simpleTables = true;
$mpdf->SetWatermarkImage('assets/img/logo-smp1.png',0.2,63);
$mpdf->showWatermarkImage = true;



$siswaCount=10;
$siswaCountProcess=0;
while ($siswaCountProcess<>$siswaCount)
{
    

/////////////////////////////////////////////////////////////////RAPOT UTAMA SISWA///////////////////////////////////////////////////////////////////////////


$html .= '
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
    <h5 style="text-align:center">LAPORAN HASIL BELAJAR PESERTA DIDIK TENGAH SEMESTER GENAP</h5>
    <table style="font-size:75%" >
        <tr>
            <td style="width:20%">NAMA PESERTA DIDIK</td>
            <td style="width:45%">: [NAMA]</td>
            <td style="width:20%">KELAS</td>
            <td style="width:15%">: [KELAS]</td>
        </tr>
        <tr>
            <td>NOMOR INDUK</td>
            <td>: [NIS]</td>
            <td>SEMESTER</td>
            <td>: [SEMESTER]</td>
        </tr>
        <tr>
            <td>NAMA SEKOLAH</td>
            <td>: [SEKOLAH]</td>
            <td>TAHUN PELAJARAN</td>
            <td>: [TA]</td>
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
                 <tr><td style="text-align:center;"> </td><td><strong>$pelajaran[$x]</strong><br /> $guru_pelajaran[$x]</td><td align="center">kkm</td><td align="center">nilai</td><td align="center">angkahuruf</td><td align="center">xx</td><td align="center">xx</td>';
    }else if($x==10){
        $html .='<tr><td style="text-align:center;">'.$c.'.</td><td colspan="6">Mulok **)</td></tr>
                 <tr><td style="text-align:center;"> </td><td><strong>$pelajaran[$x]</strong><br /> $guru_pelajaran[$x]</td><td align="center">kkm</td><td align="center">xx</td><td align="center">xxx</td><td align="center">xxx</td><td align="center">xxx</td>';
    }else{
        $html .= '<tr><td style="text-align:center;">'.$c.'.</td><td><strong>'.$pelajaran[$x].'</strong><br />'.$guru_pelajaran[$x].'</td><td align="center">'.$_KKM[$xyz].'</td><td align="center">'.$nilaiDataP[0][$pelajaranNilai[$x]].'</td><td align="center">'.angka_huruf($nilaiDataP[0][$pelajaranNilai[$x]]).'</td><td align="center">'.round($nilaiDataR[0][$pelajaranRataan[$x]], 0).'</td><td align="center">'.catatan_guru($nilaiDataP[0][$pelajaranNilai[$x]],$_KKM[$xyz]).'</td>';
        $html .="</tr>"; 
    }
}
    $html .='<tr><td></td><th style="text-align:center;">JUMLAH</th><td></td><td style="text-align:center;">'.$jumlahNilai.'</td><td></td><td></td><td></td></tr>'; 

           
 $html .='   </table>
    <br />
    <br />
    <br />
    <br />
    <table style="text-align:center;width:100%;font-size:115%;">
        <tr>
            <td style="width:33%"> </td><td style="width:33%"> </td><td style="width:34%">Semarang, '.$tanggal_cetak.'</td>
        </tr>
        <tr>
            <td style="width:50%">Kepala Sekolah</td><td style="width:50%">Orang Tua/Wali</td><td style="width:50%">Wali Kelas</td>
        </tr>
        <tr>
            <td style="width:50%"><br><img width="230px" src="img/ttd.png"><br>Drs. H. Nusantara, MM</td><td style="width:50%"><br><br><br><br><br><br>___________________________</td><td style="width:50%"><br><br><br><br><br><br>'.$NAMA_WALI.'</td>
        </tr>
        <tr nobr="true">
            <td style="width:50%">NIP. 196010101988031015</td><td style="width:50%"></td><td style="width:50%">NIP. '.$NIP_WALI.'</td>
        </tr>
    </table>';

    if($juml!=33){
         $html.='<pagebreak />';
    }

$siswaCountProcess++;
}
$mpdf->WriteHTML($html);

//$mpdf->Output('LAPORAN HASIL PENCAPAIAN KOMPETENSI PESERTA DIDIK KELAS '.$kelas.' '.$subkelas.'.pdf','D'); exit;
echo '<page size="A4">'.$html.'</page>';

?>