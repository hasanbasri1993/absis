<script type="text/javascript">

$( document ).ready(function() {

    $('.edit-topik').click(function(){
    	//alert('cuk');
    	var thisTopikNama = $(this).attr("topik-nama");
        var thisTopikId = $(this).attr("topik-id");
    	var thisTopikSingkatan = $(this).attr("topik-singkatan");
    	var thisTopikUTS = $(this).attr("edit-uts");
        
        $('.daftar-isi-edit-topik').html("<div class='text-center'> <img src='assets/img/loading.gif'></div>");
    	//JSON waee, lali --"
		$.post( "index.php?sajen=input_nilai_edit_topik", {topik_id: thisTopikId,topik_nama: thisTopikNama, topik_singkatan: thisTopikSingkatan, edit_uts: thisTopikUTS}, function( data ) {

	  		$('.daftar-isi-edit-topik').html(data);
	  	});		  	
	});

    $('.hapus-topik').click(function(){
        //alert('cuk');
        // var thisTopikNama = $(this).attr("topik-nama");
        var thisTopikId = $(".topik_id").attr("topik-id");
        // var thisTopikSingkatan = $(this).attr("topik-singkatan");
        // var thisTopikUTS = $(this).attr("edit-uts");
        var kelas= "<?php echo $_GET['kelas'][0]; ?>";
        var subkelas= "<?php echo $_GET['kelas'][1]; ?>";
        //var nip= "<?php echo $_SESSION['username']; ?>";
        // $('.daftar-isi-edit-topik').html("<div class='text-center'> <img src='assets/img/loading.gif'></div>");
        // //JSON waee, lali --"

        $('#ModalHapus').modal();
        $('.konfirmasi-hapus-topik').click(function(){
            $.post( "index.php?sajen=input_nilai_hapus_topik_proses", {topik_id: thisTopikId,kelas:kelas,subkelas:subkelas}, function( data ) {

                alert(data);
                location.reload(); 
            });      
        })   
    
    });

});

</script>