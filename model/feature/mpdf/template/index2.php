<?php
//updated by fadhilimamk 15.12.14

/*
$kelas=$_GET['kelas'];
$subkelas=$_GET['subkelas'];
$semester="1";


require "../../controller/config/config.php";


include("mpdf.php");

$pelajaran=array(   "Pendidikan Agama dan Budi Pekerti",
                            "Pendidikan Pancasila dan Kewarganegaraan",
                            "Bahasa Indonesia",
                            "Matematika",
                            "Ilmu Pengetahuan Alam",
                            "Ilmu Pengetahuan Sosial",
                            "Bahasa Inggris",
                            "Seni Budaya",
                            "Pendidikan Jasmani, Olahraga, dan Kesehatan",
                            "Prakarya",
                            "Bahasa Jawa");


$mpdf=new mPDF('win-1252','A4','','');
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
    //echo $siswaData[$siswaCountProcess]['nis'];
    //print_r($nilaiDataP);

    $resultNilaiK = $dbo->prepare("SELECT * FROM ledger_ketrampilan_2014 WHERE nis=:nis");
    $resultNilaiK->bindParam(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);
    $resultNilaiK->execute();
    //$nilaiCount= $resultSiswa->rowCount();
    $nilaiDataK = $resultNilaiK->FetchAll();

    $resultNilaiS = $dbo->prepare("SELECT * FROM ledger_sikap_2014 WHERE nis=:nis");
    $resultNilaiS->bindParam(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);
    $resultNilaiS->execute();
    //$nilaiCount= $resultSiswa->rowCount();
    $nilaiDataS = $resultNilaiS->FetchAll();

    //print_r($nilaiDataS);


    $sikap_antar_mapel['mapel']['array']=CariNilaiSB($nilaiDataS);

    if ($sikap_antar_mapel['mapel']['array'][2]==null){
         $sikap_antar_mapel['mapel']['cad']=CariNilaiB($nilaiDataS);
         
         $sikap_antar_mapel['mapel']['array'][2]=$sikap_antar_mapel['mapel']['cad'][1];
    }

    if ( $sikap_antar_mapel['mapel']['array'][1]==null AND $sikap_antar_mapel['mapel']['array'][2]==null){
         $sikap_antar_mapel['mapel']['cad']=CariNilaiB($nilaiDataS);
         $sikap_antar_mapel['mapel']['array'][1]=$sikap_antar_mapel['mapel']['cad'][0];
         $sikap_antar_mapel['mapel']['array'][2]=$sikap_antar_mapel['mapel']['cad'][1];
    }

   

    $sikap_antar_mapel['mapel']['baik']=$pelajaran[searchMapelJO($sikap_antar_mapel['mapel']['array'][0])].', '.$pelajaran[searchMapelJO($sikap_antar_mapel['mapel']['array'][1])].', dan '.$pelajaran[searchMapelJO($sikap_antar_mapel['mapel']['array'][2])].'.';
     //print_r($sikap_antar_mapel);

    // echo searchMapel($sikap_antar_mapel['mapel']['array'][0];

    $sql = "SELECT DISTINCT jenis FROM sikap_nilai_fix_2014 WHERE nis=:nis AND nilai=\"SB\"\n"
    . "ORDER BY `sikap_nilai_fix_2014`.`count` DESC LIMIT 3";

    $resultTopik = $dbo->prepare("$sql");
    $resultTopik->bindParam(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);
    //$resultTopik->bindParam(":mata_pelajaran",$i,PDO::PARAM_STR);
    $resultTopik->execute();
    $topikCount= $resultTopik->rowCount();
    $topikData = $resultTopik->FetchAll();

    $sikap_antar_mapel['nilai']['baik']=$topikData[0]['jenis'].', '.$topikData[1]['jenis'].', dan '.$topikData[2]['jenis'].',';
    /*

    $sql = "SELECT DISTINCT mata_pelajaran,SUM(count) FROM sikap_nilai_fix_2014 WHERE nis=:nis AND nilai=\"SB\"\n"
    . "ORDER BY `sikap_nilai_fix_2014`.`SUM(count)` DESC LIMIT 3";

    $resultTopik = $dbo->prepare("$sql");
    $resultTopik->bindParam(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);
    //$resultTopik->bindParam(":mata_pelajaran",$i,PDO::PARAM_STR);
    $resultTopik->execute();
    $topikCount= $resultTopik->rowCount();
    $topikData = $resultTopik->FetchAll();

   // echo $pelajaran[searchMapel('1')];
    
    $sikap_antar_mapel['mapel']['baik']=$pelajaran[searchMapel($topikData[0]['mata_pelajaran'])].', '.$pelajaran[searchMapel($topikData[1]['mata_pelajaran'])].', dan '.$pelajaran[searchMapel($topikData[2]['mata_pelajaran'])].',';

  *x/

    $sql = "SELECT DISTINCT jenis FROM sikap_nilai_fix_2014 WHERE nis=:nis AND nilai=\"B\"\n"
    . "ORDER BY `sikap_nilai_fix_2014`.`count` ASC LIMIT 2";



    $resultTopik = $dbo->prepare("$sql");
    $resultTopik->bindParam(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);
    //$resultTopik->bindParam(":mata_pelajaran",$i,PDO::PARAM_STR);
    $resultTopik->execute();
    $topikCount= $resultTopik->rowCount();
    $topikData = $resultTopik->FetchAll();

    $sikap_antar_mapel['nilai']['kurang']=$topikData[0]['jenis'].' dan '.$topikData[1]['jenis'].',';

    $sql = "SELECT DISTINCT mata_pelajaran FROM sikap_nilai_fix_2014 WHERE nis=:nis AND nilai=\"B\"\n"
    . "ORDER BY `sikap_nilai_fix_2014`.`count` ASC LIMIT 2";



    $resultTopik = $dbo->prepare("$sql");
    $resultTopik->bindParam(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);
    //$resultTopik->bindParam(":mata_pelajaran",$i,PDO::PARAM_STR);
    $resultTopik->execute();
    $topikCount= $resultTopik->rowCount();
    $topikData = $resultTopik->FetchAll();

   // echo $pelajaran[$topikData[0]['mata_pelajaran']];

    $sikap_antar_mapel['mapel']['kurang']=$pelajaran[searchMapel($topikData[0]['mata_pelajaran'])].' dan '.$pelajaran[searchMapel($topikData[1]['mata_pelajaran'])].'.';
   //print_r($sikap_antar_mapel);
   // print_r($sikap_antar_mapel);
//////////////////////////////////////////////////////////////VARIABEL YANG DIBUTUHKAN///////////////////////////////////////////////

        $nama = $siswaData[$siswaCountProcess]['nama'];
        $induk = '';//$siswaData[$siswaCountProcess]['nis'];
        $sekolah = 'SMP NEGERI 1 SEMARANG';
        $_kelas=$kelas." ".strtoupper($subkelas);
        $semester ='1 / GASAL';
        $tahun_pelajaran = '2014/2015';
        $date =date(" d F Y"); // Tanggal pembuatan rapot
        $pelajaran=array(   "Pendidikan Agama dan Budi Pekerti",
                            "Pendidikan Pancasila dan Kewarganegaraan",
                            "Bahasa Indonesia",
                            "Matematika",
                            "Ilmu Pengetahuan Alam",
                            "Ilmu Pengetahuan Sosial",
                            "Bahasa Inggris",
                            "Seni Budaya",
                            "Pendidikan Jasmani, Olahraga, dan Kesehatan",
                            "Prakarya",
                            "Bahasa Jawa");
        $pelajaranNilai=array(   "agama_p",
                            "pkn_p",
                            "bi_p",
                            "mat_p",
                            "ipa_p",
                            "ips_p",
                            "bing_p",
                            "seni_p",
                            "jasmani_p",
                            "prakarya_p",
                            "jawa_p");
        $guru_pelajaran=array($guruData[searchForId($id_agama,$guruData)]['nama'],
                            $guruData[searchForId('13',$guruData)]['nama'],
                            $guruData[searchForId('1',$guruData)]['nama'],
                            $guruData[searchForId('7',$guruData)]['nama'],
                            $guruData[searchForId('5',$guruData)]['nama'],
                            $guruData[searchForId('6',$guruData)]['nama'],
                            $guruData[searchForId('2',$guruData)]['nama'],
                            $guruData[searchForId('15',$guruData)]['nama'],
                            $guruData[searchForId('12',$guruData)]['nama'],
                            $guruData[searchForId('14',$guruData)]['nama'],
                            $guruData[searchForId('3',$guruData)]['nama']);
        $angka_mapel=array($id_agama,'13','1','7','5','6','2','15','12','14','3');
        //Diisi sama wali kelas!!!!
        
        $ekstrakurikuler = array("Praja Muda Karana (Pramuka)",
                                "-",
                                "-");

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
          $jenis_desk=array('s','p','k');
        for ($i=1; $i <= 15; $i++) { 
           for ($j=0; $j <= 3; $j++) { 
               
                if ($jenis_desk[$j]=='s'){

                    $resultTopik = $dbo->prepare("SELECT DISTINCT jenis FROM sikap_nilai_fix_2014 WHERE mata_pelajaran=:mata_pelajaran AND nis=:nis LIMIT 3");
                    $resultTopik->bindParam(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);
                    $resultTopik->bindParam(":mata_pelajaran",$i,PDO::PARAM_STR);
                    $resultTopik->execute();
                    $topikCount= $resultTopik->rowCount();
                    $topikData = $resultTopik->FetchAll();

                    $topik[$i][$jenis_desk[$j]]['baik']=$topikData[0]['jenis'].', '.$topikData[1]['jenis'];
                    $topik[$i][$jenis_desk[$j]]['kurang']=$topikData[2]['jenis'];

                } elseif ($jenis_desk[$j]=='p'){
                    $resultTopik = $dbo->prepare("SELECT DISTINCT topik_nama FROM pengetahuan_nilai_fix_2014 WHERE nis=:nis AND mata_pelajaran=:mata_pelajaran ORDER BY rata DESC LIMIT 3");
                    $resultTopik->bindParam(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);
                    $resultTopik->bindParam(":mata_pelajaran",$i,PDO::PARAM_STR);
                    $resultTopik->execute();
                    $topikCount= $resultTopik->rowCount();
                    $topikData = $resultTopik->FetchAll();

                    $topik[$i][$jenis_desk[$j]]['baik']=$topikData[0]['topik_nama'].', '.$topikData[1]['topik_nama'];
                    $topik[$i][$jenis_desk[$j]]['kurang']=$topikData[2]['topik_nama'];

                } elseif ($j==2){
                    $resultTopik = $dbo->prepare("SELECT DISTINCT topik_nama FROM ketrampilan_nilai_fix_2014 WHERE nis=:nis AND mata_pelajaran=:mata_pelajaran ORDER BY rata DESC LIMIT 3");
                    $resultTopik->bindParam(":nis",$siswaData[$siswaCountProcess]['nis'],PDO::PARAM_STR);
                    $resultTopik->bindParam(":mata_pelajaran",$i,PDO::PARAM_STR);
                    $resultTopik->execute();
                    $topikCount= $resultTopik->rowCount();
                    $topikData = $resultTopik->FetchAll();

                    $topik[$i][$jenis_desk[$j]]['baik']=$topikData[0]['topik_nama'].', '.$topikData[1]['topik_nama'];
                    $topik[$i][$jenis_desk[$j]]['kurang']=$topikData[2]['topik_nama'];

                } else{}
           }
        }
       // print_r($topik);
        $a=array(
            'Kompetensi pengetahuan rerata sangat baik pada',
            'Sangat baik pada KD',
            'Sangat baik, sudah memahami banyak kompetensi, terutama dalam topik',
            'Sangat bagus dalam topik');

        $aa=array(
            'Kompetensi ketrampilan rerata sangat baik pada',
            'Sangat baik pada KD',
            'Sangat baik, sudah memahami banyak kompetensi, terutama dalam topik',
            'Sangat bagus dalam topik');
            
        $c=array(
            'Memiliki kelebihan dalam',
            'Kompetensi pengetahuan rerata baik pada',
            'Baik pada KD',
            'Baik, sudah memahami banyak kompetensi, terutama dalam topik',
            'Bagus dalam topik',
            'Memenuhi rata-rata dalam KD',
            'Sudah memuaskan dalam materi');

        $cc=array(
            'Memiliki kelebihan dalam',
            'Kompetensi ketrampilan rerata baik pada',
            'Baik pada KD',
            'Baik, sudah memahami banyak kompetensi, terutama dalam topik',
            'Bagus dalam topik',
            'Memenuhi rata-rata dalam KD',
            'Sudah memuaskan dalam materi');

        $b=array(
            ', tetapi perlu lebih teliti dalam kompetensi mengenai ',
            ', tetapi perlu meningkatkan kemampuan perihal ',
            ', akan tetapi masih perlu ditingkatkan pada pemahaman ',
            ', namun perlu meningkatkan dalam hal',
            ', selain itu perlu ditingkatkan dalam ');

        $d='Memiliki kelebihan dalam sikap ';
        $de='Memiliki sikap sangat baik dalam hal ';
        $df='Memiliki sikap cukup dalam hal ';
        $dd=' namun perlu meningkatkan dalam sikap ';
        $ff='Cukup dalam hal ';
        //$str="Sangat bagus dalam topik Lingkaran, namun masih harus ditingkatkan dalam topik Persamaan Garis Lurus. Secara keseluruhan dapat dikatakan cukup, orang tua sebaiknya mengawasi dalam proses belajar mengajar";
        
        $i=0;
        while ($i<=11){
            $j=0;
            while($j<>3){
                if ($jenis_desk[$j]=='s')
                {   if($nilaiDataS[0][$pelajaranNilai[$i]]=="SB"){

                        if ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']<>null){
                            $data[$i][$j]=$de.' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].$dd.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang'].'.';
                        } elseif ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']==null){
                            $data[$i][$j]=$de.' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                        }
                    } elseif($nilaiDataS[0][$pelajaranNilai[$i]]=="B"){

                        if ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']<>null){
                            $data[$i][$j]=$d.' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].$dd.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang'].'.';
                        } elseif ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']==null){
                            $data[$i][$j]=$d.' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                        }

                    } else {
                        if ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']<>null){
                            $data[$i][$j]=$df.' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                        } elseif ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']==null){
                            $data[$i][$j]=$df.' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                        }
                    }
                } 
                elseif ($jenis_desk[$j]=='p')
                {
                    if($nilaiDataP[0][$pelajaranNilai[$i]]>3.5 AND $nilaiDataP[0][$pelajaranNilai[$i]]<=4){

                            if ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']<>null){
                                        $data[$i][$j]=$a[rand(0,3)].' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].$b[rand(0,6)].$topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang'].'.';
                             } elseif ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']==null){
                                        $data[$i][$j]=$a[rand(0,3)].' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                                    }
                    } elseif($nilaiDataP[0][$pelajaranNilai[$i]]>2.50 AND $nilaiDataP[0][$pelajaranNilai[$i]]<=3.5) {

                           if ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']<>null){
                                $data[$i][$j]=$c[rand(0,6)].' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].$b[rand(0,6)].$topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang'].'.';
                            } elseif ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']==null){
                                $data[$i][$j]=$c[rand(0,6)].' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                            }
                    }else {
                        if ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']<>null){
                                $data[$i][$j]=$ff.' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                            } elseif ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']==null){
                                $data[$i][$j]=$ff.' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                            }
                    }

                } 
                elseif ($j==2)
                {
                    if($nilaiDataK[0][$pelajaranNilai[$i]]>3.5 AND $nilaiDataK[0][$pelajaranNilai[$i]]<=4){

                            if ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']<>null){
                                $data[$i][$j]=$aa[rand(0,3)].' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].$b[rand(0,6)].$topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang'].'.';
                            } elseif ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']==null){
                                $data[$i][$j]=$aa[rand(0,3)].' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                            }
                    } elseif ($nilaiDataK[0][$pelajaranNilai[$i]]>2.50 AND $nilaiDataK[0][$pelajaranNilai[$i]]<=3.5){ 

                            if ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']<>null){
                                $data[$i][$j]=$cc[rand(0,6)].' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].$b[rand(0,6)].$topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang'].'.';
                            } elseif ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']==null){
                                $data[$i][$j]=$cc[rand(0,6)].' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                            }

                    } else {

                            if ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']<>null){
                                $data[$i][$j]=$ff.' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                            } elseif ($topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik']<>null AND $topik[$angka_mapel[$i]][$jenis_desk[$j]]['kurang']==null){
                                $data[$i][$j]=$ff.' '.$topik[$angka_mapel[$i]][$jenis_desk[$j]]['baik'].'.';
                            }

                    }

                }  else{}
               
                $j++;
            }
            $i++;
        }

        $cek=HitungNilaiS($nilaiDataS);

        if ($cek=="SB"){
            $sikap_antar_mapel_joss = 'Menunjukkan sikap sangat baik dalam menerapkan sikap '.$sikap_antar_mapel['nilai']['baik'].' terutama dalam mapel '.$sikap_antar_mapel['mapel']['baik'].' Namun perlu meningkatkan dalam sikap '.$sikap_antar_mapel['nilai']['kurang'].' dalam mapel '.$sikap_antar_mapel['mapel']['kurang'];
        } elseif($cek=="B"){
            $sikap_antar_mapel_joss = 'Menunjukkan sikap baik dalam menerapkan sikap '.$sikap_antar_mapel['nilai']['baik'].' terutama dalam mapel '.$sikap_antar_mapel['mapel']['baik'].' Namun perlu meningkatkan dalam sikap '.$sikap_antar_mapel['nilai']['kurang'].' dalam mapel '.$sikap_antar_mapel['mapel']['kurang'];
        } else {
            $sikap_antar_mapel_joss = 'Menunjukkan sikap cukup dalam menerapkan sikap '.$sikap_antar_mapel['nilai']['baik'].' terutama dalam mapel '.$sikap_antar_mapel['mapel']['baik'].' Namun perlu meningkatkan dalam sikap '.$sikap_antar_mapel['nilai']['kurang'].' dalam mapel '.$sikap_antar_mapel['mapel']['kurang'];
        }

      




/////////////////////////////////////////////////////////////////RAPOT UTAMA SISWA///////////////////////////////////////////////////////////////////////////


// add a page
//$pdf->AddPage();

// create some HTML content
//$html ="";

$html .= '
    <table style="width:100%">
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
    <h5 style="text-align:center">LAPORAN HASIL PENCAPAIAN KOMPETENSI PESERTA DIDIK (UAS)</h5>
    <table style="font-size:75%">
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
            <th rowspan="2" style="width:25%">MATA PELAJARAN</th>
            <th colspan="2" style="width:20%">PENGETAHUAN</th>
            <th colspan="2" style="width:20%">KETERAMPILAN</th>
            <th colspan="2" style="width:30%">SIKAP SOSIAL DAN SPIRITUAL</th>
        </tr>
        <tr style="background-color:#E8E8E8;text-align:center">
            <th style="width:9%">NILAI</th>
            <th style="width:11%">PREDIKAT</th>
            <th style="width:9%">NILAI</th>
            <th style="width:11%">PREDIKAT</th>
            <th style="width:10%">DALAM<br />MAPEL</th>
            <th style="width:20%">ANTAR MAPEL</th>
        </tr>
        <tr>
            <th colspan="8" style="text-align:left">KELOMPOK A</th>
        </tr>
';

for ($x=0; $x<=6; $x++) { 
    $c=$x+1;
    $html .= '<tr><td style="text-align:center;">'.$c.'.</td><td><strong>'.$pelajaran[$x].'</strong><br />'.$guru_pelajaran[$x].'</td><td align="center">'.$nilaiDataP[0][$pelajaranNilai[$x]].'</td><td align="center">'.nilaiPredikat($nilaiDataP[0][$pelajaranNilai[$x]]).'</td><td align="center">'.$nilaiDataK[0][$pelajaranNilai[$x]].'</td><td align="center">'.nilaiPredikat($nilaiDataK[0][$pelajaranNilai[$x]]).'</td><td align="center">'.$nilaiDataS[0][$pelajaranNilai[$x]].'</td>';
    if($x == 0){
        $html .= '<td rowspan="13"><p>'.$sikap_antar_mapel_joss.'</p></td></tr>';
    }else{
        $html .="</tr>";
    }
} 
$html .= '<tr>
            <th colspan="7" style="text-align:left">KELOMPOK B</th>
        </tr>';
for ($y=7; $y<=10; $y++) { 
    $c=$y+1;
    $html .= '<tr><td style="text-align:center;">'.$c.'.</td><td><strong>'.$pelajaran[$y].'</strong><br />'.$guru_pelajaran[$y].'</td><td align="center">'.$nilaiDataP[0][$pelajaranNilai[$y]].'</td><td align="center">'.nilaiPredikat($nilaiDataP[0][$pelajaranNilai[$y]]).'</td><td align="center">'.$nilaiDataK[0][$pelajaranNilai[$y]].'</td><td align="center">'.nilaiPredikat($nilaiDataK[0][$pelajaranNilai[$y]]).'</td><td align="center">'.$nilaiDataS[0][$pelajaranNilai[$y]].'</td></tr>';
} 
$html .= "</table>";
$html .= '
    <br />
  <table cellspacing="0" cellpadding="1" border="1" style="width:100%;font-size:75%;border: 1px;border-collapse:collapse;border-color:black">
        <tr>
            <td style="width:40%;text-align:center;">Kegiatan Ekstrakurikuler</td><td style="width:60%;text-align:center;">Keterangan</td>
        </tr>';
            for ($xx=0; $xx<=2; $xx++) { 
                $html .= "<tr><td>".$ekstrakurikuler[$xx]."</td><td>-</td></tr>";
            }
        

$html .= '</table>
    <br />
    <table border="1" style="width:40%;font-size:75%;border: 1px;border-collapse:collapse;border-color:black;outline: thin solid black;">
        <tr><td colspan="2" style="text-align:center;">Ketidakhadiran</td></tr>';
        
            for ($xxx=0; $xxx<6; $xxx=$xxx+2) { 
                $html .= "<tr><td>".$ketidakhadiran[$xxx]."</td><td> ".$ketidakhadiran[$xxx+1]." hari</td></tr>";
            }
 $html .='   </table>
    <br />
    <br />
    <table style="text-align:center;width:100%;font-size:75%;">
        <tr nobr="true">
            <td style="width:30%">Mengetahui</td><td style="width:30%"></td><td style="width:40%"> Semarang,'.$date.'</td>
        </tr>
        <tr nobr="true">
            <td style="width:30%">Orang Tua/Wali</td><td style="width:30%">Wali Kelas,</td><td style="width:40%">Kepala Sekolah,</td>
        </tr>
        <tr nobr="true">
            <td style="width:30%"><br><br><br>___________________________</td><td style="width:30%"><br><br><br>nama kepala sekolah</td><td style="width:30%"><br><br><br>'.$NAMA_WALI.'</td>
        </tr>
        <tr nobr="true">
            <td style="width:30%">'.'</td><td style="width:30%">NIP kepala sekolah</td><td style="width:40%">NIP. '.$NIP_WALI.'</td>
        </tr>
    </table>';



/////////////////////////////////////////////////////////////////RAPOT DISKRIPSI SIKAP///////////////////////////////////////////////////////////////////////////

// add a page
//$pdf->AddPage();

// create some HTML content
//$html ="";

$html .= '
    <pagebreak />
    <h5 style="text-align:center">LAPORAN HASIL PENCAPAIAN KOMPETENSI PESERTA DIDIK (UAS)</h5>
    <br />
    <table style="font-size:75%">
        <tr>
            <td style="width:20%">NAMA PESERTA DIDIK</td>
            <td style="width:45%">: '." ".$nama.'</td>
            <td style="width:20%">KELAS</td>
            <td style="width:15%">: '." ".$_kelas.'</td>
        </tr>
        <tr>
            <td>NOMOR INDUK</td
            ><td>: '." ".$induk.'</td>
            <td>SEMESTER</td>
            <td>: '." ".$semester.'</td>
        </tr>
        <tr>
            <td>NAMA SEKOLAH</td>
            <td>:'." ".$sekolah.'</td>
            <td>TAHUN PELAJARAN</td>
            <td>:'." ".$tahun_pelajaran.'</td>
        </tr>
    </table>
    <br />

    <table border="1" style="font-size:75%;border: 1px;border-collapse:collapse;border-color:black;width:100%">
        <tr style="background-color:#E8E8E8;text-align:center;">
            <th width="5%">NO</th>
            <th width="35%">MATA PELAJARAN</th>
            <th width="30%">KOMPETENSI</th>
            <th width="30%">DESKRIPSI</th>
        </tr>
        <tr>
            <th colspan="4" style="text-align:left">KELOMPOK A</th>
        </tr>
';

for ($x=0; $x<=10; $x++) { 
    $c=$x+1;
    if ($x==7){
        $html .= '
        <tr>
            <th colspan="4" style="text-align:left">KELOMPOK B</th>
        </tr>';
    }
    $html.= '<tr nobr="true">
                <td rowspan="3" style="text-align:center;vertical:middle;">
                    '.$c.'
                </td>
                <td rowspan="3">'.$pelajaran[$x].'
                </td>
                <td>Sikap sosial dan spiritual
                </td>
                <td>'.$data[$x][0].'</td>
            </tr>
            <tr nobr="true">
                <td>Pengetahuan</td>
                <td>'.$data[$x][1].'</td>
            </tr>
            <tr nobr="true">
                <td>Keterampilan</td>
                <td>'.$data[$x][2].'</td>
            </tr>';

}

 $html .='   </table>
    <br />
    <br />
    <table style="text-align:center;width:100%;font-size:75%;">
        <tr nobr="true">
            <td style="width:30%">Mengetahui</td><td style="width:30%"></td><td style="width:40%"> Semarang,'.$date.'</td>
        </tr>
        <tr nobr="true">
            <td style="width:30%">Orang Tua/Wali</td><td style="width:30%">Wali Kelas,</td><td style="width:40%">Kepala Sekolah,</td>
        </tr>
        <tr nobr="true">
            <td style="width:30%"><br><br><br>___________________________</td><td style="width:30%"><br><br><br>nama kepala sekolah</td><td style="width:30%"><br><br><br>'.$NAMA_WALI.'</td>
        </tr>
        <tr nobr="true">
            <td style="width:30%">'.'</td><td style="width:30%">NIP kepala sekolah</td><td style="width:40%">NIP. '.$NIP_WALI.'</td>
        </tr>
    </table>';
    if($juml!=33){
    	 $html.='<pagebreak />';
    }

$siswaCountProcess++;
}
$mpdf->WriteHTML($html);

$mpdf->Output('LAPORAN HASIL PENCAPAIAN KOMPETENSI PESERTA DIDIK KELAS '.$kelas.' '.$subkelas.'.pdf','D'); exit;

exit;
*/
?>
