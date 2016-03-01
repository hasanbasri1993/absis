<?php

    /** PHPExcel_IOFactory */
    include 'model/feature/phpexcel/Classes/PHPExcel/IOFactory.php';
    //include 'model/class/master.php';
    ob_end_clean(); //removing single space character before the PHPExcel output.

    $inputFileType = 'Excel2007';
    //$inputFileName = './sampleData/example1.xls';
    $inputFileName = 'model/feature/phpexcel/template/absensi_temp.xlsx';

    /**  Create a new Reader of the type defined in $inputFileType  **/
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    /**  Load $inputFileName to a PHPExcel Object  **/
    $objPHPExcel = $objReader->load($inputFileName);

    $styleArray = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    );
    $style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
    );
    $style2 = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
    );

    $file_name ="";
    if (($kelas!="")AND($subkelas!="")){

        $arr_kelas = array();
        if($subkelas=="all"){
            $sekolah = new Sekolah();
            $jml_kelas = $sekolah->getBanyakRombel($kelas);
            for ($i=0; $i < $jml_kelas; $i++) { 
                array_push($arr_kelas, getNameFromNumber($i));
            }
            $file_name="Absensi Semua Kelas ".$kelas;
        }else{
            $jml_kelas = 1;
            array_push($arr_kelas, $subkelas);
            $file_name ="Absensi Kelas ".$kelas.$subkelas;
        }

        $objWorkSheetBase = $objPHPExcel->getSheet();
        //pagination
        for ($x=0; $x < $jml_kelas; $x++) { 
            if ($x <> 0){
                $objWorkSheet = clone $objWorkSheetBase;
                $objWorkSheet->setTitle($kelas.$arr_kelas[$x]);
                $objPHPExcel->addSheet($objWorkSheet);
            }else{
                $objPHPExcel->getActiveSheet()->setTitle($kelas.$arr_kelas[$x]);
            }
        }

        for ($count=0; $count < $jml_kelas; $count++) { 
            $kelasx = new Kelas($kelas,$arr_kelas[$count]);
            $daftar_siswa= $kelasx->getSiswa();
            $jumlah_siswa= sizeof($daftar_siswa);
            $jumlah_L= $kelasx->getBanyakSiswaL();
            $jumlah_P= $kelasx->getBanyakSiswaP();
            $nip_wali= $kelasx->getWaliKelasNIP();
            $guru = new Guru($nip_wali);
            $nama_wali = $guru->getNama();
            $daftar_siswa= json_decode(json_encode($daftar_siswa),true);
            
            $objPHPExcel->setActiveSheetIndex($count);
            $sheet = $objPHPExcel->getActiveSheet();

            $sheet->setCellValue('A8', 'Kelas : '.$kelas.$arr_kelas[$count]);
            $sheet->setCellValue('L8', 'Wali Kelas : '.$nama_wali);
            $x=0;$y=0;
            for ($i=0; $i < $jumlah_siswa; $i++) { 
              $x=11+$i;$y=$i+1;
              $sheet->setCellValue('A'.$x, $y); 
              //$sheet->setCellValue('B'.$x, $daftar_siswa[$i]['nis']);
			  $sheet->setCellValueExplicit('B'.$x, $daftar_siswa[$i]['nis'], PHPExcel_Cell_DataType::TYPE_STRING);
              //$sheet->setCellValue('C'.$x, $daftar_siswa[$i]['nisn']);  
			  $sheet->setCellValueExplicit('C'.$x, $daftar_siswa[$i]['nisn'], PHPExcel_Cell_DataType::TYPE_STRING);
              $sheet->setCellValue('D'.$x, ucwords(strtolower($daftar_siswa[$i]['nama'])));   
              $sheet->setCellValue('F'.$x, $daftar_siswa[$i]['kelamin']);   
            }

            $array_ket = array('Sakit','Izin','Alpa','Hadir');
            $y=11+$jumlah_siswa;
            $x=$y+3;
            $sheet->mergeCells('A'.$y.':C'.$x);

            $sheet->setCellValue('A'.$y, 'Keterangan');
            for ($i=0; $i < 4; $i++) { 
              $c=$y+$i;
              $sheet->mergeCells('D'.$c.':E'.$c);
              $sheet->setCellValue('D'.$c, $array_ket[$i]);   
            }
            $sheet->getStyle('A'.$y.':D'.$x)->getFont()->setBold(true);

            $sheet->getStyle('A9:AK'.$x)->applyFromArray($styleArray);
            $sheet->getStyle('A'.$y.':A'.$y)->applyFromArray($style);


            $x=$x+3;$y=$x+2;$c=$x+2;
            $sheet->getStyle('B'.$x.':D'.$c)->applyFromArray($styleArray);
            $sheet->getStyle('B'.$x.':B'.$y)->applyFromArray($style);
            $sheet->mergeCells('B'.$x.':C'.$x);
            $sheet->mergeCells('L'.$x.':AK'.$x);
            $sheet->setCellValue('L'.$x, 'Semarang,___________________');
            $sheet->getStyle('L'.$x.':L'.$x)->applyFromArray($style2);
            $sheet->setCellValue('B'.$x, 'Jumlah Siswa');
            $sheet->setCellValue('D'.$x, $jumlah_siswa);$x=$x+1;
            $sheet->mergeCells('B'.$x.':C'.$x);
            $sheet->mergeCells('L'.$x.':AK'.$x);
            $sheet->setCellValue('B'.$x, 'Laki-Laki');
            $sheet->setCellValue('D'.$x, $jumlah_L);$x=$x+1;
            $sheet->mergeCells('B'.$x.':C'.$x);
            $sheet->mergeCells('L'.$x.':AK'.$x);
            $sheet->setCellValue('B'.$x, 'Perempuan');
            $sheet->setCellValue('D'.$x, $jumlah_P);$x=$x+1;
            $sheet->mergeCells('L'.$x.':AK'.$x);$x=$x+1;
            $sheet->mergeCells('L'.$x.':AK'.$x);
            $sheet->setCellValue('L'.$x, $nama_wali);
            $sheet->getStyle('L'.$x.':L'.$x)->applyFromArray($style2);$x=$x+1;
            $sheet->mergeCells('L'.$x.':AK'.$x);
            $sheet->setCellValueExplicit('L'.$x, $nip_wali, PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->getStyle('L'.$x.':L'.$x)->applyFromArray($style2);

            $gdImage = imagecreatefromjpeg('assets/img/logo-pemkot.jpg');
            // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
            $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
            $objDrawing->setName('Sample image');
            $objDrawing->setDescription('Sample image');
            $objDrawing->setImageResource($gdImage);
            $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
            $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
            $objDrawing->setHeight(150);
            $objDrawing->setCoordinates('B2');
            $objDrawing->setWorksheet($sheet);

            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('Logo');
            $logo = 'assets/img/logo-smp1.png';
            $objDrawing->setPath($logo);
            $objDrawing->setCoordinates('AD2');
            $objDrawing->setHeight(150); 
            $objDrawing->setWorksheet($sheet);
        }
        
        $objPHPExcel->setActiveSheetIndex(0);

    }else{
        echo "error";
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

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
?>