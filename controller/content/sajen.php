<?php
$role = $_SESSION['role'];
$role_2 = "public";
$sql = "SELECT * FROM app_feature WHERE role=:role OR role=:role_2";
$get_role_sajen = $dbo -> prepare($sql);
$get_role_sajen -> bindParam(":role",$role,PDO::PARAM_STR);
$get_role_sajen -> bindParam(":role_2",$role_2,PDO::PARAM_STR);
if ($get_role_sajen -> execute()){

	$row_get_role_sajen = $get_role_sajen -> fetchAll();
	$row_get_role_sajen_count = $get_role_sajen -> rowCount();
	$start = 0;
	$array_sajen_fix = [];
	while ($start <> $row_get_role_sajen_count){
		
		$sajen = $row_get_role_sajen[$start][4];
		$array_sajen_tmp = explode(',', $sajen);
		$array_listing = array_merge($array_sajen_fix, $array_sajen_tmp);
		$array_sajen_fix = $array_sajen_fix + $array_listing;
		$start++;
	}
}
/*
sajen ekstra role
*/
require_once "model/class/master.php";
$guru = new Guru($_SESSION['username']);
$get_ekstra = $guru -> getPenugasanEkstra();

$plus_role = "ekstra,input_nilai_ekstra";
$array_new_plus_role = explode(',', $plus_role);
$new_role = $array_new_plus_role[0];
$new_feature = $array_new_plus_role[1];

$select_new_role = $dbo -> prepare("SELECT sajen FROM app_feature WHERE role = :role AND feature = :feature");
$select_new_role -> bindParam(":role", $new_role);
$select_new_role -> bindParam(":feature", $new_feature);
$select_new_role -> execute();
$array_new_select = $select_new_role -> fetchAll();
$array_new_role = explode(',', $array_new_select[0][0]);


/*
modify link name
*/
$array_sajen_ekstra = [];
foreach ($array_new_role as $lala){

	$x = "pertamax_" . $new_role . "_" . $new_feature . "+" . $lala;
	array_push($array_sajen_ekstra, $x);
}

$a = $array_sajen_fix;
$b = $array_sajen_ekstra;
$c = array_merge($a, $b);
$_SESSION['array_sajen_fix'] = $c;

//print_r($_SESSION['array_sajen_fix']);

if (!empty($_GET['sajen'])){

	$get_link = $_GET['sajen'];
	$update_link = str_replace(" ", "+", $get_link);
	$stat_sajen = in_array($update_link, $_SESSION['array_sajen_fix']);
	$get_link_array = explode("_", $get_link);
	
	if ($get_link_array[0] == "pertamax"){

		$get_restriction = $get_link_array[1];
		$get_link_specified_sajen = explode(" ", $get_link);
		$spec_sajen = $get_link_specified_sajen[1];

		if($stat_sajen==1){

			//echo "get sajen from role -$get_restriction- and get file -$spec_sajen-";
			$sajen = (isset($_GET['sajen']) && in_array($_GET['sajen'], $_SESSION['array_sajen_fix']))?basename($_GET['sajen']):'default';
			include_once "view/main/extension/$get_restriction/sajen/$spec_sajen.php";
			$included_files = get_included_files();
			//print_r($included_files);
		} else {

			echo "not found 1";
		}
	} else {
		
		if($stat_sajen==1){

			$sajen = (isset($_GET['sajen']) && in_array($_GET['sajen'], $_SESSION['array_sajen_fix']))?basename($_GET['sajen']):'default';
			include_once "view/main/role/$role/sajen/$sajen.php";
		} else {

			echo "not found 2";
		}
	}
} else {
	
	echo "not found";
}


?>