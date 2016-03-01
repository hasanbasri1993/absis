<!-- required  09 05 2015-->
<script>
	// if (screen.width <= 800) {

	// 	window.location = "mobile.php";
	// }
	// if ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i))) {

	// 	location.replace("mobile.php");
	// }
</script>
<script type='text/javascript' src='assets/jquery-1.8.0.min.js'></script>
----
<?php
$role = $_SESSION['role'];
$page = $_GET['p'];
$url = "view/main/role/$role/script/$page";

$get_link_array = explode("_", $page);
$update_link = str_replace(" ", "+", $page);
$get_st = $get_link_array[0];

if ($get_st == "pertamax"){

	$get_restriction = $get_link_array[1];
	$get_link_specified_page = explode(" ", $get_link);
	$spec_page = $get_link_specified_page[1];

	$url = "view/main/extension/$get_restriction/script/$spec_page.js";
	if (file_exists($url)){
		
		include_once $url;
	} else {
		echo "";
	}
} else {

	if(isset($_GET['state'])){

		$final = $url . "_" . $_GET['state'] . ".js";
	} else {

		$final = $url . ".js";
	}

	if (file_exists($final)){
		include_once $final;
	} else {
		echo "";
	}
}
?>
<?php
if ((isset($_GET['notif'])) && ($_GET['notif'] == "1" && ($_GET['p'] == "home"))){
	?>
	
	<script type="text/javascript">
	$(document).ready(function(){
	   $("#notif").trigger('click');

	});
	</script>
	------------

	<?php
}
?>
=====
<script>
$(document).ready(function(){

	$("#logout-side").on("click", function(){
	
		$("#logout").trigger('click'); 
	});

	$("#password-side").on("click", function(){
	
		$("#password").trigger('click'); 
	});

	$(".ganti-password-act").on("click", function(){

		var current_pass = $(".current-password").val();
		var pas1 = $(".pass1").val();
		var pas2 = $(".pass2").val();

		if (pas1 == ""){

			alert("password tidak boleh kosong");
		} else {

			if (pas1 == pas2){
				arrayGantiPassword = [current_pass,pas1,pas2];
				$.ajax({

					type: "POST",
					url: "?sajen=ganti_password",
					data: {json: JSON.stringify(arrayGantiPassword)},
					cache: false,
					success: function(html) {

						alert(html);
					} 
				});
			} else {

				alert("password tidak sama");
			};
		}
	});

	$("#lockscreen-side").on("click", function(){
	
		$("#lockscreen").trigger('click'); 
	});

	$(".save-ta").on("click", function(){
		alert('savvee');
		$( ".ta-data" ).submit();
	});

	$('.icheck-ta').on('ifClicked', function (event) {
        var value = this.value;
        var semester = $(this).attr("sem");
        if (value == "tidakboleh") {
        	//alert(semester + value);
        	$("." + semester).attr("style", "background: rgb(246,187,66); margin-bottom: 0px;");
        } else {
        	//alert(semester + value);
        	$("." + semester).attr("style", "background: rgb(59,175,218); margin-bottom: 0px;");
        }
    });

	$(".edit-ta").on("click", function(){

		var get_ta = $(this).attr("ta");
		var get_st = $(this).attr("st");
		var get_nd = $(this).attr("nd");

		if (get_st == "1"){

			$(".aaa").iCheck('check');	
			$(".bbb").iCheck('uncheck');
			$(".sem1").attr("style", "background: rgb(59,175,218); margin-bottom: 0px;");		
		};
		if (get_st == "0"){

			$(".aaa").iCheck('uncheck');	
			$(".bbb").iCheck('check');
			$(".sem1").attr("style", "background: rgb(246,187,66); margin-bottom: 0px;");
		};
		if (get_nd == "1"){

			$(".ccc").iCheck('check');	
			$(".ddd").iCheck('uncheck');
			$(".sem2").attr("style", "background: rgb(59,175,218); margin-bottom: 0px;");		
		};
		if (get_nd == "0"){

			$(".ccc").iCheck('uncheck');	
			$(".ddd").iCheck('check');
			$(".sem2").attr("style", "background: rgb(246,187,66); margin-bottom: 0px;");
		};

		$(".show-ta-title").html(get_ta);
		$("#editTA").trigger('click'); 
	});
});
</script>
<script src='assets/js/bootstrap.min.js'></script>
<script src='assets/plugins/retina/retina.min.js'></script>
<script src='assets/plugins/nicescroll/jquery.nicescroll.js'></script>
<!--end required-->

