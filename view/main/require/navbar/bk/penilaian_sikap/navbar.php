<?php
include_once "model/class/master.php";
$nip = $_SESSION['username'];
$guru = new Guru($_SESSION['username']);
$title_1 = "Penilaian Sikap";
?>
<div class="the-box no-border" style="padding--right: 0px; padding--left: 0px; background: #FBFBFB; margin-bottom: 0px; padding-bottom: 0px;">
	<h2 class="page-heading text-center" style="margin-top: 0px; margin-bottom: 0px;">
		<?php echo $title_1; ?>
	</h2>
</div>
<div class="the-box toolbar no-border no-margin text-center" style="padding-bottom: 20px; padding-top: 20px; margin-bottom: 30px; margin-top: 0px; border-bottom-width: 0px; background: #FBFBFB">
	<div class="btn-group">
		<a href="?p=home" class="btn btn-default" type="button"><i class="fa fa-chevron-left" style="color: #3498db;"></i>&nbsp; Kembali </a>
	</div>
	&nbsp; &nbsp; &nbsp; &nbsp;
	<div class="btn-group">
		<a class="btn btn-default" href="?p=home" type="button"><i class="fa fa-home" style="color: #3498db;"></i>&nbsp; Home</a>
	</div>
</div>