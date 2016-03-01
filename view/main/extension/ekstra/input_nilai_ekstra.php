<div class="container-fluid" style="padding-left: 10px; padding-right: 10px;"><div class="the-box no-border" style="background: none repeat scroll 0% 0% rgb(251, 251, 251); margin-bottom: 0px; padding-bottom: 0px; padding-right: 0px; padding-left: 0px; margin-left: -10px; margin-right: -10px;">
	<h2 class="page-heading text-center" style="margin-top: 0px; margin-bottom: 0px;">
		<?php
		require_once "model/class/master.php";
		$guru = new Guru($_SESSION['username']);
		$get_ekstra = $guru -> getPenugasanEkstra();
		$title_1 = $get_ekstra[0][1];
		if ((isset($get_ekstra[1][0]) AND ($_GET['ekstra'] == "sunnah"))){

			$title_1 = $get_ekstra[0][1];
		} elseif ((isset($get_ekstra[1][0]) AND ($_GET['ekstra'] == "wajib"))){

			$title_1 = $get_ekstra[1][1];
		}
		echo $title_1;
		?>
	</h2>
</div>
<div class="the-box toolbar no-border no-margin text-center" style="padding-bottom: 20px; padding-top: 20px; margin: 0px -10px 30px; border-bottom-width: 0px; background: none repeat scroll 0% 0% rgb(251, 251, 251); padding-left: 0px;">
	<div class="btn-group">
		<a class="btn btn-default" href="?p=home" type="button"><i class="fa fa-home" style="color: #3498db;"></i>&nbsp; Home</a>
	</div>
</div>
<?php
if (!isset($get_ekstra[1][0])){

	if ($get_ekstra[0][2] == "sunnah"){

		include_once "view/main/extension/ekstra/input_nilai_ekstra_sunnah.php";
	} elseif ($get_ekstra[0][2] == "wajib"){

		include_once "view/main/extension/ekstra/input_nilai_ekstra_wajib.php";
	} else {

		echo "not defined sunnah / wajib";
	}
} else {

	if ((isset($_GET['ekstra'])) AND ($_GET['ekstra'] == "wajib")){

		include_once "view/main/extension/ekstra/input_nilai_ekstra_wajib.php";
	} elseif ((isset($_GET['ekstra'])) AND ($_GET['ekstra'] == "sunnah")){

		include_once "view/main/extension/ekstra/input_nilai_ekstra_sunnah.php";
	}
}

?>
