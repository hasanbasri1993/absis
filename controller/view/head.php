<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="Aplikasi Akademik">
	<meta name="keywords" content="aplikasi,akademik,absis">
	<meta name="author" content="bimadev">
	<title>ABSIS - Aplikasi Akademik</title>
	<?php
	if (require "controller/view/css/css.php"){

	} else {
		$error_code = "24";
		$error_location = $_SERVER["SCRIPT_FILENAME"];
		$msg = "Can Not Load CSS";
		echo $msg;
		$msg_details = "";
	}
	?>
</head>