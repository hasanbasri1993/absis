<?php

$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo "not match id";
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
   $get_ip_address = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $get_ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $get_ip_address = $_SERVER['REMOTE_ADDR'];
}
$get_session_id = session_id();
$username = $_SESSION['username'];
$state_traffic = "duplicate";
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
$_SESSION['msg_login'] = "
<form action='hello.php'>
	<div class='mfp-bg mfp-zoom-in mfp-ready'></div><div class='mfp-wrap  mfp-auto-cursor mfp-zoom-in mfp-ready' tabindex='-1' style='overflow-y: auto; overflow-x: hidden;'><div class='mfp-container mfp-s-ready mfp-inline-holder'><div class='mfp-content'><div id='pan-download' class='white-popup mfp-with-anim'>
		<h2 class='text-center'>
		akun anda digunakan di komputer lain
		</h2>
		<hr>
		<h4 class='text-center'>masukkan tanggal lahir atau anda harus sign in ulang</h4>
        <h5 class='text-center'>untuk memastikan bahwa ini benar benar akun anda</h5>
		<br />
        <div class='row text-center'>
            <div class='col-sm-4 col-md-4'>
            <input name='state' type='hidden' value='duplicate'>
            <input name='url' type='hidden' value='$url'>
                <div class='form-group'>
                    <select id='tg-1' name='tg1' class='form-control'>
                        <option value='0'>-- Tanggal --</option>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                        <option value='4'>4</option>
                        <option value='5'>5</option>
                        <option value='6'>6</option>
                        <option value='7'>7</option>
                        <option value='8'>8</option>
                        <option value='9'>9</option>
                        <option value='10'>10</option>
                        <option value='11'>11</option>
                        <option value='12'>12</option>
                        <option value='13'>13</option>
                        <option value='14'>14</option>
                        <option value='15'>15</option>
                        <option value='16'>16</option>
                        <option value='17'>17</option>
                        <option value='18'>18</option>
                        <option value='19'>19</option>
                        <option value='20'>20</option>
                        <option value='21'>21</option>
                        <option value='22'>22</option>
                        <option value='23'>23</option>
                        <option value='24'>24</option>
                        <option value='25'>25</option>
                        <option value='26'>26</option>
                        <option value='27'>27</option>
                        <option value='28'>28</option>
                        <option value='29'>29</option>
                        <option value='30'>30</option>
                        <option value='31'>31</option>
                    </select>
                </div>
            </div>
            <div class='col-sm-4 col-md-4'>
                <div class='form-group'>
                    <select name='tg2' class='form-control'>
                        <option value='0'>-- Bulan --</option>
                        <option value='1'>Januari</option>
                        <option value='2'>Februari</option>
                        <option value='3'>Maret</option>
                        <option value='4'>April</option>
                        <option value='5'>Mei</option>
                        <option value='6'>Juni</option>
                        <option value='7'>Juli</option>
                        <option value='8'>Agustus</option>
                        <option value='9'>September</option>
                        <option value='10'>Oktober</option>
                        <option value='11'>November</option>
                        <option value='12'>Desember</option>
                    </select>
                </div>
            </div>
            <div class='col-sm-4 col-md-4'>
                <div class='form-group'>
                    <select name='tg3' class='form-control'>
                        <option value='0'>-- Tahun --</option>
                        <option value='2015'>2015</option>
                    </select>
                </div>
            </div>
            <div class='row'>
            <div class='col-md-6'>
            <h3 class='text-center'><a role='button' href='bye.php' class='btn btn-danger btn-lg'>Sign In Ulang</a></h3>
            </div>
            <div class='col-md-6'>
            <h3><button class='btn btn-info btn-lg' type='submit'>Lanjutkan</button></h3>
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
</form>
";
//header("Location: bye.php");
?>