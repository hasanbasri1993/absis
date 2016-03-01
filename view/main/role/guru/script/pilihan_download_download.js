<script>
$(document).ready(function(){

	function myFunction(){
		var select_tipe = document.getElementById("select_tipe");
		var select_kelas = document.getElementById("select_kelas");
		var select_subkelas = document.getElementById("select_subkelas");
	    var tipe = select_tipe.options[select_tipe.selectedIndex].value;
	    var kelas = select_kelas.options[select_kelas.selectedIndex].value;
	    var subkelas = select_subkelas.options[select_subkelas.selectedIndex].value;
	    if ((kelas!='Kelas')&&(subkelas!='Sub Kelas')&&(tipe!='Pilih')){
	    	if((tipe=='absensi')||(tipe=='buku_induk')){
	    		$('#tbl_1').removeAttr('disabled');//pdf
	    	}
	    	if(tipe=='absensi'){
	    		$('#tbl_2').removeAttr('disabled');//excel
	    	}
	    	document.getElementById('preview').src="?sajen=pilihan_download_pdf_proses&state=pdf&kelas=" + kelas+"&subkelas="+subkelas+"&tipe="+tipe+"&download=0"; 
			document.getElementById('tbl_1').href="?sajen=pilihan_download_pdf_proses&state=pdf&kelas=" + kelas+"&subkelas="+subkelas+"&tipe="+tipe+"&download=1"; 
			document.getElementById('tbl_2').href="?sajen=pilihan_download_excel_proses&state=pdf&kelas=" + kelas+"&subkelas="+subkelas+"&tipe="+tipe; 
	    }
	}
	
	$(".select-tipe").change(function(){
    	myFunction();
	});

	$(".select-kelas").change(function(){
    	myFunction();
	});

	$(".select-subkelas").change(function(){
    	myFunction();
	});

});
</script>