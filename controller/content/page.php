<?php
$array_page_addition_final = [];
$array_page_tmp_new_final = [];
$role = $_SESSION['role'];
$role_2 = "public";
$sql = "SELECT * FROM app_feature WHERE role=:role OR role=:role_2";
$get_role_page = $dbo -> prepare($sql);
$get_role_page -> bindParam(":role",$role,PDO::PARAM_STR);
$get_role_page -> bindParam(":role_2",$role_2,PDO::PARAM_STR);
//get data from role public, and set
if ($get_role_page -> execute()){

	$row_get_role_page = $get_role_page -> fetchAll();
	$row_get_role_page_count = $get_role_page -> rowCount();
	$start = 0;
	$array_page_fix = [];
	while ($start <> $row_get_role_page_count){
		
		$page = $row_get_role_page[$start][3];
		$array_page_tmp = explode(',', $page);
		$array_listing = array_merge($array_page_fix, $array_page_tmp);
		$array_page_fix = $array_page_fix + $array_listing;
		$start++;
	}
}
/*
page  ekstra role
*/
require_once "model/class/master.php";
$guru = new Guru($_SESSION['username']);
$get_ekstra = $guru -> getPenugasanEkstra();
if ($get_ekstra == null){

	$_SESSION['array_page_fix'] = $array_page_fix;
} else {
	
	$plus_role = "ekstra,input_nilai_ekstra";
	$array_new_plus_role = explode(',', $plus_role);
	$new_role = $array_new_plus_role[0];
	$new_feature = $array_new_plus_role[1];

	$select_new_role = $dbo -> prepare("SELECT page FROM app_feature WHERE role = :role AND feature = :feature");
	$select_new_role -> bindParam(":role", $new_role);
	$select_new_role -> bindParam(":feature", $new_feature);
	$select_new_role -> execute();
	$array_new_select = $select_new_role -> fetchAll();
	$array_new_role = explode(',', $array_new_select[0][0]);

	/*
	modify the link name
	*/

	$array_page_ekstra = [];
	foreach ($array_new_role as $lala){

		$x = "pertamax_" . $new_role . "_" . $new_feature . "+" . $lala;
		array_push($array_page_ekstra, $x);
	}

	$a = $array_page_fix;
	$b = $array_page_ekstra;
	$c = array_merge($a, $b);
	$_SESSION['array_page_fix'] = $c;
}


if (!empty($_GET['p'])){

	$get_link = $_GET['p'];
	$update_link = str_replace(" ", "+", $get_link);
	$stat_page = in_array($update_link, $_SESSION['array_page_fix']);
	$get_link_array = explode("_", $get_link);

	if ($get_link_array[0] == "pertamax"){

		$get_restriction = $get_link_array[1];
		$get_link_specified_page = explode(" ", $get_link);
		$spec_page = $get_link_specified_page[1];

		if($stat_page==1){

			$page = (isset($_GET['p']) && in_array($_GET['p'], $array_page_fix))?basename($_GET['p']):'home';
			include_once "view/main/require/index/index_begin.php";
			include_once "view/main/extension/$get_restriction/$spec_page.php";
			include_once "view/main/require/index/index_end.php";
		} else {

			include "view/main/require/redirect/redirect_404.php";
		}
	} else {

		if($stat_page==1){

			$page = (isset($_GET['p']) && in_array($_GET['p'], $array_page_fix))?basename($_GET['p']):'home';
			include_once "view/main/require/index/index_begin.php";
			include_once "view/main/role/$role/$page.php";
			include_once "view/main/require/index/index_end.php";
		} else {

			include "view/main/require/redirect/redirect_404.php";
		}
	}
} else {

	include "view/main/require/redirect/redirect_home.php";
}
?>