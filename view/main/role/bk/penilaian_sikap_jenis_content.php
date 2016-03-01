<?php
	$state_navbar = "penilaian_sikap_jenis";
	include_once "view/main/require/navbar/navbar.php";
	include_once "model/class/master.php";

	$get_kelas = $_GET['kelas'];
	$kelas = $get_kelas['0'];
	$subkelas = $get_kelas['1'];

	$kelas= new Kelas($kelas,$subkelas);
	$getSiswa= $kelas->getSiswa();
	$banyakSiswa= sizeof($getSiswa);
	$x=0;
	$data_siswa = array();
	while ($x<$banyakSiswa) { 
        $siswa = new  Siswa($getSiswa[$x]['nis']);
        $sikap = $siswa -> getSikap();
        if (!isset($sikap[0]['kejujuran'])){

            $sikap[0]['kejujuran'] = "";
        }
        if (!isset($sikap[0]['kedisiplinan'])){

            $sikap[0]['kedisiplinan'] = "";
        }
        if (!isset($sikap[0]['tanggungjawab'])){
            $sikap[0]['tanggungjawab'] = "";
        }  
        if (!isset($sikap[0]['deskripsi_kejujuran'])){

            $sikap[0]['deskripsi_kejujuran'] = "";
        }
        if (!isset($sikap[0]['deskripsi_kedisiplinan'])){

            $sikap[0]['deskripsi_kedisiplinan'] = "";
        }
        if (!isset($sikap[0]['deskripsi_tanggungjawab'])){
            $sikap[0]['deskripsi_tanggungjawab'] = "";
        }   
		$no=$x+1;
		array_push($data_siswa, array("no"=>$no,"nis"=>$getSiswa[$x]['nis'],"kelamin"=>$getSiswa[$x]['kelamin'],"nama"=>$getSiswa[$x]['nama'],"n_kejujuran"=>$sikap[0]['kejujuran'],"d_kejujuran"=>$sikap[0]['deskripsi_kejujuran'],"n_kedisiplinan"=>$sikap[0]['kedisiplinan'],"d_kedisiplinan"=>$sikap[0]['deskripsi_kedisiplinan'],"n_tanggung_jawab"=>$sikap[0]['tanggungjawab'],"d_tanggung_jawab"=>$sikap[0]['deskripsi_tanggungjawab']));
		$x++;
	}
	$data_siswax = json_encode($data_siswa);
?>

<div class="row">
	<div class="col-md-2">
	</div>	
	<div class="col-md-8"> 
        <p><b>Keterangan: </b><span id="keterangan">Harap diperhatikan, isi sikap dengan indeks <b>A</b>, <b>B</b>, <b>C</b>, <b>D</b>, atau <b>E</b> agar dapat diolah sistem.</span></p>
	    <div class="the-box no-border" style="background: none repeat scroll 0% 0% rgb(247, 249, 250); margin-top: 0px; padding: 0px; ">
        <div class="wrapper">
            <div class="wrapper-row">
                <div id="container">
                    <div class="columnLayout">
                        <div class="hot handsontable excel-nilai" id="tabel_nilai" style="margin-top: 18px;width: 100%; height: 56vh; overflow: hidden;" >
                              <!-- Tempat input nilai ada di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	</div>
	<div class="col-md-2">
	</div>	
