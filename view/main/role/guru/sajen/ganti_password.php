<?php
$array_masuk = json_decode($_POST['json']);
$password_past = md5($array_masuk[0]);
$password_now = md5($array_masuk[1]);
$password_now_nd = md5($array_masuk[2]);
if ($password_now != $password_now_nd){
	echo "password baru  tidak sama";
	exit;
}
$count=$dbo->prepare("SELECT * FROM login WHERE username=:username");
$count->bindParam(":username",$_SESSION['username'],PDO::PARAM_STR);

if($count->execute()){

	$row = $count->fetch(PDO::FETCH_OBJ);
	if($row->password==$password_past){

		$change_pass = $dbo->prepare("UPDATE login SET password=:password_now WHERE username=:username AND password=:password_past");
		$change_pass -> bindParam(":username",$_SESSION['username'],PDO::PARAM_STR);
		$change_pass -> bindParam(":password_now",$password_now,PDO::PARAM_STR);
		$change_pass -> bindParam(":password_past",$password_past,PDO::PARAM_STR);
		if ($change_pass -> execute()){
			echo "sukses ganti password";

		} else {

			echo "gagal ganti pasword, kesalahan sistem1";
		}
	} else {

		echo "Password Sekarang Salah";		
	}
} else {

	echo "gagal ganti pasword, kesalahan sistem3";
}

?>