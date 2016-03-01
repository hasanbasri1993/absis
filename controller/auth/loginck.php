<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="Aplikasi Akademik">
		<meta name="keywords" content="aplikasi,akademik,absis">
		<meta name="author" content="bimadev">
		<title>ABSIS - Aplikasi Akademik</title>
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">		
		<link href="assets/plugins/magnific-popup/magnific-popup.min.css" rel="stylesheet">
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/style-responsive.css" rel="stylesheet">
		<script>
			// (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			// (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			// m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			// })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			
			ga('create', 'UA-62650664-1', 'auto');
			ga('send', 'pageview');
			
		</script> 
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
<?Php
	include "controller/config/config.php";
 session_start();

	if (isset($_GET['state']) && $_GET['state'] == "duplicate"){

		$get_state = $_GET['state'];
		$get_url = $_GET['url'];
		$get_tg1 = $_GET['tg1'];
		$get_tg2 = $_GET['tg2'];
		$get_tg3 = $_GET['tg3'];
		$get_tanggal_lahir = $get_tg1 . " " . $get_tg2 . " " . $get_tg3;
		$get_tanggal_lahir_server = "1 1 2015";

		if ($get_tanggal_lahir == $get_tanggal_lahir_server) {

			$get_session_id = session_id();
			$username = $_SESSION['username'];
			$save_session = $dbo->prepare("UPDATE login SET session_id=:session_id WHERE username=:username");
			$save_session -> bindParam(":session_id",$get_session_id,PDO::PARAM_STR);
			$save_session -> bindParam(":username",$username,PDO::PARAM_STR);
			if ($save_session -> execute()){
				echo "update session id usccess";
				header("Location: $get_url");
			} else {
				echo "fail update session id";
				//header("Location: $get_url");
			}
		} else {
			echo $_SESSION['msg_login'];
		}
	} else {
		require_once "controller/auth/log_traffic.php";
		?>
		<body class="tooltips" style="background-color: #F7F9FA">
			<form action="hello.php">
				<div class="mfp-bg mfp-zoom-in mfp-ready"></div>
				<div class="mfp-wrap  mfp-auto-cursor mfp-zoom-in mfp-ready" tabindex="-1" style="overflow-y: auto; overflow-x: hidden;">
					<div class="mfp-container mfp-s-ready mfp-inline-holder"><div class="mfp-content">
						<div id="pan-download" class="white-popup mfp-with-anim" style="padding-right: 0px;padding-left: 0px;">
							<h2 class="text-center">
								<?php echo $n1;?>
							</h2>
							<h4 class="text-center"><?php echo $n2;?></h4>
							<br>
							<?php echo $msg;?>						
						</div>
					</div>
					<div class="mfp-preloader">
					Loading...
					</div>
					</div>
				</div>
			</form>
		</body>
		<?php
	}
	
?>