<?php

    function getNameFromNumber($num) {
        $num=$num-1;
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return getNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }


    $file_name ="";
    if (($kelas!="")AND($subkelas!="")AND($jenis!="")){

        $kelasx = new Kelas($kelas,$subkelas);
        $daftar_siswa= $kelasx->getSiswa();
        $daftar_mapel = $kelasx->getMapel();
        $jumlah_siswa= sizeof($daftar_siswa);
        $jumlah_L= $kelasx->getBanyakSiswaL();
        $jumlah_P= $kelasx->getBanyakSiswaP();
        $nip_wali= $kelasx->getWaliKelasNIP();
        $guru = new Guru($nip_wali);
        $nama_wali = $guru->getNama();
        $daftar_siswa= json_decode(json_encode($daftar_siswa),true);

        if ($jenis=="uts") {
            /** PHPExcel_IOFactory */
            include_once 'model/feature/phpexcel/Classes/PHPExcel/IOFactory.php';
            include_once 'model/class/master.php';
            ob_end_clean(); //removing single space character before the PHPExcel output.
            if (ob_get_contents()) ob_end_clean();


            $inputFileType = 'Excel2007';
            $inputFileName = 'model/feature/phpexcel/template/ledger_uts_temp.xlsx';


            /**  Create a new Reader of the type defined in $inputFileType  **/
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            /**  Load $inputFileName to a PHPExcel Object  **/
            $objPHPExcel = $objReader->load($inputFileName);
            
            // STYLING
            $objPHPExcel->getDefaultStyle()
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $styleBorderArray = array(
              'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                )
              )
            );

            $styleHeaderArray = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E0E0E0')
                )
            );

            $file_name ="Ledger UTS Gasal ".$kelas.$subkelas." 2015/2016";

            $sheet = $objPHPExcel->getActiveSheet();
            $sheet->setCellValue('A4', 'Kelas : '.$kelas.$subkelas);
            $sheet->setCellValue('C4', 'Wali Kelas : '.$nama_wali);

            $count=5;$arr_KKM = array();
            while ($count < sizeof($daftar_mapel)+5) {
                $sheet->setCellValue(getNameFromNumber($count).'5', $daftar_mapel[$count-5]['kode_nama']);
                $mapel = new Mapel($daftar_mapel[$count-5]['kode_nama'],$kelas,$subkelas);
                $sheet->setCellValue(getNameFromNumber($count).'6', $mapel->getKKM());
                array_push($arr_KKM, $mapel->getKKM());
                $count++;
            }
            $sheet->mergeCells(getNameFromNumber($count).'5:'.getNameFromNumber($count).'6');
            $sheet->setCellValue(getNameFromNumber($count).'5', 'Total');
            $sheet->mergeCells(getNameFromNumber($count+1).'5:'.getNameFromNumber($count+1).'6');
            $sheet->setCellValue(getNameFromNumber($count+1).'5', 'Rata-Rata');
            $sheet->mergeCells(getNameFromNumber($count+2).'5:'.getNameFromNumber($count+2).'6');
            $sheet->setCellValue(getNameFromNumber($count+2).'5', 'Peringkat');

            $count=7;$arr_peringkat= array();
            while ($count < $jumlah_siswa+7) {
                $sheet->setCellValue('A'.$count, ($count-6));
                $sheet->setCellValue('B'.$count, $daftar_siswa[$count-7]['nis']);
                $sheet->setCellValue('C'.$count, $daftar_siswa[$count-7]['nama']);
                $sheet->setCellValue('D'.$count, $daftar_siswa[$count-7]['kelamin']);
                $siswa = new Siswa($daftar_siswa[$count-7]['nis']);
                $banyakMapel=sizeof($daftar_mapel);
                $i=5;$jml_nilai=0;
                while ($i < sizeof($daftar_mapel)+5) {
                    //if ($daftar_mapel[$i-5]['kode_nama']=="AGAMA") {

                    	$_agm=$siswa->getAgama();

                    	if ($_agm=='ISLAM'){
                              $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAIS';
                          }else if ($_agm=='KRISTEN'){
                              $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAKRIS';
                          }else if ($_agm=='KATOLIK'){
                              $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAKAT';
                          }else if ($_agm=='HINDU'){
                              $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAHIN';
                          }
                        
                    //}
                    $nilai_uts = $siswa->getNilaiUTS($daftar_mapel[$i-5]['kode_nama']);
                    $sheet->setCellValue(getNameFromNumber($i).$count, $nilai_uts);
                    if ($nilai_uts < $arr_KKM[$i-5]) {
                        $sheet->getStyle(getNameFromNumber($i).$count)->applyFromArray(array('font' => array('color' => array('rgb' => 'FF0000'))));
                    }
                    $jml_nilai=$jml_nilai+$nilai_uts;
                    $i++;
                }
                $sheet->setCellValue(getNameFromNumber($i).$count, $jml_nilai);                             //TOTAL
                $mean = (float)number_format(($jml_nilai/sizeof($daftar_mapel)), 2, '.', '');
                $sheet->setCellValue(getNameFromNumber($i+1).$count, $mean);                                //RATA-RATA
                array_push($arr_peringkat, $jml_nilai);
                $count++;
            }

            // Membuat peringkat berdasar nilai total
            $count=7;
            $ordered_nilai = $arr_peringkat;
            rsort($ordered_nilai);
            foreach ($arr_peringkat as $key => $arr_peringkat_o) {
                foreach ($ordered_nilai as $ordered_key => $ordered_nilai_o) {
                    if ($arr_peringkat_o === $ordered_nilai_o) {
                        $key = $ordered_key;
                        break;
                    }
                }
                $sheet->setCellValue(getNameFromNumber($i+2).$count, ((int) $key + 1)); 
                $count++;
            }

            $sheet->getStyle('A5:'.getNameFromNumber($i+2).'6')->applyFromArray($styleHeaderArray);
            $sheet->getStyle('A5:'.getNameFromNumber($i+2).($count-1))->applyFromArray($styleBorderArray);


        }else if ($jenis=="uas") {
            /** PHPExcel_IOFactory */
            include_once 'model/feature/phpexcel/Classes/PHPExcel/IOFactory.php';
            include_once 'model/class/master.php';
            ob_end_clean(); //removing single space character before the PHPExcel output.
            if (ob_get_contents()) ob_end_clean();


            $inputFileType = 'Excel2007';
            $inputFileName = 'model/feature/phpexcel/template/ledger_uts_temp.xlsx';


            /**  Create a new Reader of the type defined in $inputFileType  **/
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            /**  Load $inputFileName to a PHPExcel Object  **/
            $objPHPExcel = $objReader->load($inputFileName);
            
            // STYLING
            $objPHPExcel->getDefaultStyle()
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $styleBorderArray = array(
              'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                )
              )
            );

            $styleHeaderArray = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E0E0E0')
                )
            );

            $file_name ="Ledger UAS Gasal ".$kelas.$subkelas." 2015/2016";

            $sheet = $objPHPExcel->getActiveSheet();
            $sheet->setCellValue('A1', 'LEDGER NILAI UAS SEMESTER GASAL TAHUN AJARAN 2015/2016');
            $sheet->setCellValue('A4', 'Kelas : '.$kelas.$subkelas);
            $sheet->setCellValue('C4', 'Wali Kelas : '.$nama_wali);

            $count=5;$arr_KKM = array();
            while ($count < sizeof($daftar_mapel)+5) {
                $sheet->setCellValue(getNameFromNumber($count).'5', $daftar_mapel[$count-5]['kode_nama']);
                $mapel = new Mapel($daftar_mapel[$count-5]['kode_nama'],$kelas,$subkelas);
                $sheet->setCellValue(getNameFromNumber($count).'6', $mapel->getKKM());
                array_push($arr_KKM, $mapel->getKKM());
                $count++;
            }
            $sheet->mergeCells(getNameFromNumber($count).'5:'.getNameFromNumber($count).'6');
            $sheet->setCellValue(getNameFromNumber($count).'5', 'Total');
            $sheet->mergeCells(getNameFromNumber($count+1).'5:'.getNameFromNumber($count+1).'6');
            $sheet->setCellValue(getNameFromNumber($count+1).'5', 'Rata-Rata');
            $sheet->mergeCells(getNameFromNumber($count+2).'5:'.getNameFromNumber($count+2).'6');
            $sheet->setCellValue(getNameFromNumber($count+2).'5', 'Peringkat');

            $count=7;$arr_peringkat= array();
            while ($count < $jumlah_siswa+7) {
                $sheet->setCellValue('A'.$count, ($count-6));
                $sheet->setCellValue('B'.$count, $daftar_siswa[$count-7]['nis']);
                $sheet->setCellValue('C'.$count, $daftar_siswa[$count-7]['nama']);
                $sheet->setCellValue('D'.$count, $daftar_siswa[$count-7]['kelamin']);
                $siswa = new Siswa($daftar_siswa[$count-7]['nis']);
                $banyakMapel=sizeof($daftar_mapel);
                $i=5;$jml_nilai=0;
                while ($i < sizeof($daftar_mapel)+5) {
                    //if ($daftar_mapel[$i-5]['kode_nama']=="AGAMA") {

                        $_agm=$siswa->getAgama();

                        if ($_agm=='ISLAM'){
                              $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAIS';
                          }else if ($_agm=='KRISTEN'){
                              $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAKRIS';
                          }else if ($_agm=='KATOLIK'){
                              $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAKAT';
                          }else if ($_agm=='HINDU'){
                              $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAHIN';
                          }
                        
                    //}
                    $nilai_uas = $siswa->getNilaiUAS($daftar_mapel[$i-5]['kode_nama']);
                    $sheet->setCellValue(getNameFromNumber($i).$count, $nilai_uas);
                    if ($nilai_uas < $arr_KKM[$i-5]) {
                        $sheet->getStyle(getNameFromNumber($i).$count)->applyFromArray(array('font' => array('color' => array('rgb' => 'FF0000'))));
                    }
                    $jml_nilai=$jml_nilai+$nilai_uas;
                    $i++;
                }
                $sheet->setCellValue(getNameFromNumber($i).$count, $jml_nilai);                             //TOTAL
                $mean = (float)number_format(($jml_nilai/sizeof($daftar_mapel)), 2, '.', '');
                $sheet->setCellValue(getNameFromNumber($i+1).$count, $mean);                                //RATA-RATA
                array_push($arr_peringkat, $jml_nilai);
                $count++;
            }

            // Membuat peringkat berdasar nilai total
            $count=7;
            $ordered_nilai = $arr_peringkat;
            rsort($ordered_nilai);
            foreach ($arr_peringkat as $key => $arr_peringkat_o) {
                foreach ($ordered_nilai as $ordered_key => $ordered_nilai_o) {
                    if ($arr_peringkat_o === $ordered_nilai_o) {
                        $key = $ordered_key;
                        break;
                    }
                }
                $sheet->setCellValue(getNameFromNumber($i+2).$count, ((int) $key + 1)); 
                $count++;
            }

            $sheet->getStyle('A5:'.getNameFromNumber($i+2).'6')->applyFromArray($styleHeaderArray);
            $sheet->getStyle('A5:'.getNameFromNumber($i+2).($count-1))->applyFromArray($styleBorderArray);
        }else if ($jenis=="uas_x") {

            /** PHPExcel_IOFactory */
            include_once 'model/feature/phpexcel/Classes/PHPExcel/IOFactory.php';
            include_once 'model/class/master.php';
            ob_end_clean(); //removing single space character before the PHPExcel output.
            if (ob_get_contents()) ob_end_clean();


            $inputFileType = 'Excel2007';
            $inputFileName = 'model/feature/phpexcel/template/ledger_uasr_temp.xlsx';


            /**  Create a new Reader of the type defined in $inputFileType  **/
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            /**  Load $inputFileName to a PHPExcel Object  **/
            $objPHPExcel = $objReader->load($inputFileName);
            
            // STYLING
            $objPHPExcel->getDefaultStyle()
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $styleBorderArray = array(
              'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                )
              )
            );

            $styleHeaderArray = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E0E0E0')
                )
            );

            $file_name ="Ledger Nilai Rapor UAS Gasal ".$kelas.$subkelas." 2015/2016";

            // BEGIN - PAGE 1
                $objPHPExcel->setActiveSheetIndex(0);
                $sheet = $objPHPExcel->getActiveSheet();

                $sheet->setCellValue('A1', 'LEDGER NILAI RAPOR UAS SEMESTER GASAL TAHUN AJARAN 2015/2016');
                $sheet->setCellValue('A4', 'Kelas : '.$kelas.$subkelas);
                $sheet->setCellValue('C4', 'Wali Kelas : '.$nama_wali);

                $count=5;$arr_KKM = array();
                while ($count < sizeof($daftar_mapel)+5) {
                    $sheet->setCellValue(getNameFromNumber($count).'5', $daftar_mapel[$count-5]['kode_nama']);
                    $mapel = new Mapel($daftar_mapel[$count-5]['kode_nama'],$kelas,$subkelas);
                    $sheet->setCellValue(getNameFromNumber($count).'6', $mapel->getKKM());
                    array_push($arr_KKM, $mapel->getKKM());
                    $count++;
                }
                $sheet->mergeCells(getNameFromNumber($count).'5:'.getNameFromNumber($count).'6');
                $sheet->setCellValue(getNameFromNumber($count).'5', 'Total');
                $sheet->mergeCells(getNameFromNumber($count+1).'5:'.getNameFromNumber($count+1).'6');
                $sheet->setCellValue(getNameFromNumber($count+1).'5', 'Rata-Rata');
                $sheet->mergeCells(getNameFromNumber($count+2).'5:'.getNameFromNumber($count+2).'6');
                $sheet->setCellValue(getNameFromNumber($count+2).'5', 'Peringkat');

                $count=7;$arr_peringkat= array();
                while ($count < $jumlah_siswa+7) {
                    $sheet->setCellValue('A'.$count, ($count-6));
                    $sheet->setCellValue('B'.$count, $daftar_siswa[$count-7]['nis']);
                    $sheet->setCellValue('C'.$count, $daftar_siswa[$count-7]['nama']);
                    $sheet->setCellValue('D'.$count, $daftar_siswa[$count-7]['kelamin']);
                    $siswa = new Siswa($daftar_siswa[$count-7]['nis']);
                    $banyakMapel=sizeof($daftar_mapel);
                    $i=5;$jml_nilai=0;
                    while ($i < sizeof($daftar_mapel)+5) {
                        //if ($daftar_mapel[$i-5]['kode_nama']=="AGAMA") {

                            $_agm=$siswa->getAgama();

                            if ($_agm=='ISLAM'){
                                  $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAIS';
                              }else if ($_agm=='KRISTEN'){
                                  $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAKRIS';
                              }else if ($_agm=='KATOLIK'){
                                  $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAKAT';
                              }else if ($_agm=='HINDU'){
                                  $daftar_mapel[$banyakMapel-1]['kode_nama'] = 'AGAMAHIN';
                              }
                            
                        //}
                        $nilai_akhir = $siswa->getNilaiAkhir($daftar_mapel[$i-5]['kode_nama']);
                        $sheet->setCellValue(getNameFromNumber($i).$count, $nilai_akhir);
                        if ($nilai_akhir < $arr_KKM[$i-5]) {
                            $sheet->getStyle(getNameFromNumber($i).$count)->applyFromArray(array('font' => array('color' => array('rgb' => 'FF0000'))));
                        }
                        $jml_nilai=$jml_nilai+$nilai_akhir;
                        $i++;
                    }
                    $sheet->setCellValue(getNameFromNumber($i).$count, $jml_nilai);                             //TOTAL
                    $mean = (float)number_format(($jml_nilai/sizeof($daftar_mapel)), 2, '.', '');
                    $sheet->setCellValue(getNameFromNumber($i+1).$count, $mean);                                //RATA-RATA
                    array_push($arr_peringkat, $jml_nilai);
                    $count++;
                }

                // Membuat peringkat berdasar nilai total
                $count=7;
                $ordered_nilai = $arr_peringkat;
                rsort($ordered_nilai);
                foreach ($arr_peringkat as $key => $arr_peringkat_o) {
                    foreach ($ordered_nilai as $ordered_key => $ordered_nilai_o) {
                        if ($arr_peringkat_o === $ordered_nilai_o) {
                            $key = $ordered_key;
                            break;
                        }
                    }
                    $sheet->setCellValue(getNameFromNumber($i+2).$count, ((int) $key + 1)); 
                    $count++;
                }

                $sheet->getStyle('A5:'.getNameFromNumber($i+2).'6')->applyFromArray($styleHeaderArray);
                $sheet->getStyle('A5:'.getNameFromNumber($i+2).($count-1))->applyFromArray($styleBorderArray);

            // END - PAGE 1

            // BEGIN - PAGE 2

                $objPHPExcel->setActiveSheetIndex(1);
                $sheet = $objPHPExcel->getActiveSheet();

                $sheet->setCellValue('A1', 'LEDGER NILAI RAPOR UAS SEMESTER GASAL TAHUN AJARAN 2015/2016');
                $sheet->setCellValue('A4', 'Kelas : '.$kelas.$subkelas);
                $sheet->setCellValue('C4', 'Wali Kelas : '.$nama_wali);            

                $count=2;
                while ($count < $jumlah_siswa+2) {
                    $sheet->setCellValue('A'.($count*3+1), ($count-1));
                    $sheet->setCellValue('B'.($count*3+1), $daftar_siswa[$count-2]['nis']);
                    $sheet->setCellValue('C'.($count*3+1), $daftar_siswa[$count-2]['nama']);
                    $sheet->setCellValue('D'.($count*3+1), $daftar_siswa[$count-2]['kelamin']);
                    $siswa = new Siswa($daftar_siswa[$count-2]['nis']);
                    $data_ekskul = $siswa->getNilaiEkskul();
                    for ($ekstra_count=0; $ekstra_count<3; $ekstra_count++) { 
                        if (isset($data_ekskul[$ekstra_count]['nis'])) {
                            $ekstra = new Ekstra($data_ekskul[$ekstra_count]['ekskul_id']);
                            $nilai_x = $data_ekskul[$ekstra_count]['nilai'];
                            $keterangan_x = ucfirst(strtolower($data_ekskul[$ekstra_count]['keterangan']));
                            
                            $sheet->setCellValue('E'.($count*3+1+$ekstra_count), $ekstra->getNama());
                            $sheet->setCellValue('F'.($count*3+1+$ekstra_count), $nilai_x);
                            $sheet->setCellValue('G'.($count*3+1+$ekstra_count), $keterangan_x);

                        }
                    }                        

                    $count++;
                }

                // Pengulangan untuk merge cell
                $count=2;
                while ($count < $jumlah_siswa+2) {
                    $sheet->mergeCells('A'.($count*3+1).':A'.(($count+1)*3));
                    $sheet->mergeCells('B'.($count*3+1).':B'.(($count+1)*3));
                    $sheet->mergeCells('C'.($count*3+1).':C'.(($count+1)*3));
                    $sheet->mergeCells('D'.($count*3+1).':D'.(($count+1)*3));

                    $count++;
                }                

                $sheet->getStyle('A5:G'.(($count-1)*3+3))->applyFromArray($styleBorderArray);

            // END - PAGE 2

            // BEGIN - PAGE 3
                $objPHPExcel->setActiveSheetIndex(2);
                $sheet = $objPHPExcel->getActiveSheet();

                $sheet->setCellValue('A1', 'LEDGER NILAI RAPOR UAS SEMESTER GASAL TAHUN AJARAN 2015/2016');
                $sheet->setCellValue('A4', 'Kelas : '.$kelas.$subkelas);
                $sheet->setCellValue('C4', 'Wali Kelas : '.$nama_wali);

                $count=7;$arr_peringkat= array();
                while ($count < $jumlah_siswa+7) {
                    $sheet->setCellValue('A'.$count, ($count-6));
                    $sheet->setCellValue('B'.$count, $daftar_siswa[$count-7]['nis']);
                    $sheet->setCellValue('C'.$count, $daftar_siswa[$count-7]['nama']);
                    $sheet->setCellValue('D'.$count, $daftar_siswa[$count-7]['kelamin']);
                    $siswa = new Siswa($daftar_siswa[$count-7]['nis']);

                    $data_sikap = $siswa->getSikap();
                    if (sizeof($data_sikap)==0) {
                        $kejujuran = "(A/B/C)";
                        $d_kejujuran = "(Deskripsi)";
                        $kedisiplinan = "(A/B/C)";
                        $d_kedisiplinan = "(Deskripsi)";
                        $tanggungjawab = "(A/B/C)";
                        $d_tanggungjawab = "(Deskripsi)";
                    } else {
                        $kejujuran = $data_sikap[0]["kejujuran"];
                        $d_kejujuran = $data_sikap[0]["deskripsi_kejujuran"];
                        $kedisiplinan = $data_sikap[0]["kedisiplinan"];
                        $d_kedisiplinan = $data_sikap[0]["deskripsi_kedisiplinan"];
                        $tanggungjawab = $data_sikap[0]["tanggungjawab"];
                        $d_tanggungjawab = $data_sikap[0]["deskripsi_tanggungjawab"];
                        if ($data_sikap[0]["kejujuran"]=="") {
                            $kejujuran = "(A/B/C)";
                        }
                        if ($data_sikap[0]["kedisiplinan"]=="") {
                            $kedisiplinan = "(A/B/C)";
                        }
                        if ($data_sikap[0]["tanggungjawab"]=="") {
                            $tanggungjawab = "(A/B/C)";
                        }        
                        if ($data_sikap[0]["deskripsi_kejujuran"]=="") {
                            $d_kejujuran = "(Deskripsi)";
                        }
                        if ($data_sikap[0]["deskripsi_kedisiplinan"]=="") {
                            $d_kedisiplinan = "(Deskripsi)";
                        }
                        if ($data_sikap[0]["deskripsi_tanggungjawab"]=="") {
                            $d_tanggungjawab = "(Deskripsi)";
                        }   
                    }
                    $sheet->setCellValue('E'.$count, $kejujuran);
                    $sheet->setCellValue('F'.$count, $kedisiplinan);
                    $sheet->setCellValue('G'.$count, $tanggungjawab);

                    $data_kehadiran = $siswa->getKehadiran();
                    if (sizeof($data_kehadiran)==0) {
                        $izin = "0";
                        $sakit = "0";
                        $alpha = "0";
                    } else {
                        $izin = $data_kehadiran[0]["izin"];
                        $sakit = $data_kehadiran[0]["sakit"];
                        $alpha = $data_kehadiran[0]["alpha"];
                        if ($data_kehadiran[0]["sakit"]==""||$data_kehadiran[0]["sakit"]=="0") {
                            $sakit = "0";
                        }
                        if ($data_kehadiran[0]["izin"]==""||$data_kehadiran[0]["izin"]=="0") {
                            $izin = "0";
                        }
                        if ($data_kehadiran[0]["alpha"]==""||$data_kehadiran[0]["alpha"]=="0") {
                            $alpha = "0";
                        }                     
                    }     
                    $sheet->setCellValue('H'.$count, $izin);                                     
                    $sheet->setCellValue('I'.$count, $sakit);                                     
                    $sheet->setCellValue('J'.$count, $alpha);                                     

                    $count++;
                }

                $sheet->getStyle('A5:J'.($count-1))->applyFromArray($styleBorderArray);                

            // END - PAGE 3


            $objPHPExcel->setActiveSheetIndex(0);
        }            
    } else{
        echo "Terjadi kesalahan dalam proses";
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
 ?>