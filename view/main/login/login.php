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
		<link href="./css/style.css" rel="stylesheet">
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-62650664-1', 'auto');
		  ga('send', 'pageview');
		</script>
		<!-- captcha -->
		<script type='text/javascript'>
			function refreshCaptcha(){
				var img = document.images['captchaimg'];
				img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
			}
		</script>
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="login tooltips bg-info">
		<div class="login-header text-center">
			<img src="assets/img/logo-login.png" class="logo" alt="Logo">
		</div>
		<div class="login-wrapper">
			<div class="alert alert-warning alert-bold-border fade in text-center">	
			  	<p style="font-size:20px;">
			  	<strong>A B S I S</strong>				
			  	</p>
			  	<p style="font-size:15px;">
			  	<strong>Aplikasi Akademik</strong>				
			  	</p>
			</div>
			<form role="form" action="?meet=login" method="post">
				<div class="form-group has-feedback lg left-feedback no-label">
				  <input type="text" name="username" id="username" class="form-control no-border input-lg rounded" placeholder="Enter username" autofocus>
				  <span class="fa fa-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback lg left-feedback no-label">
				  <input type="password" name="password" id="password" class="form-control no-border input-lg rounded" placeholder="Enter password">
				  <span class="fa fa-unlock-alt form-control-feedback"></span>
				</div>
				<!-- captcha -->
				<table width="400" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
				    <?php if(isset($msg)){?>
				    <tr>
				      <td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
				    </tr>
				    <?php } ?>
				    <tr>
				      <td align="right" valign="top"> Validation code:</td>
				      <td><img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br>
					<label for='message'>Masukan Kode Captcha disini:</label>
					<br>
					<input id="captcha_code" name="captcha_code" type="text">
					<br>
					Captcha tidak bisa dibaca? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.</td>
				    </tr>
				    <tr>
				      <td>&nbsp;</td>
				      <td><input name="Submit" type="submit" onclick="return validate();" value="Login" class="button1">
					  <input type="hidden" name="redirect" value="<?php $a = $_SERVER["REQUEST_URI"]; echo $a;?>">
				      </td>
				    </tr>
			  	</table>
			</form>
		</div>
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/plugins/retina/retina.min.js"></script>
	</body>
</html>
