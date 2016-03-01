<?php
$_SESSION['msg_login'] = "";
$username = $_SESSION['username'];
$_SESSION['session_session_id'] = session_id();
$get_session_id = session_id();
$get_session_server = $dbo->prepare("SELECT username, session_id FROM login WHERE username=:username");
$get_session_server -> bindParam(":username",$username,PDO::PARAM_STR);
if ($get_session_server -> execute()){
	$row = $get_session_server->fetchAll();
	$server_session = $row[0]['session_id'];
	if ($server_session != $get_session_id) {

        include_once "controller/session/session_duplicate.php";			
	} else {
	}
} else {
}

$get_app_permission = $dbo->prepare("SELECT * FROM app_permission ORDER BY app_permission_id DESC LIMIT 1");
$get_app_permission -> bindParam(":username",$username,PDO::PARAM_STR);

if ($get_app_permission -> execute()){
    $row = $get_app_permission->fetchAll();
    $app_permission_granted_role = $row[0]['granted_role'];
    $app_permission_state = $row[0]['state'];
    $app_permission_note = $row[0]['note'];
    $app_permission_time = $row[0]['time'];
    $app_permission_active = $row[0]['active'];
    $_SESSION['msg_app'] = "";
    if ($app_permission_active == "1"){
        include_once "controller/session/app_permission.php";
    } else {
    }
  
}
?>
