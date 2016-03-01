<?php
if (isset($_GET['state'])) {
	$get_state = $_GET['state'];
	if (($get_state == "download")){
			if ($get_state == "download") {

				include_once "view/main/role/admin/pilihan_download_download.php";
			}
	} else {

		include_once "view/main/require/redirect/redirect_404.php";
	}
	
} else {
	include_once "view/main/role/admin/pilihan_download_landing.php";
}
?>