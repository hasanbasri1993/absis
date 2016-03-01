<?php
	if (!isset ($_SESSION)){
	
	 session_start();
		
		if(!isset($_SESSION['username'])){
	
			session_regenerate_id();
			include "view/main/login/login.php";
			exit;
		} else {
	
			if (isset($_GET['lock'])){
				
				$_SESSION['lock'] = "lock";
				include_once "view/main/lock/lock.php";
	
			} else {
				
				if ($_SESSION['lock'] == "unlock"){
	
					require_once "controller/auth/log_activity.php";
					include "controller/session/newsession.php";
	
					if ($_SERVER["REQUEST_URI"] == "/index.php") {
	
						header("Location: ?p=home");
					} elseif ($_SERVER["REQUEST_URI"] == "/") {
						
						header("Location: ?p=home");
					}
	
					if (isset($_GET['sajen'])) {
	
						include "controller/content/sajen.php";
					}
	
					if (isset($_GET['p'])) {
	
						include "view/main/require/content/content.php";
					}
				} else {
					
					echo "locked from SESSION";
					include_once "view/main/lock/lock.php";
					unset($_SESSION['username']);
	
				}
			}
		}
	}
?>