<script src='assets/plugins/slimscroll/jquery.slimscroll.min.js'></script>
<script src='assets/plugins/backstretch/jquery.backstretch.min.js'></script>

<!-- PLUGINS -->
<script src="assets/plugins/sw-bootstrap/js/highlight.js"></script>
<script src="assets/plugins/sw-bootstrap/js/bootstrap-switch.js"></script>
<!-- required -->
<script src='assets/plugins/icheck/icheck.min.js'></script>
<script src='assets/plugins/chosen/chosen.jquery.min.js'></script>
<script src='assets/plugins/magnific-popup/jquery.magnific-popup.min.js'></script>
<script src='assets/plugins/prettify/prettify.js'></script>
<!--end required-->
<!-- ` required -->
<script src='assets/plugins/timepicker/bootstrap-timepicker.js'></script>

<script src='assets/plugins/newsticker/jquery.newsTicker.min.js'></script>

<script src='assets/plugins/mask/jquery.mask.min.js'></script>

<script src='assets/plugins/markdown/bootstrap-markdown.js'></script>
<script src='assets/plugins/markdown/to-markdown.js'></script>
<script src='assets/plugins/markdown/markdown.js'></script>

<script src='assets/plugins/datatable/js/jquery.dataTables.min.js'></script>
<script src='assets/plugins/datatable/js/bootstrap.datatable.js'></script>

<script src='assets/plugins/validator/bootstrapValidator.min.js'></script>

<script src='assets/plugins/datepicker/bootstrap-datepicker.js'></script>

<script src='assets/plugins/summernote/summernote.min.js'></script>

<script src='assets/plugins/slider/bootstrap-slider.js'></script>

<script src='assets/plugins/skycons/skycons.js'></script>

<script src='assets/plugins/owl-carousel/owl.carousel.min.js'></script>

<script src='assets/plugins/toastr/toastr.js'></script>

<script src='assets/plugins/fullcalendar/lib/jquery-ui.custom.min.js'></script>
<script src='assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js'></script>

<script src='assets/js/full-calendar.js'></script>

<!--[if IE]>
<script type='text/javascript' src='assets/plugins/jquery-knob/excanvas.js'></script>
<![endif]-->
<script src='assets/plugins/jquery-knob/jquery.knob.js'></script>
<script src='assets/plugins/jquery-knob/knob.js'></script>

<script src='assets/plugins/flot-chart/jquery.flot.js'></script>
<script src='assets/plugins/flot-chart/jquery.flot.tooltip.js'></script>
<script src='assets/plugins/flot-chart/jquery.flot.resize.js'></script>
<script src='assets/plugins/flot-chart/jquery.flot.selection.js'></script>
<script src='assets/plugins/flot-chart/jquery.flot.stack.js'></script>
<script src='assets/plugins/flot-chart/jquery.flot.time.js'></script>
<script src='assets/plugins/flot-chart/example.js'></script>

<script src='assets/plugins/morris-chart/raphael.min.js'></script>
<script src='assets/plugins/morris-chart/morris.min.js'></script>	

<script src='assets/plugins/c3-chart/d3.v3.min.js' charset='utf-8'></script>
<script src='assets/plugins/c3-chart/c3.min.js'></script>

<script src='assets/plugins/easypie-chart/easypiechart.min.js'></script>
<script src='assets/plugins/easypie-chart/jquery.easypiechart.min.js'></script>
<script src='assets/plugins/switch/dist/js/bootstrap-switch.js'></script>
<!--end not required-->
<!-- MAIN APPS JS -->
<script src='assets/js/apps.js'></script>
<script src='assets/js/online.js'></script>
<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-62650664-1', 'auto');ga('send', 'pageview');</script>