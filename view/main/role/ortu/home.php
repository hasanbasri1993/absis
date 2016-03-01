<?php
$title_1 = "Orang Tua";
$state_navbar = "home"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";
include_once "model/class/master.php";

//$namadbTA="smpn1smg_".$_SESSION['TA'];
$namadbTA="smpn1smg_2015";

$kelasx= new Kelas("7","e");
$nip_wali= $kelasx->getWaliKelasNIP();
echo $nip_wali;
$gurux = new Guru($nip_wali);
echo 'test';
print_r( $gurux->getNama());

?>

Default Homepage
