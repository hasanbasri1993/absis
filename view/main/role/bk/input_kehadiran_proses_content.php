<?php
$state_navbar = "input_kehadiran_proses";
include_once "view/main/require/navbar/navbar.php";
include_once "model/class/master.php";

$get_kelas = $_GET['kelas'];
$kelas = $get_kelas['0'];
$subkelas = $get_kelas['1'];
?>

<!--<div class="row">
	<div class="col-md-2">
	</div>
	<div class="col-md-8">
		<div class="the-box no-border">
			<form action="?sajen=input_kehadiran_save" method="POST">
				<input type="hidden" name="kelas" value="<?php echo $get_kelas;?>">
				<div class="table-responsive">
 					<table class="table table-th-block table-info table-striped table-hover">
						<thead>
							<tr>
								<th class="text-left" style="width:;">No</th>
								<th class="text-left" style="width:;">NIS</th>
								<th class="text-center" style="width:;">L/P</th>
								<th class="text-left" style="width:;">Nama</th>
								<th class="text-center" style="width:10%;">Sakit</th>
								<th class="text-center" style="width:10%">Ijin</th>
								<th class="text-center" style="width:10%;">Alpha</th>
							</tr>						
						</thead>
						<tbody id="content-table"> -->
							<?php
							$kelas= new Kelas($kelas,$subkelas);
							$getSiswa= $kelas->getSiswa();
							$banyakSiswa= sizeof($getSiswa);
							$x=0;
							$data_siswa = array();
							while ($x<$banyakSiswa) { 
								
								$siswa = new  Siswa($getSiswa[$x]['nis']);
								$kehadiran = $siswa -> getKehadiran();
								if (!isset($kehadiran[0]['sakit'])){

									$kehadiran[0]['sakit'] = "";
								}
								if (!isset($kehadiran[0]['izin'])){

									$kehadiran[0]['izin'] = "";
								}
								if (!isset($kehadiran[0]['alpha'])){

									$kehadiran[0]['alpha'] = "";
								}
								$no=$x+1;
								// echo "<tr>";
								// echo "<td>".$no."</td>";
								// echo "<td>".$getSiswa[$x]['nis']."</td>";
								// echo "<td class='text-center'>".$getSiswa[$x]['kelamin']."</td>";
								// echo "<td>".$getSiswa[$x]['nama']."</td>";
							 //    echo "
							 //    <td class='inline-popups text-center'>
							 //    	<input type='text' class='form-control input-sm input-e text-left' name='s-" . $getSiswa[$x]['nis'] . "'value='" . $kehadiran[0]['sakit'] . "' tabindex='".$no."' style='font-size: 15px' >
							 //    </td>";
							 //    echo "
							 //    <td class='inline-popups text-center'>
							 //    	<input type='text' class='form-control input-sm input-e text-left' name='i-" . $getSiswa[$x]['nis'] . "'value='" . $kehadiran[0]['izin'] . "' tabindex='".$no."' style='font-size: 15px' >
							 //    </td>";
							 //    echo "
							 //    <td class='inline-popups text-center'>
							 //    	<input type='text' class='form-control input-sm input-e text-left' name='a-" . $getSiswa[$x]['nis'] . "'value='" . $kehadiran[0]['alpha'] . "' tabindex='".$no."' style='font-size: 15px' >
							 //    </td>";
							 //    echo "</tr>";
							    array_push($data_siswa, array("no"=>$no,"nis"=>$getSiswa[$x]['nis'],"kelamin"=>$getSiswa[$x]['kelamin'],"nama"=>$getSiswa[$x]['nama'],"sakit"=>$kehadiran[0]['sakit'],"izin"=>$kehadiran[0]['izin'],"alpha"=>$kehadiran[0]['alpha']));
								$x++;   
							}
							$data_siswax = json_encode($data_siswa);
							?>
<!-- 						</tbody>
					</table>
				</div>
				<div class="row">
					<div class="text-center">
						<button type='submit' class='btn btn-info btn-lg' data-dismiss='modal'>Simpan Semua Nilai</button>
					</div>
				</div>
			</form> 
		</div>
	</div>
	<div class="col-md-2">
	</div>
</div>-->

<div class="row">
	<div class="col-md-2">
	</div>	
	<div class="col-md-8">
		<p><b>Keterangan: </b><span id="keterangan">Harap diperhatikan, isi kehadiran dengan <b>angka</b> agar dapat diolah sistem.</span></p>
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
    
    function kehadiranRenderer(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        if(value!=""){
            if (isNaN(value)){
                td.style.color      = 'red';
                td.style.background = '#F1A9A0';      
            }           
        }
    }       

    function kirimJSON(data_kirim, tabel){
 	   	$('#keterangan').html('Menyimpan data ...');
        $.post( "/index.php?sajen=input_kehadiran_save_json",
                {json: JSON.stringify(data_kirim)},
                function( data ){
                    var sum = data.length;
                    $('#keterangan').html('Semua perubahan tersimpan ('+sum+'cell)');
                }
        );
    }

    var data_siswa    = <?php echo $data_siswax;?>;

    var _header =[["NO", "NIS", "L/P", "NAMA", "SAKIT", "IZIN", "ALPHA",""]];
    var _content = [];
    for (var count = 0; count < data_siswa.length; count++) {
    	var sakit=0,izin=0,alpha=0;
    	if (data_siswa[count].sakit!="") {sakit=data_siswa[count].sakit};
    	if (data_siswa[count].izin!="") {izin=data_siswa[count].izin};
    	if (data_siswa[count].alpha!="") {alpha=data_siswa[count].alpha};
        _content.push([ data_siswa[count].no , data_siswa[count].nis , data_siswa[count].kelamin , toTitleCase(data_siswa[count].nama) , sakit , izin , alpha]);
    };        
    var datax = _header.concat(_content);

    var align_left =[];
    var t=0;
    while(t <= (data_siswa.length)){
        align_left.push({row: t, col: 3, className: "htLeft htMiddle"});
        t++;
    }

    var container = document.getElementById('tabel_nilai');
    var hot = new Handsontable(container, {
              data          : datax,
              minSpareRows  : 0,
              colWidths     : [60,100,70,400,80,80,80],
              rowHeaders    : false,
              colHeaders    : false,
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
                                    var input = change[ic][3];
                                    var input_lama = change[ic][2];
                                    var tipe ='';
                                    if (datax[0][change[ic][1]]=="IZIN"){
                                        tipe = "izin";
                                    }else if(datax[0][change[ic][1]]=="SAKIT"){
                                        tipe = "sakit";
                                    }else{
                                    	tipe = "alpha";
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
                                }if ((col >= 7)&&(col <=7)){
                                    cellProperties.readOnly = true;
                                }if ((col >= 4)&&(col <=6)){
                                    cellProperties.renderer = kehadiranRenderer;
                                }if ((row >= 0)&&(row <=0)){
                                    cellProperties.renderer = greyRenderer;
                                }
                                return cellProperties;
                              }              

    });
</script>
