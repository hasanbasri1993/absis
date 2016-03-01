<?php
    $dataSearch=json_decode($_POST['json']);

    $get_search = $dataSearch[0];
    $q = strtoupper($get_search);

    require_once "model/class/master.php";
    $guru = new Guru($_SESSION['username']);
    $get_ekstra = $guru -> getPenugasanEkstra();
    $showdata = $dbo->prepare("SELECT * FROM data_siswa WHERE nama LIKE '%$q%' OR nis LIKE '%$q%' LIMIT 5");
    $showdata->execute();   
    $row = $showdata->fetchAll();
    $no = $showdata ->rowCount();
    $x=0;
    while ($x<>$no) {
        $get_1 = $row[$x]['nama'];
        $get_2 = $row[$x]['nis'];
        $siswa = new Siswa($get_2);
        $kelas = $siswa -> getKelas();
        $subkelas = $siswa -> getSubKelas();
        $b_get_1 = "<strong>" . $q . "</strong>";
        $b_get_2 = "<strong>" . $q . "</strong>";
        $final_1 = str_ireplace($q, $b_get_1, $get_1);
        $final_2 = str_ireplace($q, $b_get_2, $get_2);
        $final_1_ascii = htmlentities($final_1, ENT_QUOTES, 'UTF-8');
        $x++;
        echo "
        <div class='content-result-show content-bla' nama='" . $final_1_ascii . "'nis='$get_2' align='left'>
            <span class='content-result-show-parent' >
                $final_1 - <b> Kelas $kelas$subkelas</b>
            </span>
            <br/>
            <span class='content-result-show-child'>
               $final_2
            </span>
            <br/>           
        </div>";
    }
?>



<script>
$(function() {
    var ekstra = "<?php echo $get_ekstra[0][0]?>";
    var arrayGetTable= [ekstra];
    var reloadTable = function(){
        $("#content-table").html("<td colspan='6' align='center'>Mencoba Mengambil Data...h</td>");
        $.ajax({
                type: "POST",
                url: "index.php?sajen=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_table",
                data: {json: JSON.stringify(arrayGetTable)},
                cache: false,
                success: function(html) {

                    $("#content-table").html(html);
                } 
            });
    };

    var inserttoekstra = function(nis){
        var arrayKirim=[nis];
        $.ajax({
            type: "POST",
            url: "index.php?sajen=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_insert",
            data: {json : JSON.stringify(arrayKirim)},
            cache: false,
            success: function(html) {
                html=html.trim();
                if (html=="1"){

                    create_toast("info", "Sukses", "Berhasil Input ");
                } else {

                    create_toast("error", "Error", html);
                }

                reloadTable(); 
            }                   
        });
    };

    $('.content-bla').click(function(){

        var nis = $(this).attr('nis');
        inserttoekstra(nis);
       // console.log("asd");
        
    });
    //////////////////////////////////////
    var i = -1;
    var toastCount = 0;
    var $toastlast;

    var create_toast = function (tipe,judul,pesan){
        var shortCutFunction = tipe;//$("#toastTypeGroup input:radio:checked").val();
        var msg = pesan;//$('#message').val();
        var title = judul;//$('#title').val() || '';
        var showDuration = "600000";
        var hideDuration = "10000";
        var timeOut = "5000";
        var extendedTimeOut = "10000";
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
            /*
            onclick: function (){
                alert('You can perform some custom action after a toast goes away');
            } // or null
            */
        };

        
        $("#toastrOptions").text("Command: toastr["
                        + shortCutFunction
                        + "](\""
                        + msg
                        + (title ? "\", \"" + title : '')
                        + "\")\n\ntoastr.options = "
                        + JSON.stringify(toastr.options, null, 2)
        );
        

        var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
        $toastlast = $toast;
        //example toast event handler
        /*if ($toast.find('#okBtn').length) {
            $toast.delegate('#okBtn', 'click', function () {
                alert('you clicked me. i was toast #' + toastIndex + '. goodbye!');
                $toast.remove();
            });
        }
        */
    };
    
    $('#showtoast').click(function () {

        create_toast("warning","title","contain");
    });

    function getLastToast(){
        return $toastlast;
    }

    $('#clearlasttoast').click(function () {
        toastr.clear(getLastToast());
    });

    $('#cleartoasts').click(function () {
        toastr.clear();
    });
});
</script>