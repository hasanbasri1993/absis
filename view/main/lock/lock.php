<?php

if (isset($_GET['nama'])){

	$nama = $_GET['nama'];
	if ($nama == ""){
		$nama = "nama ne dandani sek";
	}
} else {

	include_once "bye.php";
}

if (isset($_GET['user'])){

	$user = $_GET['user'];
} else {

	include_once "bye.php";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Cache-control" content="public">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="">
		<title>ABSIS | Aplikasi Akademik</title>
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/style-responsive.css" rel="stylesheet">
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-62650664-1', 'auto');
		  ga('send', 'pageview');
		</script>
	</head>
	<body class="login tooltips bg-info">
		<div class="login-header dark text-center">
			<img src="assets/img/logo-login.png" class="logo" alt="Logo">
		</div>
		<div class="login-wrapper">
			<form method="POST" action="hello.php">
				<div class="form-group text-center">
					<img src="assets/img/u.png" class="avatar-lock img-circle" alt="user">
				</div>
				<div class="form-group">
					<h3 class="text-center"><strong><?php echo $user?></strong></h3>
					<h4 class="text-center"><?php echo $nama?></h4>
				</div>
				<div class="form-group has-feedback lg left-feedback no-label">
				  <input type="hidden" name="username" id="username" class="form-control no-border input-lg rounded" value="<?php echo $_GET['user'];?>">
				  <span class="fa fa-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback lg left-feedback no-label">
				  <input type="password" name="password" id="password" class="form-control no-border input-lg rounded" placeholder="Enter password" autofocus>
				  <span class="fa fa-unlock-alt form-control-feedback"></span>
				</div>
				<input type="hidden" name="redirect" value="<?php $a = str_replace("&lock","",$_SERVER["REQUEST_URI"]); echo $a;?>">
				<!-- <div class="form-group has-feedback lg left-feedback no-label">
				  <input type="password" class="form-control no-border input-lg rounded" placeholder="Enter password" autofocus>
				  <span class="fa fa-unlock form-control-feedback"></span>
				</div>
				<input type="hidden" name="redirect" value="<?php $a = str_replace("&lock","",$_SERVER["REQUEST_URI"]); echo $a;?>">
				<input type="hidden" name="username" value="<?php echo $_GET['user'];?>"> -->
				<div class="form-group">
					<button type="submit" class="btn btn-warning btn-lg btn-block">LOGIN</button>
				</div>
			</form>
			<p class="text-center"><strong><a href="bye.php">Logout</a></strong></p>
		</div>
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/plugins/retina/retina.min.js"></script>
		<script src="assets/js/apps.js"></script>
	</body>
</html>