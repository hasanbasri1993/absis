<?php
require_once "model/class/master.php";
$guru = new Guru($_SESSION['username']);
$title_1 = $guru->getNamaMapel('ktsp');
$state_navbar = "lihat_nilai"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";
?>