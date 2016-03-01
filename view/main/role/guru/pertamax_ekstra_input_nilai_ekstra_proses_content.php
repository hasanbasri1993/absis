<?php



  //print_r($_SESSION);
  $title_1 = $_SESSION['ekstra_access'][0][1];
  $state_navbar = "pertamax_ekstra_input_nilai_ekstra_proses"; // view/main/require/navbar/~ -home -content -other~
  include_once "view/main/require/navbar/navbar.php";
  include_once "model/class/master.php";

 // $siswaX=new Siswa(17854);
 // print_r($siswaX->getNilaiHarian(28));
  
  $kelas_get    = $_GET['kelas'][0];
  $subkelas_get = $_GET['kelas'][1];

  $kelas        = new Kelas($kelas_get,$subkelas_get);
  $nip          = $_SESSION['username'];
  $guru         = new Guru($nip);
  $kode_mapel   = $guru->getKodeMapel($kelas->getKurikulum());
  $mapel        = new Mapel($kode_mapel,$kelas_get,$subkelas_get);
  $daftar_siswa = $kelas->getSiswa();
  $jumlah_siswa = sizeof($daftar_siswa);
  $topik        = $mapel->getTopik();
  $kkm          = $mapel->getKKM();
  $topikx       = json_encode($topik);
  $daftar_siswax = json_encode($daftar_siswa);

  $nilai_siswa = array();
  for ($i=0; $i < $jumlah_siswa; $i++) {
    $siswa        = new Siswa($daftar_siswa[$i]['nis']);
    $n_UTS        = $siswa->getNilaiUTS($kode_mapel); 
    $n_UAS        = $siswa->getNilaiUAS($kode_mapel); //$siswa->getNilaiHarian($kode_topik);
	$na_UAS        = $siswa->getNilaiAkhir($kode_mapel);
    $nilai_topik  = array();
    for ($x=0; $x < sizeof($topik); $x++) { 
      //$n_topik = array('UT' => $n_UT, 'UL' => $n_UL, 'T' => $n_T);
      $arr_nilai = $siswa->getNilaiHarian($topik[$x]['topik_id']);
      //print_r($arr_nilai);
      array_push($nilai_topik, $arr_nilai);
    }
    $arr = array('nis' => $daftar_siswa[$i]['nis'],'nama' => $daftar_siswa[$i]['nama'],'kkm' =>$kkm,'r_UTS' => $n_UTS, 'r_UAS' => $na_UAS, 'UTS' => $n_UTS, 'UAS' => $n_UAS, 'topik' => $nilai_topik);
    array_push($nilai_siswa, $arr);
  }
  $nilai_siswax = json_encode($nilai_siswa);

?>
<script src="http://code.jquery.com/jquery-2.1.4.js"></script>
<script src="../../../../../model/feature/hot/dist/handsontable.full.js"></script>
<link rel="stylesheet" media="screen" href="../../../../../model/feature/hot/dist/handsontable.full.css">

