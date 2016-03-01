<script type="text/javascript">
var kelas="<?php echo $kelas; ?>";
var subkelas="<?php echo $subkelas; ?>";
var arrayGetTable= [kelas,subkelas];
$(document).ready(function(){

  var reloadTable = function(){
    $("#content-table").html("<td colspan='Mencoba Mengambil Data...' align='center'>");
        $.ajax({
            type: "POST",
                url: "index.php?sajen=input_nilai_ekstra_table",
                data: {json: JSON.stringify(arrayGetTable)},
                cache: false,
                success: function(html) {

                    $("#content-table").html(html);
                    console.log("Welcome Table Reloaded");
                } 
            });
    };

  var create_toast = function (tipe,judul,pesan){
    var i = -1;
    var toastCount = 0;
    var shortCutFunction = tipe;//$("#toastTypeGroup input:radio:checked").val();
    var msg = pesan;//$('#message').val();
    var title = judul;//$('#title').val() || '';
    var showDuration = "300";
    var hideDuration = "100";
    var timeOut = "500";
    var extendedTimeOut = "200";
    var showEasing = "swing";
    var hideEasing = "linear";
    var showMethod = "fadeIn";
    var hideMethod = "fadeOut";
    var toastIndex = toastCount++;
    toastr.options = {
      closeButton: false, //true false broo
      debug: false,
      positionClass: 'toast-top-right', // Top Right Bottom Right Bottom Left Top Left Top Full Width Bottom Full Width
      onclick: null
    };
    var $toast = toastr[shortCutFunction](msg, title);
  };

    $('.hapus-konfirm').click(function(){
    var nis = $(this).attr("siswa-nis");
    var nama = $(this).attr("siswa-nama");
    var kelas = $(this).attr("siswa-kelas");
    var subkelas = $(this).attr("siswa-subkelas");
    console.log("prepare delete" + nis + kelas + subkelas);
    var arrayGetDataDelete = [nis,kelas,subkelas];
    $.ajax({

        type: "POST",
        url: "index.php?sajen=input_nilai_ekstra_delete",
        data: {json: JSON.stringify(arrayGetDataDelete)},
        cache: false,
        success: function(html) {

            create_toast("info","Sukses","sukses Hapus " + nama);
            reloadTable();          
            }      
      });
  });

  $(".input-s").keyup(function() {

    var searchid = $(this).val();
    var search = searchid;
    var kelas="<?php echo $kelas; ?>";
    var subkelas="<?php echo $subkelas; ?>";
    var arrayGetDataSearch = [search,kelas,subkelas];

    //explode " ", if expploded ! = "" go, else hide
    if(searchid != '') {
      $.ajax({

        type: "POST",
        url: "index.php?sajen=input_nilai_ekstra_search",
        data: {json: JSON.stringify(arrayGetDataSearch)},
        cache: false,
        success: function(html) {

          $("#content-r").html(html).show();
        } 
      });
    } else {
      $("#content-r").html("Masukkan Nama atau NIS Siswa").show();
    }
    return false;    
  });

  $(document).live("click", function(e) { 
    var clicked = $(e.target);
    if (! clicked.hasClass("input-s")){

      jQuery("#content-r").fadeOut();
      $("#content-r").html("");
      $('#input-s').val("");
    }
  });

  $('#input-s').click(function(){
    jQuery("#content-r").fadeIn();
    $("#content-r").html("Masukkan Nama atau NIS Siswa").show();
  });

  reloadTable();

});
</script>