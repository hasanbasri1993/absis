<?php
if (!isset($_SESSION)) {
    session_start();
    include "controller/config/config.php";

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $get_ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $get_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $get_ip_address = $_SERVER['REMOTE_ADDR'];
    }

    $get_session_id = session_id();
    $username = $_SESSION['username'];
    $state_traffic = "logout";
    $save_traffic = $dbo->prepare("INSERT INTO user_traffic (username, session_id, ip_address, state) VALUES (:username, :session_id, :ip_address, :state)");
    $save_traffic -> bindParam(":session_id", $get_session_id, PDO::PARAM_STR);
    $save_traffic -> bindParam(":username", $username, PDO::PARAM_STR);
    $save_traffic -> bindParam(":ip_address", $get_ip_address, PDO::PARAM_STR);
    $save_traffic -> bindParam(":state", $state_traffic, PDO::PARAM_STR);
    $save_traffic -> execute();

    session_regenerate_id();
    session_unset();
    session_destroy();
    session_write_close();
    $root = "https://".$_SERVER['HTTP_HOST'];
    $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    $uri .= $root;
    header('Location: '.$uri.'/index.php');
    exit;
} else {
    header("Location: /index.php");
}
