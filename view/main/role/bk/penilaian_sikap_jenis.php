<?php
if ((isset($_GET['p']) && $_GET['p']=="penilaian_sikap_jenis")){

	 if (empty($_GET['kelas'])){

	 	include "view/main/require/redirect/redirect_404.php";

	 } else {

	 	$kelas_tersedia = array();
	 	include_once "model/class/master.php";
	 	$nip = $_SESSION['username'];
	 	$guru = new Guru($nip);
		$data_kelas = $guru -> getHanyaKelas();

		foreach($data_kelas as $show_data_kelas){

			$list_kelas = $show_data_kelas['kelas'];
			$kelas = new Kelas($list_kelas);

			$data_subkelas = $guru -> getSubkelas("$list_kelas");
			foreach($data_subkelas as $show_data_subkelas){

				$list_subkelas = $show_data_subkelas['subkelas'];				
				array_push($kelas_tersedia, "$list_kelas$list_subkelas");
			}

		}
		
		$_SESSION['session_kelas_tersedia'] = $kelas_tersedia;
	 	$kelas_request = $_GET['kelas'];
	 	$kelas_access = in_array($kelas_request, $kelas_tersedia);

	 }

	 if($kelas_access == "1"){

		if (isset($_GET['kelas'])) {

			include_once "view/main/role/bk/penilaian_sikap_jenis_content.php";

		} else {

			include "view/main/require/redirect/redirect_404.php";

		}

	} else {

		include "view/main/require/redirect/redirect_404.php";

	}

} else {

	include "view/main/require/redirect/redirect_404.php";	

}
?>