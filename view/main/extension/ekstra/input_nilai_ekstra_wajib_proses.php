<?php
include_once "model/class/master.php";
$nip = $_SESSION['username'];
$guru = new Guru($_SESSION['username']);
$title_1 = "Nilai Kehadiran ". $_GET['kelas'];
?>
<div class="the-box no-border" style="padding--right: 0px; padding--left: 0px; background: #FBFBFB; margin-bottom: 0px; padding-bottom: 0px;">
    <h2 class="page-heading text-center" style="margin-top: 0px; margin-bottom: 0px;">
         <?php
        require_once "model/class/master.php";
        $guru = new Guru($_SESSION['username']);
        $get_ekstra = $guru -> getPenugasanEkstra();
        
        if (isset($get_ekstra[1][1])){

            $title_1 = $get_ekstra[1][1];
        } else {
            $title_1 = $get_ekstra[0][1];
        }
       
        echo $title_1 . " " . $_GET['kelas'];
        ?>
    </h2>
</div>
<div class="the-box toolbar no-border no-margin text-center" style="padding-bottom: 0px; padding-top: 0px; margin-bottom: 0px; margin-top: 0px; border-bottom-width: 0px; background: none repeat scroll 0% 0% rgb(251, 251, 251);">
    <div class="row" style="margin-top: 0px; padding-top: 20px; padding-bottom: 0px;">
        <div class="col-md-12 text-center" style="padding-top: 0px; padding-bottom: 20px;">
            <div class="btn-group">
                <a class="btn btn-default " href="?p=home" type="button"><i class="fa fa-chevron-left" style="color: #3498db;"></i>&nbsp; Kembali</a>
            </div>
            <div class="btn-group">
                <a class="btn btn-default" href="?p=home" type="button"><i class="fa fa-home" style="color: #3498db;"></i>&nbsp; Home</a>
            </div>
            &nbsp; &nbsp;
            <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-danger dropdown-toggle" type="button">
                    Pilih Kelas
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu danger">
                    <li><a href='?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_wajib_proses&kelas=7A'>7A</a></li>
                    <li><a href='?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_wajib_proses&kelas=7B'>7B</a></li>
                    <li><a href='?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_wajib_proses&kelas=7C'>7C</a></li>
                    <li><a href='?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_wajib_proses&kelas=7D'>7D</a></li>
                    <li><a href='?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_wajib_proses&kelas=7E'>7E</a></li>
                    <li><a href='?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_wajib_proses&kelas=7F'>7F</a></li>
                    <li><a href='?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_wajib_proses&kelas=7G'>7G</a></li>
                    <li><a href='?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_wajib_proses&kelas=7H'>7H</a></li>
                    <li><a href='?p=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_wajib_proses&kelas=7I'>7I</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <div class="btn-group">
                    <button class="btn btn-info inline-popups" data-toggle="modal" data-target="#ModalTombolSakti" >
                        <p id="status" style="margin:0px;">OK</p>
                    </button>
                 </div>
            </div>
            <div class="modal fade" id="ModalTombolSakti" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" style="margin-top: 15%;">
                    <div class="modal-content">
                        <div class="modal-header bg-info no-border">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title text-center">Hello</h3>
                        </div>
                        <div class="modal-body"style="color: rgba(1,1,1,0.6);">                 
                            <h3 class="text-center">
                                 . Tombol Sakti .
                            </h3>
                            <br />
                        </div>  
                        <div class="modal-footer">
                            <a type="button" class="btn btn-default" data-dismiss="modal">Keluar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include_once "model/class/master.php";

    function getNameFromNumber($num) {
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return getNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }

    $getKelas     = $_GET['kelas'][0].$_GET['kelas'][1];
    $kelas        = new Kelas($_GET['kelas'][0],$_GET['kelas'][1]);
    $daftar_siswa = $kelas->getSiswa();
    $jumlah_siswa = sizeof($daftar_siswa);
    $nip          = $_SESSION['username'];
    $guru         = new Guru($nip);
    $get_ekstra_id = $guru -> getPenugasanEkstra();
    
    if (isset($get_ekstra_id[1]['ekskul_id'])){
        $ekstra_id = $get_ekstra_id[1]['ekskul_id'];
    } else {
        $ekstra_id = $get_ekstra_id[0]['ekskul_id'];
    }

    $data_siswa = array();
    for ($siswa_count=0; $siswa_count < sizeof($daftar_siswa); $siswa_count++) { 
        $siswa = new Siswa($daftar_siswa[$siswa_count]['nis']);
        $nilai_ekstra = $siswa->getNilaiEkskulx($ekstra_id);
        if (sizeof($nilai_ekstra)==1) {
            $xyz = array("nis"=>$daftar_siswa[$siswa_count]['nis'], "nama"=>$daftar_siswa[$siswa_count]['nama'], "nilai"=>$nilai_ekstra[0]['nilai'], "keterangan"=>$nilai_ekstra[0]['keterangan']);
        }else{
            $xyz = array("nis"=>$daftar_siswa[$siswa_count]['nis'], "nama"=>$daftar_siswa[$siswa_count]['nama'], "nilai"=>"", "keterangan"=>"");
        }
        array_push($data_siswa, $xyz);
    }
    //print_r($data_siswa);
    $daftar_siswax = json_encode($daftar_siswa);
    $data_siswax = json_encode($data_siswa);
    $kelasx = json_encode($getKelas);
    $ekstra_idx = json_encode($ekstra_id);

?>
<script src="http://code.jquery.com/jquery-2.1.4.js"></script>
<script src="../../../../../model/feature/hot/dist/handsontable.full.js"></script>
<link rel="stylesheet" media="screen" href="../../../../../model/feature/hot/dist/handsontable.full.css">

