<?php
$text = $app_permission_granted_role;
$list = explode(',', $text);

$stat_page = in_array($_SESSION['role'], $list);
if ($stat_page == 1) {
    $_SESSION['msg_app'] = "";
} else {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $get_ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $get_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $get_ip_address = $_SERVER['REMOTE_ADDR'];
    }
    $get_session_id = session_id();
    $username = $_SESSION['username'];
    $state_traffic = "blocked";
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
    $_SESSION['msg_app'] = "
    <div class='mfp-bg mfp-zoom-in mfp-ready'></div><div class='mfp-wrap  mfp-auto-cursor mfp-zoom-in mfp-ready' tabindex='-1' style='overflow-y: auto; overflow-x: hidden;'><div class='mfp-container mfp-s-ready mfp-inline-holder'><div class='mfp-content'><div id='pan-download' class='white-popup mfp-with-anim'>
        <h2 class='text-center'>
        $app_permission_state
        </h2>
        <hr>
        <h4 class='text-center'>$app_permission_note</h4>
        <h5 class='text-center'>Telah diberlakukan sejak $app_permission_time</h5>
        <br />
        <div class='row text-center'>
            <div class='row'>
            <div class='col-md-6'>
            <h3 class='text-center'><a role='button' href='bye.php' class='btn btn-danger btn-lg'>Keluar</a></h3>
            </div>
            <div class='col-md-6'>
            <h3><button class='btn btn-info btn-lg' OnClick='location.reload();'>Refresh Halaman</button></h3>
            </div>
            </div>
        </div>              
        </div>
        </div>
        <div class='mfp-preloader'>
        Loading...
        </div>
        </div>
    </div>
    ";   
}

?>