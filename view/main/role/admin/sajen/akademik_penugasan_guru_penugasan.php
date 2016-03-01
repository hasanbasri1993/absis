<?php
include_once "model/class/master.php";
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');
?>
<div class="row">
    <div class="col-md-4">
        <div class="text-center">
            <h2>7</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-6">
                <?php
                $i = 1;
                $char = "A";
                while ($i <>10){
                echo "
                <div class='checkbox text-left'>
                  <label class='kelas-label' kelas='7$char' data-toggle='tooltip' data-placement='top' title='Dapat Diisi'>
                    <input type='checkbox' value='' kelas='7$char' class='kelas-checkbox' >
                    7 $char
                  </label>
                </div>";
                $i++;
                $char++;
                }
                ?>
            </div>            
        </div>
    </div>
    <div class="col-md-4">
        <div class="text-center">
            <h2>8</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-6">
                <?php
                $i = 1;
                $char = "A";
                while ($i <>10){
                echo "
                <div class='checkbox text-left'>
                  <label class='kelas-label' kelas='8$char' data-toggle='tooltip' data-placement='top' title='Dapat Diisi'>
                    <input type='checkbox' value='' kelas='8$char' class='kelas-checkbox' >
                    8 $char
                  </label>
                </div>";
                $i++;
                $char++;
                }
                ?>
            </div>            
        </div>
    </div>
    <div class="col-md-4">
        <div class="text-center">
            <h2>9</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-6">
                <?php
                $i = 1;
                $char = "A";
                while ($i <>10){
                echo "
                <div class='checkbox text-left'>
                  <label class='kelas-label' kelas='9$char' data-toggle='tooltip' data-placement='top' title='Dapat Diisi'>
                    <input type='checkbox' value='' kelas='9$char' class='kelas-checkbox' >
                    9 $char
                  </label>
                </div>";
                $i++;
                $char++;
                }
                ?>
            </div>            
        </div>
    </div>
</div>
<?php
$guru= new Guru($_POST['nip']);

$jumlahKelas=$guru->getKelas();
$kelasTerisi=$guru->getKelasTerisi();
$b = array();
$i = 0;
while($i <> sizeof($kelasTerisi)){
    array_push($b, $kelasTerisi[$i]['kelas'].$kelasTerisi[$i]['subkelas']);
    $i++;
}

$c = array();
$i = 0;
while($i <> sizeof($kelasTerisi)){
    array_push($c, $kelasTerisi[$i]['nama']);
    $i++;
}

$createtooltip = array_combine($b, $c);
//print_r($createtooltip);
$coco=0;
$a = array();
while ($coco<>sizeof($jumlahKelas)) {
array_push($a, $jumlahKelas[$coco][0].$jumlahKelas[$coco][1]);
    $coco++;
}
//print_r($a);
?>
<script type="text/javascript">
$( document ).ready(function() {
    $('[data-toggle="tooltip"]').tooltip(); 
    console.log( "ready2" );
    var thisNIP = "<?php echo $_POST['nip'];?>";
    console.log(thisNIP + ' selected');

    var createcheck = function(getcheck){
        $('input.kelas-checkbox[kelas=' + getcheck +']').attr('checked', true);        
    };
    var disablecheck = function(getcheck,ngajar){
        $('.kelas-label[kelas=' + getcheck +']').attr('data-original-title', ngajar);
        $('input.kelas-checkbox[kelas=' + getcheck +']').attr('disabled', true);
    };
    <?php
    foreach ($a as $list) {
        echo "createcheck('$list');";
    }
    ?>
    <?php
    foreach ($createtooltip as $kelas=>$ngajar) {
        echo "disablecheck('$kelas','$ngajar');";
    }

    ?>

    $('.kelas-checkbox').click (function(){
        var thisKelas = $(this).attr("kelas");
        var thisKelasFix = thisKelas.charAt(0);
        var thisSubKelasFix = thisKelas.charAt(1);
        console.log(thisKelasFix);
        console.log(thisSubKelasFix);
        console.log('click ' + thisKelas);
        var c = this.checked;
        if(this.checked){
            alert('set');
            $.post( "index.php?sajen=akademik_penugasan_guru_penugasan_set", {nip: thisNIP, kelas: thisKelasFix, subkelas: thisSubKelasFix}, function( data ) {
            });
        } else {
            alert('del');
            $.post( "index.php?sajen=akademik_penugasan_guru_penugasan_delete", {nip: thisNIP, kelas: thisKelasFix, subkelas: thisSubKelasFix}, function( data ) {
            });
        }
    });
});
</script>