<div class="col-sm-2 col-md-2"></div>
<div class="col-sm-8 col-md-8">
    <p><b>Keterangan:&nbsp;&nbsp;</b><span id="keterangan">Harap diperhatikan, isi nilai dengan indeks <b>A</b>, <b>B</b>, <b>C</b>, <b>D</b>, atau <b>E</b> agar dapat diolah sistem.</span></p>
    <div class="the-box no-border" style="background: none repeat scroll 0% 0% rgb(247, 249, 250); margin-top: 0px; padding: 0px; ">
        <div class="wrapper">
            <div class="wrapper-row">
                <div id="container">
                    <div class="columnLayout">
                        <div class="hot handsontable excel-nilai" id="tabel_nilai" style="margin-top: 18px;width: 100%; height: 55vh; overflow: hidden;" >
                              <!-- Tempat input nilai ada di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-2 col-md-2"></div>

<script type="text/javascript">


    function toTitleCase(str){
        var strx = str.replace(/\./g, ' ');
        return strx.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
    }

    function greyRenderer(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.fontWeight = 'bold';
        td.style.color      = 'black';
        td.style.background = '#ecf0f1';
    }

    function contentRenderer(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.color      = 'black';
    }

    function centerRenderer(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.color      = 'black';
    }

     function nilaiRenderer(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        if(value!=""){
            if (!isNaN(value)){
                td.style.color      = 'red';
                td.style.background = '#F1A9A0';      
            }else{ 
                if((value!="A")&&(value!="B")&&(value!="C")&&(value!="D")&&(value!="E")){
                    td.style.color      = 'red';
                    td.style.background = '#F1A9A0';      
                }
            };            
        }
    }   

    function kirimJSON(data_kirim, tabel){
        $('#keterangan').html('Menyimpan data ...');
        $.post( "/index.php?sajen=pertamax_ekstra_input_nilai_ekstra+input_nilai_ekstra_wajib_save",
                {json: JSON.stringify(data_kirim)},
                function( data ){
                    var sum = data.length;
                    $('#keterangan').html('Semua perubahan tersimpan ['+sum+'cell]');
                }
        );
    }

    var daftar_siswa  = <?php echo $daftar_siswax;?>;
    var data_siswa    = <?php echo $data_siswax;?>;
    var kelas         = <?php echo $kelasx;?>;
    var ekskul_id     = <?php echo $ekstra_idx;?>;

    var _header =[["NO", "NIS", "KELAS", "NAMA", "NILAI", "KETERANGAN"]];
    var _content = [];
    for (var count = 0; count < daftar_siswa.length; count++) {
        _content.push([count+1 , data_siswa[count].nis , kelas , toTitleCase(data_siswa[count].nama) , data_siswa[count].nilai , data_siswa[count].keterangan]);
    };       
    //console.log(_content);
    var datax = _header.concat(_content);

    var align_left =[];
    var t=0;
    while(t <= (daftar_siswa.length)){
        align_left.push({row: t, col: 3, className: "htLeft htMiddle"});
        t++;
    }

    var container = document.getElementById('tabel_nilai');
    var hot = new Handsontable(container, {
              data          : datax,
              minSpareRows  : 0,
              colWidths     : [40,90,60,300,80],
              rowHeaders    : false,
              colHeaders    : false,
              //colHeaders    : ["NO", "NIS", "KELAS", "NAMA", "NILAI", "KETERANGAN"],
              fixedRowsTop  :1,
              fixedColumnsLeft: 4,    
              className     : "htCenter htMiddle",    
              cell          : align_left, 
              stretchH      : 'last', //"all" -> stretch sama, tapi colWodths jgn dipake
              contextMenu   : false,
              afterChange   : function (change, source) {
                                if (source === 'loadData') {
                                  return; 
                                }    
                                var array_kirim     = [];   
                                for (ic = 0; ic < change.length; ic++) { 
                                    var nis = datax[change[ic][0]][1];
                                    var ex_id = ekskul_id;
                                    var nilai = change[ic][3].toUpperCase();
                                    var nilai_lama = change[ic][2];
                                    var tipe ='';
                                    if (datax[0][change[ic][1]]=="NILAI"){
                                        tipe = "nilai";
                                        if (!isNaN(nilai)) {
                                            //kalo angka langsung dinol'in
                                            nilai = "";
                                        }else{ 
                                            if((nilai!="A")&&(nilai!="A+")&&(nilai!="a")&&(nilai!="a+")&&(nilai!="B")&&(nilai!="B+")&&(nilai!="b")&&(nilai!="b+")&&(nilai!="C")&&(nilai!="C+")&&(nilai!="c")&&(nilai!="c+")&&(nilai!="D")&&(nilai!="D+")&&(nilai!="d")&&(nilai!="d+")&&(nilai!="E")&&(nilai!="E+")&&(nilai!="e")&&(nilai!="e+")){
                                                nilai="";
                                            }
                                        };
                                    }else{
                                        tipe = "ket";
                                    }
                                    array_kirim.push([tipe,nis,ex_id,nilai,nilai_lama]);

                                    console.log(change);
                                }
                                console.log(array_kirim);
                                kirimJSON(array_kirim, this);

                            },
              cells         : function (row, col, prop) {
                                var cellProperties = {};
                                if ((col >= 0)&&(row >=0)){
                                    cellProperties.renderer = contentRenderer;
                                }if ((col >= 4)&&(col <=4)){
                                    cellProperties.renderer = nilaiRenderer;
                                }if ((col >= 0)&&(col <=3)){
                                    cellProperties.readOnly = true;
                                }if ((row >= 0)&&(row <=0)){
                                    cellProperties.renderer = greyRenderer;
                                }
                                return cellProperties;
                              }
    });
</script>
