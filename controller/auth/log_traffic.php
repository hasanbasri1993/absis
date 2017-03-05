<?php
if (isset($_SESSION['username']) && isset($_SESSION['lock'])){

	if ($_SESSION['lock'] == "unlock"){

		header("Location: index.php");
		exit;
	}		
}

if (!isset($_POST['username'])){

	$_POST['username'] = "";	
}

if (!isset($_POST['password'])){

	$_POST['password'] = "";	
}

if(isset($_POST['Submit'])){//cek sesuaian captcha
	// code for check server side validation
	if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
		$n1 = "Captcha salah!";
		$n2 = "Harap Sign In Ulang";
		$msg="<div class='text-center'>
				<a href='index.php' class='btn btn-info'>Sign Ulang</a>
			  </div>";// Captcha verification is incorrect.		
	}else{// Captcha verification is Correct. Final Code Execute here!				


$username = $_POST['username'];
$password = $_POST['password'];
$count = $dbo -> prepare("SELECT * FROM login WHERE username=:username");
$count -> bindParam(":username",$username,PDO::PARAM_STR);
if ($count -> execute()){

	$no = $count -> rowCount();
	if($no <> 1 ) {
		
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

		    $get_ip_address = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

		    $get_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {

		    $get_ip_address = $_SERVER['REMOTE_ADDR'];
		}		
		$get_session_id = session_id();
		$username = $_POST['username'];
		$state_traffic = "not_found";

		$save_traffic = $dbo->prepare("INSERT INTO user_traffic (username, session_id, ip_address, state) VALUES (:username, :session_id, :ip_address, :state)");
		$save_traffic -> bindParam(":session_id",$get_session_id,PDO::PARAM_STR);
		$save_traffic -> bindParam(":username",$username,PDO::PARAM_STR);
		$save_traffic -> bindParam(":ip_address",$get_ip_address,PDO::PARAM_STR);
		$save_traffic -> bindParam(":state",$state_traffic,PDO::PARAM_STR);
		$save_traffic -> execute();
		$n1 = "Username atau Password tidak ditemukan";
		$n2 = "Harap Sign In Ulang";
			$msg=" 
			<div class='text-center'>
				<a href='index.php' class='btn btn-info'>Sign Ulang</a>
			</div>
			";
		session_regenerate_id();
		session_unset();
		session_destroy();
		session_write_close();
	} else {
		
		$row = $count -> fetch(PDO::FETCH_OBJ);
		if($row->active <> 1) {

			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

			    $get_ip_address = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

			    $get_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {

			    $get_ip_address = $_SERVER['REMOTE_ADDR'];
			}
			$get_session_id = session_id();
			$username = $_POST['username'];
			$state_traffic = "disabled";

			$save_traffic = $dbo->prepare("INSERT INTO user_traffic (username, session_id, ip_address, state) VALUES (:username, :session_id, :ip_address, :state)");
			$save_traffic -> bindParam(":session_id",$get_session_id,PDO::PARAM_STR);
			$save_traffic -> bindParam(":username",$username,PDO::PARAM_STR);
			$save_traffic -> bindParam(":ip_address",$get_ip_address,PDO::PARAM_STR);
			$save_traffic -> bindParam(":state",$state_traffic,PDO::PARAM_STR);						
			$save_traffic -> execute();
			$n1 = "Akun Anda Nonaktif";
			$n2 = "Harap hubungi Admin (085740235297)";
			$msg=" 
			<div class='text-center'>
				<a href='index.php' class='btn btn-info'>Sign Ulang</a>
			</div>
			";
		} else {

			if($row->password==md5($password)){

				include 'model/feature/mobile/Mobile_Detect.php';
				$detect = new Mobile_Detect();
				$a = 1;

				/*if (($detect->isMobile()) OR ($detect->isTablet())) {
					
					$n1 = "Gunakan Desktop";
					$n2 = "Kembali Dalam <span id='countdown' class='timer'></span> Detik";
					$msg = "
							<script>
								var seconds = 20;
								function secondPassed() {
								    var minutes = Math.round((seconds - 30)/60);
								    var remainingSeconds = seconds % 60;
								    if (remainingSeconds < 10) {
								        remainingSeconds = '0' + remainingSeconds;  
								    }
								    document.getElementById('countdown').innerHTML = minutes + ':' + remainingSeconds;
								    if (seconds == 0) {
								        clearInterval(countdownTimer);
								        window.location='index.php';
								    } else {
								        seconds--;
								    }
								}
								 
								var countdownTimer = setInterval('secondPassed()', 1000);
							</script>";
				} else {*/						

					$_SESSION['lock'] = "unlock";
					$_SESSION['username']=$row->username;
					$count_2=$dbo->prepare("SELECT * FROM login WHERE username=:username");
					$count_2->bindParam(":username",$username,PDO::PARAM_STR);
					if($count_2->execute()){
						
						$row_2 = $count_2->fetch(PDO::FETCH_OBJ);
						$_SESSION['username']=$row_2->username;
						$_SESSION['nama'] = $row_2->nama;
						$_SESSION['role'] = $row_2->role;						
					}

					$get_ta = $dbo->prepare("SELECT * FROM data_ta ORDER BY tahun_ajaran DESC LIMIT 1");
					if ($get_ta->execute()){

					    $row_get_ta = $get_ta -> fetch();
					    $_SESSION['TA'] = $row_get_ta['tahun_ajaran'];
					    $_SESSION['semester'] = $row_get_ta['semester'];
					    $_SESSION['database'] = $row_get_ta['database_nama'];
					    if ($_SESSION['semester'] == "1"){

					        $_SESSION['edit_status'] = $row_get_ta['edit_status_1'];
					    } elseif ($_SESSION['semester'] == "2") {
					        
					        $_SESSION['edit_status'] = $row_get_ta['edit_status_2'];
					    }
					}
					$get_session_id = session_id();
					$save_session = $dbo->prepare("UPDATE login SET session_id=:session_id WHERE username=:username");
					$save_session -> bindParam(":session_id",$get_session_id,PDO::PARAM_STR);
					$save_session -> bindParam(":username",$username,PDO::PARAM_STR);
						if ($save_session -> execute()){
							//echo "update session id usccess";
						} else {
							//echo "fail update session id";
						}

					if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
					    $get_ip_address = $_SERVER['HTTP_CLIENT_IP'];
					} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					    $get_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
					} else {
					    $get_ip_address = $_SERVER['REMOTE_ADDR'];
					}
					$get_session_id = session_id();
					$state_traffic = "login";
					$username = $_POST['username'];
					$save_traffic = $dbo->prepare("INSERT INTO user_traffic (username, session_id, ip_address, state) VALUES (:username, :session_id, :ip_address, :state)");
					$save_traffic -> bindParam(":session_id",$get_session_id,PDO::PARAM_STR);
					$save_traffic -> bindParam(":username",$username,PDO::PARAM_STR);
					$save_traffic -> bindParam(":ip_address",$get_ip_address,PDO::PARAM_STR);
					$save_traffic -> bindParam(":state",$state_traffic,PDO::PARAM_STR);						
						if ($save_traffic -> execute()){
							//echo "update session id usccess";
						} else {
							//echo "fail update session id";
						}
					$n1 = "Sign In Berhasil";
					$n2 = "Harap Tunggu";
					$redirect = $_POST['redirect'];
					if (($redirect=="/") || ($redirect=="index.php") || ($redirect=="?p=home") || ($redirect=="index.php?p=home")){

						$redirect = "?p=home&notif=1";
					} else {

						$redirect = $redirect;
					}
					$msg = "
					<script>
						<!--
							window.location='$redirect';
							//alert('$redirect');
						//-->
					</script>
					";
				/*}*/
				
			} else {
				//fail
				if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				    $get_ip_address = $_SERVER['HTTP_CLIENT_IP'];
				} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				    $get_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else {
				    $get_ip_address = $_SERVER['REMOTE_ADDR'];
				}
				$get_session_id = session_id();
				$state_traffic = "wrong_password";
				$username = $_POST['username'];
				$save_traffic = $dbo->prepare("INSERT INTO user_traffic (username, session_id, ip_address, state) VALUES (:username, :session_id, :ip_address, :state)");
				$save_traffic -> bindParam(":session_id",$get_session_id,PDO::PARAM_STR);
				$save_traffic -> bindParam(":username",$username,PDO::PARAM_STR);
				$save_traffic -> bindParam(":ip_address",$get_ip_address,PDO::PARAM_STR);
				$save_traffic -> bindParam(":state",$state_traffic,PDO::PARAM_STR);						
					if ($save_traffic -> execute()){
						
						//echo "update session id usccess";
					} else {									
						
						//echo "fail update session id";
					}
				$n1 = "Username atau Password tidak ditemukan";
				$n2 = "Harap Sign In Ulang";
				$msg=" 
				<div class='text-center'>
					<a href='index.php' class='btn btn-info'>Sign Ulang</a>
				</div>
				";
				session_regenerate_id();
				session_unset();
				session_destroy();
				session_write_close();
			}
		}
	}
} else {
	//fail
	$n1 = "Username atau Password tidak ditemukan";
	$n2 = "Harap Sign In Ulang";
	$msg=" 
		<div class='text-center'>
			<a href='index.php' class='btn btn-info'>Sign Ulang</a>
		</div>
		";
	session_regenerate_id();
	session_unset();
	session_destroy();
	session_write_close();
	}
    }
}
?>
