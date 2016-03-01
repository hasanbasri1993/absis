<?php


	/** PHPExcel_IOFactory */
	include_once 'model/feature/phpexcel/Classes/PHPExcel/IOFactory.php';
	include_once 'model/class/master.php';
	//ob_end_clean(); //removing single space character before the PHPExcel output.
	if (ob_get_contents()) ob_end_clean();


	$inputFileType = 'Excel2007';
	$inputFileName = 'model/feature/phpexcel/template/daftar_nilai_temp.xlsx';


	/**  Create a new Reader of the type defined in $inputFileType  **/
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	/**  Load $inputFileName to a PHPExcel Object  **/
	$objPHPExcel = $objReader->load($inputFileName);
	
	$objWorkSheetBase = $objPHPExcel->getSheet();
	$styleArray = array(
		'font' => array(
			'bold' => true
		)
	);
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
	
	//pagination
	for ($count=0; $count < sizeof($data_siswa); $count++) { 
		if ($count <> 0){
			$objWorkSheet = clone $objWorkSheetBase;
			$objWorkSheet->setTitle($arr_kelas[$count]['kelas'].$arr_kelas[$count]['subkelas']);
			$objPHPExcel->addSheet($objWorkSheet);
		}else{
			$objPHPExcel->getActiveSheet()->setTitle($arr_kelas[$count]['kelas'].$arr_kelas[$count]['subkelas']);
		}
	}

	for ($count=0; $count < sizeof($data_siswa); $count++) { 
		$objPHPExcel->setActiveSheetIndex($count);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setCellValue('A1', 'Daftar Nilai '.$nama_mapel.' Kelas '.$arr_kelas[$count]['kelas'].$arr_kelas[$count]['subkelas']);
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setCellValue('A1', 'Daftar Nilai '.$nama_mapel.' Kelas '.$arr_kelas[$count]['kelas'].$arr_kelas[$count]['subkelas']);
		$sheet->setCellValue('A2', 'Guru : '.$nama_guru);
		//print_r($data_siswa[$count]);echo "<br><br>";

		$jml_topik = sizeof($data_siswa[$count]['data_topik']);
		$jml_siswa = sizeof($data_siswa[$count]['data_siswa']);
		for ($i=1; $i <= $jml_siswa; $i++) { 
			$c=$i+5;
			$sheet->setCellValue('A'.$c, $i);
			$sheet->setCellValue('B'.$c, $data_siswa[$count]['data_siswa'][$i-1]['nis']);
			$sheet->setCellValue('C'.$c, ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['nama']))));
			//Mengisi nilai UTS & UAS semester ini
			if(ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['r_UTS'])))<>"0"){
				$sheet->setCellValue('D'.$c, ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['r_UTS']))));
			}
			if(ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['r_UAS'])))<>"0"){
				$sheet->setCellValue('E'.$c, ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['r_UAS']))));
			}
			$sheet->setCellValue('F'.$c, ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['kkm']))));
			if(ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['UTS'])))<>"0"){
				$sheet->setCellValue('G'.$c, ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['UTS']))));
			}
			if(ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['UAS'])))<>"0"){
				$sheet->setCellValue('H'.$c, ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['UAS']))));
			}
			//Mengisi nilai harian
			$sb_y=8;
			for ($count_topik=0; $count_topik < $jml_topik; $count_topik++) { 
				$hu = getNameFromNumber($sb_y);
				if(ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['topik'][$count_topik]['ut'])))<>"0"){
					$sheet->setCellValue($hu.$c, ucwords(strtolower($data_siswa[$count]['data_siswa'][$i-1]['topik'][$count_topik]['ut'])));//mulai di I6*/
				}
				$sb_y++;
				if(ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['topik'][$count_topik]['ul'])))<>"0"){
					$sheet->setCellValue($hu.$c, ucwords(strtolower($data_siswa[$count]['data_siswa'][$i-1]['topik'][$count_topik]['ul'])));
				}
				$sb_y++;
				if(ucwords((strtolower($data_siswa[$count]['data_siswa'][$i-1]['topik'][$count_topik]['t'])))<>"0"){
					$sheet->setCellValue($hu.$c, ucwords(strtolower($data_siswa[$count]['data_siswa'][$i-1]['topik'][$count_topik]['t'])));
				}				
				$sb_y++;
			}


			//$sheet->mergeCells('A1:'.(getNameFromNumber(7+($jml_topik*3)).'1'));	
			// $count=5;
			// while ($count < $jml_topik+5) {
				 
			// 	$count++;
			// }	  
		}

		//LOOPING UNTUK HEADER
		if ($jml_topik > 5){
			$sheet->mergeCells('I3:'.(getNameFromNumber(7+($jml_topik*3)).'3'));
			$sheet->setCellValue('I3', 'TOPIK');
			$sheet->getStyle('I3')->applyFromArray($styleArray);
			$x=5;
			for ($z=0; $z < $jml_topik; $z++) { 
				$x=$x+3;
				$an=getNameFromNumber($x);
				$sheet->getStyle($an.'4')->applyFromArray($styleArray);
				$sheet->mergeCells($an.'4:'.(getNameFromNumber($x+2)).'4');
				$sheet->setCellValue($an.'5', 'UT');
				$sheet->getStyle($an.'5')->applyFromArray($styleArray);
				$an=getNameFromNumber($x+1); 
				$sheet->setCellValue($an.'5', 'UL');
				$sheet->getStyle($an.'5')->applyFromArray($styleArray);
				$an=getNameFromNumber($x+2);
				$sheet->setCellValue($an.'5', 'T');
				$sheet->getStyle($an.'5')->applyFromArray($styleArray);
			}
			$an=7+($jml_topik*3);
			$sheet->getStyle('A3:'.$an.($jml_siswa+5))->applyFromArray($styleBorderArray);
		}else{
			$sheet->mergeCells('I3:'.(getNameFromNumber(7+(5*3)).'3'));
			$sheet->setCellValue('I3', 'TOPIK');
			$sheet->getStyle('I3')->applyFromArray($styleArray);
			$x=5;
			for ($z=0; $z < 5; $z++) { 
				$x=$x+3;
				$an=getNameFromNumber($x);
				if($z < $jml_topik){
					$sheet->setCellValue($an.'4', $data_siswa[$count]['data_topik'][$z]['topik_nama_singkat']);
				}
				$sheet->getStyle($an.'4')->applyFromArray($styleArray);
				$sheet->mergeCells($an.'4:'.(getNameFromNumber($x+2)).'4');
				$sheet->setCellValue($an.'5', 'UT');
				$sheet->getStyle($an.'5')->applyFromArray($styleArray);
				$an=getNameFromNumber($x+1); 
				$sheet->setCellValue($an.'5', 'UL');
				$sheet->getStyle($an.'5')->applyFromArray($styleArray);
				$an=getNameFromNumber($x+2);
				$sheet->setCellValue($an.'5', 'T');
				$sheet->getStyle($an.'5')->applyFromArray($styleArray);
			}
			$an=7+(5*3);
			$an=getNameFromNumber($an);
			$sheet->getStyle('A3:'.$an.($jml_siswa+5))->applyFromArray($styleBorderArray);
		}

	}


	$objPHPExcel->setActiveSheetIndex(0);

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
	
	if (sizeof($data_siswa)==1){
		$nama_file="Daftar Nilai ".$nama_mapel." Kelas ".$arr_kelas[0]['kelas'].$arr_kelas[0]['subkelas']." - ".$nama_guru;
	}else{
		$nama_file="Daftar Nilai ".$nama_mapel." Semua Kelas - ".$nama_guru;
	}
	
	header('Writer      : Excel2007 (PHPExcel_Writer_Excel2007)');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$nama_file.'.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
 ?>