</div>
<script src="http://code.jquery.com/jquery-2.1.4.js"></script>
<script src="../../../../../model/feature/hot/dist/handsontable.full.js"></script>
<link rel="stylesheet" media="screen" href="../../../../../model/feature/hot/dist/handsontable.full.css">
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

    function sikapRenderer(instance, td, row, col, prop, value, cellProperties) {
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
        $.post( "/index.php?sajen=input_sikap_save_json",
                {json: JSON.stringify(data_kirim)},
                function( data ){
                    var sum = data.length;
                    $('#keterangan').html('Semua perubahan tersimpan ('+sum+'cell)');
                }
        );
    }

	var data_siswa    = <?php echo $data_siswax;?>;
    var _header =[  
                    ["  ","NIS", "L/P", "NAMA", "SIKAP"    , "SIKAP"    , "SIKAP"      ,"SIKAP"        ,"SIKAP"         ,"SIKAP"        ,""],
                    ["NO", "x", "L/P" , "NAMA", "KEJUJURAN", "KEJUJURAN","KEDISIPLINAN", "KEDISIPLINAN","TANGGUNG JAWAB","TANGUNG JAWAB",""],
                    ["  ", "x", "L/P" , "NAMA", "INDEKS"   , "DESKRIPSI", "INDEKS"     , "DESKRIPSI"   , "INDEKS"       , "DESKRIPSI"   ,""]
                 ];
    data_merge = [
        
        {row: 0, col: 0, rowspan: 1, colspan: 1}, //NO
        {row: 0, col: 1, rowspan: 3, colspan: 1}, //NIS
        {row: 0, col: 2, rowspan: 3, colspan: 1}, //LP
        {row: 0, col: 3, rowspan: 3, colspan: 1}, //NAMA
        {row: 1, col: 4, rowspan: 1, colspan: 2}, //KEJUJURAN
        {row: 1, col: 6, rowspan: 1, colspan: 2}, //KEDISIPLINAN
        {row: 1, col: 8, rowspan: 1, colspan: 2}, //TANGGUNG JAWAB
        {row: 0, col: 4, rowspan: 1, colspan: 6} //SIKAP
    ];                 
    var _content = [];
    for (var count = 0; count < data_siswa.length; count++) {
        _content.push([ data_siswa[count].no , data_siswa[count].nis , data_siswa[count].kelamin , toTitleCase(data_siswa[count].nama) , data_siswa[count].n_kejujuran , data_siswa[count].d_kejujuran , data_siswa[count].n_kedisiplinan , data_siswa[count].d_kedisiplinan , data_siswa[count].n_tanggung_jawab , data_siswa[count].d_tanggung_jawab]);
    };      
    var datax = _header.concat(_content);

    var align_left =[];
    var t=3;
    while(t <= (data_siswa.length+2)){
        align_left.push({row: t, col: 3, className: "htLeft htMiddle"});
        align_left.push({row: t, col: 5, className: "htLeft htMiddle"});
        align_left.push({row: t, col: 7, className: "htLeft htMiddle"});
        align_left.push({row: t, col: 9, className: "htLeft htMiddle"});
        t++;
    }    

    var container = document.getElementById('tabel_nilai');
    var hot = new Handsontable(container, {
              data          : datax,
              minSpareRows  : 0,
              colWidths     : [40,80,50,240,75,88,75,88,75,88],
              rowHeaders    : false,
              colHeaders    : false,
              fixedRowsTop  : 3,
              fixedColumnsLeft: 4,    
              className     : "htCenter htMiddle",  
              cell          : align_left, 
              stretchH      : 'last', //"all" -> stretch sama, tapi colWodths jgn dipake
              contextMenu   : false,
              mergeCells    : data_merge,
              afterChange   : function (change, source) {
                                if (source === 'loadData') {
                                  return; 
                                }    
                                var array_kirim     = [];   
                                for (ic = 0; ic < change.length; ic++) { 
                                    var nis = datax[change[ic][0]][1];                              
                                    var input_lama = change[ic][2];
                                    var tipe ='';
                                    if (datax[1][change[ic][1]]=="KEJUJURAN"){
                                        if (datax[2][change[ic][1]]=="INDEKS") {tipe = "n_kejujuran";};
                                        if (datax[2][change[ic][1]]=="DESKRIPSI") {tipe = "d_kejujuran";};                                        
                                    }else if(datax[1][change[ic][1]]=="KEDISIPLINAN"){
                                        if (datax[2][change[ic][1]]=="INDEKS") {tipe = "n_kedisiplinan";};
                                        if (datax[2][change[ic][1]]=="DESKRIPSI") {tipe = "d_kedisiplinan";};                                             
                                    }else{
                                        if (datax[2][change[ic][1]]=="INDEKS") {tipe = "n_tanggung_jawab";}else{tipe = "d_tanggung_jawab";};                                             
                                    }
                                    if (tipe.charAt(0)=="n") {
                                        var input = change[ic][3].toUpperCase();
                                        if (!isNaN(input)) {
                                            //kalo angka langsung dinol'in
                                            input = "";
                                        }else{ 
                                            if((input!="A")&&(input!="A+")&&(input!="a")&&(input!="a+")&&(input!="B")&&(input!="B+")&&(input!="b")&&(input!="b+")&&(input!="C")&&(input!="C+")&&(input!="c")&&(input!="c+")&&(input!="D")&&(input!="D+")&&(input!="d")&&(input!="d+")&&(input!="E")&&(input!="E+")&&(input!="e")&&(input!="e+")){
                                                input="";
                                            }
                                        };      
                                    }else if (tipe.charAt(0)=="d"){
                                        var input = change[ic][3];
                                    }
                                    array_kirim.push([tipe,nis,input,input_lama]);

                                    console.log(change);
                                }
                                console.log(array_kirim);
                                kirimJSON(array_kirim, this);

                            },               
              cells         : function (row, col, prop) {
                                var cellProperties = {};
                                if ((col >= 0)&&(row >=0)){
                                    cellProperties.renderer = contentRenderer;
                                }if ((col >= 0)&&(col <=3)){
                                    cellProperties.readOnly = true;
                                }if ((col >= 10)&&(col <=10)){
                                    cellProperties.readOnly = true;
                                }if ((col >= 4)&&(col <=4)){
                                    cellProperties.renderer = sikapRenderer;
                                }if ((col >= 6)&&(col <=6)){
                                    cellProperties.renderer = sikapRenderer;
                                }if ((col >= 8)&&(col <=8)){
                                    cellProperties.renderer = sikapRenderer;
                                }if ((row >= 0)&&(row <=2)){
                                    cellProperties.renderer = greyRenderer;
                                }if ((row >= 0)&&(row <=2)){
                                    cellProperties.readOnly = true;
                                }
                                return cellProperties;
                              } 

    });
</script>