<!-- <link data-jsfiddle="common" rel="stylesheet" media="screen" href="../../../../../model/feature/hot/dist/handsontable.full.css">
<script src="../../../../../model/feature/hot/dist/handsontable.full.js"></script> -->
<div class="col-sm-1 col-md-1"></div>
<div class="col-sm-10 col-md-10" style="">
  <div class="the-box no-border" style="background: none repeat scroll 0% 0% rgb(247, 249, 250); margin-top: 0px; padding: 0px; ">
    <div class="wrapper">
      <div class="wrapper-row">
        <div id="container">
          <div class="columnLayout">
            <div class="hot handsontable excel-nilai" id="tb_new" style="margin-top: 18px;width: 100%; height: 59vh; overflow: hidden;" >
            </div>
            <script type="text/javascript" data-jsfiddle="tb_new">
            /*_______________¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶__________________
            _____________¶¶¶________________¶¶¶_______________
            ___________¶¶______________________¶¶¶¶___________
            _________¶¶¶__________________________¶¶¶_________
            _______¶¶¶___________________¶¶¶¶_______¶¶________
            _¶¶¶¶¶¶__¶¶¶¶¶¶¶¶¶¶¶¶¶_____¶¶¶__¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶__
            __¶¶¶¶____¶¶¶¶¶¶¶¶¶_¶¶¶¶¶¶¶¶¶____¶¶¶¶¶¶¶¶¶¶¶¶¶¶___
            ___¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶___¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶____¶¶¶____
            __¶___¶¶¶¶¶¶¶¶______¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶¶______¶¶__¶__
            _¶¶___¶¶¶¶¶¶¶¶¶______¶¶¶¶¶¶¶¶¶¶¶¶¶¶_______¶¶__¶¶__
            ¶______¶¶¶¶¶¶¶¶_____¶¶¶___¶¶¶¶¶¶¶¶¶___¶¶¶¶¶____¶__
            ¶__________¶¶¶¶¶¶¶¶¶¶¶______¶¶¶¶¶¶¶¶¶¶¶__¶______¶¶
            ¶_______________________________________________¶¶
            ¶________¶¶_____________________________________¶¶
            ¶______¶¶¶¶_________________________¶¶¶¶________¶¶
            ¶_____¶__¶¶_________________________¶¶¶¶________¶¶
            ¶_________¶¶¶______________________¶¶___________¶¶
            ¶___________¶¶¶__________________¶¶¶____________¶¶
            ¶¶____________¶¶¶¶____________¶¶¶¶_____________¶__
            _¶¶______________¶¶¶¶¶¶¶¶¶¶¶¶¶¶________________¶__
            __¶___________________________________________¶¶__
            ___¶¶________________________________________¶¶___
            ____¶¶______________________________________¶¶____
            _____¶¶___________________________________¶¶______
            _______¶¶_______________________________¶¶¶_______
            _________¶¶___________________________¶¶¶_________
            __________¶¶¶¶_____________________¶¶_____________
            ______________¶¶¶¶_____________¶¶¶¶¶______________
            ___________________¶¶¶¶¶¶¶¶¶¶¶¶___________________
            ------ GOOD WORK, BUT WE'RE WATCHING YOU !! ------
            */
              var topik         = <?php echo $topikx; ?>;
              var nilai_siswa   = <?php echo $nilai_siswax;?>;
              var daftar_siswa  = <?php echo $daftar_siswax;?>;
              var kkm           = <?php echo $kkm;?>;

              var myData      = Handsontable.helper.createSpreadsheetData(100, 20),
                  container   = document.getElementById('tb_new'),
                  searchFiled = document.getElementById('search_field'),
                  positions   = document.getElementById('positions'),
                  autosaveNotification,
                  hot;
              
              //fungsi get topik
              //data_topik=[['Aljabar',10],['Eksponen',14],['Logaritma',13]]; // Data Topik dan id-topik
              data_topik=[];
              var x = 0;
              while(x < topik.length){
                data_topik.push([topik[x].topik_nama_singkat , topik[x].topik_id]);
                x++;
              };

              // ARRAY UNTUK HEADER TABEL
              data_header=[
                  [''   , 'NIS', 'NAMA' , 'NILAI RAPOR' ,'x'    ,'KKM'  ,'UJIAN','UJIAN'  ],
                  ['No' , 'x'  , 'x'    , 'x'           ,'x'    ,'x'    ,'UTS'  ,'UAS'  ],
                  [''   , 'x'  , 'x'    , 'UTS'         ,'UAS'  ,'x'    ,'UTS'  ,'UAS'  ]
              ];
              
              // INPUT TOPIK KE data_header
              var c = 5;
              for (i=0;i < data_topik.length; i++){
                c = c+3;
                data_header[0][c]= 'TOPIK'          ;data_header[0][c+1]= 'TOPIK'          ;data_header[0][c+2]= 'TOPIK';
                data_header[1][c]= data_topik[i][0] ;data_header[1][c+1]= data_topik[i][1] ;data_header[1][c+2]= data_topik[i][1];
                data_header[2][c]= 'UT'             ;data_header[2][c+1]= 'UL'             ;data_header[2][c+2]= 'T';
              };
              // END ARRAY UNTUK HEADER TABEL
              
              // ARRAY UNTUK NAMA & NILAI TIAP TOPIK
              //data_nilai=[[nis,[kode_topik,UT/UL/T,nilai][kode_topik,UT/UL/T,nilai][kode_topik,UT/UL/T,nilai][][][]],....];
              data_nilai=[];
                
              // ARRAY UNTUK MERGE TABLE
              data_merge = [
                    {row: 0, col: 0, rowspan: 1, colspan: 1}, //No
                    {row: 0, col: 1, rowspan: 3, colspan: 1}, //NIS
                    {row: 0, col: 2, rowspan: 3, colspan: 1}, //NAMA
                    {row: 0, col: 3, rowspan: 2, colspan: 2}, //NILAI AKHIR
                    {row: 0, col: 5, rowspan: 3, colspan: 1}, //KKM
                    {row: 0, col: 6, rowspan: 2, colspan: 2}, //UJIAN
                    {row: 0, col: 8, rowspan: 1, colspan: (data_topik.length)*3}, //TOPIK
              ];
              var c = 5;
              for (i=0;i < data_topik.length; i++){
                c = c+3;
                data_merge.push({row: 1, col: c, rowspan: 1, colspan: 3});
              };      
              //PENGULANGAN SISWA DAN NILAI
              data_isi=[];
              for (i = 0; i < nilai_siswa.length; i++) {
                data_isi.push([i+1, daftar_siswa[i].nis, toTitleCase(daftar_siswa[i].nama), nilai_siswa[i].r_UTS, nilai_siswa[i].r_UAS, kkm, nilai_siswa[i].UTS, nilai_siswa[i].UAS]);
                //              no          nis                      nama                                 uts                uas
                for (var j = 0; j < data_topik.length; j++) {
                  data_isi[i].push(nilai_siswa[i].topik[j].ut, nilai_siswa[i].topik[j].ul, nilai_siswa[i].topik[j].t);
                };
              };

              function toTitleCase(str){
                  var strx = str.replace(/\./g, ' ');
                  return strx.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
              }
              
              // datax = gabungan array header dan data untuk array yang akan ditampilkan
              datax = data_header.concat(data_isi), container = document.getElementById('tb_new'),hot;
              
              function headerRowRenderer(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                td.style.fontWeight = 'bold';
                td.style.color      = 'black';
                td.style.background = '#ecf0f1';
              }
              
              function greyRenderer(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                td.style.color = 'black';
              }
              
              function cekNilaiRenderer(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                td.style.color = 'black';
                if ((typeof value == 'object')||(typeof value == 'undefined')){
                  // do nothing
                }else if((typeof value == 'string')||(typeof value == 'number')){
                  if (isNaN(value)){
                    //ini string
                    td.style.background = '#F1A9A0';
                    td.style.color = 'black';
                  }else{
                    //ini angka
                    if ((parseInt(value, 10) < 0)||(parseInt(value, 10) > 100)) {
                      td.style.background = '#F1A9A0';
                      td.style.color = 'black';
                    }else{
                      if(value < kkm){
                        td.style.color = 'red';
                      }
                    }
                  }                
               }
              }
              
              /*
                Fungi kirimJSON digunakan untuk menyimpan nilai perubahan pada tabel hot, 
                   data_kirim = {[sessionID,TA,Semester],[nis,tipe_nilai,kode_topik,kode_nilai,nilai,row, col],......}
                data_kirim[0] buat data sessionID, TA, dan Semester| data_kirim[1] s/d seterusnya isinya data tiap cell yg ganti
                 - sesID      : otentikasi session ID
                 - TA         : tahun ajaran, ex:'2014' => 2014/2015
                 - Semester   : 1/2
                 ==================================================
                 - nis        : nis siswa yang nilainya diganti
                 - tipe_nilai : ujian/harian , 
                 - kode_topik : def=>null, jika tipe nilai=1(ujian)
                 - kode_nilai : UTS/UAS/UL/UT/T
                 - nilai      : yo nilai -_-
                 - row        : baris
                 - col        : kolom
                 jadi kalau ada n cell yang diganti, kirimJSON bakal ngirim array yg isinnya n+1 array
              */
              function kirimJSON(data_kirim, tabel){
                var sessionID ="<?php echo $_SESSION['session_session_id'];?>";
                var TA        ="<?php echo $_SESSION['TA'];?>";
                var Semester  ="<?php echo $_SESSION['semester'];?>";
                //data_kirim    =[sessionID,TA,Semester,nis,tipe_nilai,kode_topik,kode_nilai,nilai,row, col];
                data_kirim.unshift([sessionID,TA,Semester]);
                $('#status').html('Menyimpan data...');

                  $.post("/index.php?sajen=input_nilai_proses_content",
                  {json: JSON.stringify(data_kirim)},
                  function( data ){

                      console.log(data);
                      if(data[0][0]=="200"){
                        var jml =1;
                        while(jml < data.length){
                          console.log(data_kirim[jml][4]);
                          console.log(data[jml][4]);
                          if(data_kirim[jml][4] == data[jml][4]){
                            //Nulis data yang dikirim balik
                            datax[data[jml][5]][data[jml][6]]=data[jml][4];
                            if(data[jml][3]=='UTS'){
                              datax[data[jml][5]][3]=data[jml][4];// ganti nilai rapor uts =======> harusnya di server
							  datax[data[jml][5]][4]=data[jml][7];
                            }else{
                              datax[data[jml][5]][4]=data[jml][7];// ganti nilai rapor UAS
                            }
                          }else{
                            datax[data[jml][5]][data[jml][6]]="error";
                          }
                          jml++;
                        }
                      }

                      tabel.loadData(datax);
                      tabel.updateSettings({
                        className       : "htCenter htMiddle", 
                                          cell: array_left
                      });
                      tabel.render();
                      $('#status').html('Semua perubahan tersimpan');
                  });

              }

              var t=3;
              var array_left=[];
              while(t < (nilai_siswa.length+3)){
                array_left.push({row: t, col: 2, className: "htLeft htMiddle"});
                t++;
              }

              hot = new Handsontable(container, {
                data            : datax,
                colWidths       : [50, 100, 300, 40, 40, 40, 40, 40, 40, 40, 40, 40],
                rowHeaders      : false,
                colHeaders      : false,
                fixedRowsTop    : 3,
                fixedColumnsLeft: 3,

                customBorders   : [
                                    { row: 1, col: 0, top: { width: 1,color: '#ecf0f1'}, bottom: { width: 1,color: '#ecf0f1'}}
                                  ],
                contextMenu     : {callback: function (key, options) {
                                      if (key === 'about') {
                                        setTimeout(function () {
                                          // timeout is used to make sure the menu collapsed before alert is shown
                                          alert("Riwayat data");
                                        }, 100);
                                      }
                                    },
                                    items: {
                                      "copy": {},
                                      "paste": {},
                                      "hsep": "---------",
                                      "about": {name: 'Riwayat Data'}
                                    }
                                  },
                contextMenuCopyPaste: {
                                        swfPath: '../../../../../model/feature/hot/swf/ZeroClipboard.swf'
                                      },
                mergeCells      : data_merge,
                className       : "htCenter htMiddle", 
                                  cell: array_left,
                stretchH        : "last",  
                minSpareCols    : 1,
                onSelection     : function (row, col, row2, col2) {
                                    var meta = this.getCellMeta(row2, col2);
              
                                    if (meta.readOnly) {
                                      this.updateSettings({fillHandle: false});
                                    }
                                    else {
                                      this.updateSettings({fillHandle: true});
                                    }
                                  },
                // beforeChange    : function(changes, source) {            
                //                     if (source === 'actualizardia') {
                //                         return;
                //                     }
                                    
                //                 },                  
                afterChange     : function (change, source) {
                                    if (source === 'loadData') {
                                      return; //don't save this change
                                    }    
                                    var array_kirim=[];               
                                    for (i = 0; i < change.length; i++) { 
                                        var nis = datax[change[i][0]][1];
                                        var tipe_nilai = '';
                                        var kode_topik = null;
                                        var kode_nilai = null;
                                        if (datax[0][change[i][1]] == "UJIAN"){
                                          tipe_nilai='ujian';
                                          kode_topik=null;
                                        }else{
                                          tipe_nilai ='harian';
                                          kode_topik=datax[1][cell_topik(change[i][1])+1];
                                        }
                                        kode_nilai=datax[2][change[i][1]];
                                        var nilai=change[i][3];
                                        var baris = change[i][0];
                                        var kolom = change[i][1];
                                        array_kirim.push([nis,tipe_nilai,kode_topik,kode_nilai,nilai,baris,kolom]);
                                    }
                                    //save nilai kalo nilainya nggak error
                                    if ((isNaN(nilai) != true)&&(tipe_nilai!='')){
                                      kirimJSON(array_kirim, this);
                                      //edit-edit :D
                                      // datax[baris][kolom]="xx";
                                      // this.loadData(datax);
                                      // this.updateSettings({ className       : "htCenter htMiddle", 
                                      //                       cell: array_left});
                                      // this.render();
                                    }else{console.log("data salah");}
                                    // fungsi buat nyari cell nama topik
                                    function cell_topik(x){
                                      if(x<8){
                                        if((x==7)||(x==6)){
                                          return x;
                                        }else{
                                          return;
                                        }
                                      }                
                                      return x-((x+1)%3);
                                    }
                                    //this.setDataAtCell(8, 8, 33);
                                  },
                cells           : function (row, col, prop) {
                                    var cellProperties = {};
                                    
                                    if ((col >= 0)&&(col <= 5)){
                                      cellProperties.readOnly = true;
                                      cellProperties.renderer = greyRenderer;
                                    }if ((col > 2)&&(row > 2)){
                                      cellProperties.renderer = cekNilaiRenderer;
                                    }if ((row >= 0)&&(row <=2 )){
                                      cellProperties.renderer = headerRowRenderer;
                                      cellProperties.readOnly = true;
                                    }if ((col >= datax[0].length-1)||(row >= datax.length)){
                                      cellProperties.readOnly = true;
                                    }              
                                    return cellProperties;
                                  }
              });
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="col-sm-1 col-md-1"></div>