<?php
$dataSearch=json_decode($_POST['json']);
$query = htmlspecialchars($dataSearch[0], ENT_QUOTES);
$page=0;
$item=80;
$limit_page = 7;
$sql_limited = "SELECT * FROM data_guru WHERE nama LIKE '%$query%' OR nip LIKE '%$query%' ORDER BY nip ASC LIMIT $page,$item";
$showdata_limited = $dbo -> prepare("$sql_limited");
$showdata_limited -> execute();

$sql_all = "SELECT * FROM data_guru WHERE nama LIKE '%$query%' OR nip LIKE '%$query%'";
$showdata_all = $dbo -> prepare("$sql_all");
$showdata_all -> execute();


$no_all = $showdata_all ->rowCount();
$no_limited = $showdata_limited -> rowCount();

$total_pages = ceil($no_all/$item);

if ($no_limited == 0){
	echo "
	<ul class='pagination square'>
		<li class='active'><a href='#'>1</a></li>
	</ul>
	";
}
if ($no_limited != 0 ){

	echo "<ul class='pagination square'>";
	$start_page = 0;
	if ($total_pages > $limit_page ){

		while ($start_page != $limit_page){

			$start_page_view = $start_page + 1;

			if ($start_page_view == 1) {

				echo "
					<li class='active'><a class='halaman' href='#' halaman='$start_page_view'>$start_page_view</a></li>
				";
			} else {

				echo "
					<li class=''><a class='halaman' href='#' halaman='$start_page_view'>$start_page_view</a></li>
				";
			}
			
			$start_page++;
		}
	} else {

		while ($start_page != $total_pages){

			$start_page_view = $start_page + 1;
			if ($start_page_view == 1) {

				echo "
					<li class='active'><a class='halaman' href='#' halaman='$start_page_view'>$start_page_view</a></li>
				";
			} else {

				echo "
					<li class=''><a class='halaman' href='#' halaman='$start_page_view'>$start_page_view</a></li>
				";
			}
			$start_page++;
		}
	}
	echo "<li class=''><a class='halaman' href='#' halaman='terakhir'>terakhir</a></li>";
	echo "</ul>";
}
?>
<script>
$(document).ready(function(){

	var search_table_page = function(query, page) {

		var arrayGetDataSearch = [query, page];
		$.ajax({

			type: "POST",
			url: "?sajen=akademik_penugasan_guru_search_page",
			data: {json: JSON.stringify(arrayGetDataSearch)},
			cache: false,
			success: function(html) {
				//console.log(html);
				$("#data-guru-tabel").html(html);
			} 
		});
	};

	$(".halaman").on("click", function(){

		$(this).parent().addClass('active').siblings().removeClass('active');
		var query = $("#search-guru").val();
		var page = $(this).attr("halaman");
		if (page == "terakhir"){

			$.ajax({

				type: "POST",
				url: "?sajen=akademik_penugasan_guru_search_page_terakhir",
				cache: false,
				success: function(html) {

					$("#data-guru-tabel").html(html);
				} 
			});
		} else {

			$("#data-guru-tabel").html("<tr><td colspan='8' class='text-center'><h4>Sedang Mengambil Data...</h4></td></tr>");
			search_table_page(query, page);
		};
	});
});
</script>