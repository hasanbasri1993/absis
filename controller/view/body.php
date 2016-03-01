<body class="tooltips" style="background-color: #F7F9FA">
	<?php
		if ($_SESSION['msg_login'] == "") {

		} else {
			echo $_SESSION['msg_login'];
			exit;
		}
		if ($_SESSION['msg_app'] == "") {
			
		} else {
			echo $_SESSION['msg_app'];
			exit;
		}			
	?>