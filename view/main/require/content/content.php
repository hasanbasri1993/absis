<!DOCTYPE html>
<html lang="en">
	<?php
	require "controller/view/head.php";
	require "controller/view/body.php";
	require "controller/view/wrapper.php";
	require "view/top-nav/top-nav.php";
	require "view/left-nav/left-nav.php";
	require "controller/view/page-content.php";
	//
	require "controller/content/page.php";
	//
	require "view/footer/footer.php";
	require "controller/view/end-page.php";
	require "controller/view/back-top.php";
	require "controller/view/script.php";
	?>
	<?php
	if (!isset($_GET['lock'])){
		?>
		<script src="assets/plugins/lock/js/store.min.js" type="text/javascript"></script>
		<script src="assets/plugins/lock/js/jquery-idleTimeout.min.js" type="text/javascript"></script>
		<script type="text/javascript" charset="utf-8">

		  $(document).ready(function (){
			$(".logout-all").on("click", function(){
				//$.fn.idleTimeout().logout();
				window.location.href = '?meet=logout';
			});

			$(".lockscreen").on("click", function(){
				$.fn.idleTimeout().logout();
			});	
		    $(document).idleTimeout({
		        redirectUrl: '<?php $user = $_SESSION['username']; $nama = $_SESSION['nama']; $url = $_SERVER["REQUEST_URI"];echo "$url&lock&user=$user&nama=$nama";?>',
		        idleTimeLimit: 300,
		        idleCheckHeartbeat: 3, 
		        customCallback: true,
		        customCallback:    function () {

		          $.fn.idleTimeout().logout();
		          //voluntaryLogoutOne();
		        },
		        activityEvents: 'click keypress scroll wheel mousewheel mousemove',
		        enableDialog: false,
		        sessionKeepAliveTimer: false
		    });
		  });
		</script>		
		<?php
	}
	?>
	<?php
	require "controller/view/end-body.php";
?>
</html>
