<?php
$title_1 = "FISIKA";
$title_2 = "SMPN 1 SEMARANG";
$state_navbar = "input_nilai_proses"; // view/main/require/navbar/~ -home -content -other~
include_once "view/main/require/navbar/navbar.php";
?>
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="../../../../../model/hot/dist/handsontable.full.css">
<script data-jsfiddle="common" src="../../../../../model/hot/dist/handsontable.full.js"></script>

<div class="col-sm-1 col-md-1">
</div>

<div class="col-sm-10 col-md-10" style="">			
	<div class="the-box no-border" style="background: none repeat scroll 0% 0% rgb(247, 249, 250); margin-top: 0px; padding-top: 0px;">
		<div class="wrapper">
  <div class="wrapper-row">

    <div id="container">
      <div class="columnLayout">        
        <div class="handsontable" id="tb_new" style="width: 100%; height: 500px; overflow: hidden" ></div>
          <script type="text/javascript" data-jsfiddle="tb_new">
            var myData = Handsontable.helper.createSpreadsheetData(100, 20),
                container = document.getElementById('tb_new'),
                positions = document.getElementById('positions'),
                autosaveNotification,
                hot;

            data_topik=[['Aljabar',10],['Eksponen',14],['Logaritma',13]]; // Data Topik dan id-topik

            // ARRAY UNTUK HEADER TABEL
            data_header=[
                [''   , 'NIS', 'NAMA' , 'NILAI AKHIR' ,'x'    ,'KKM'  ,'UJIAN','x'  ],
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
            for (i = 0; i < 40; i++) {
              data_isi.push([i+1, 21202060+i, 'Sudirman Sukijan Sucirman', 90, 87,76, , , ]);
              //              no    nis              nama                  uts uas
            };

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


            hot = new Handsontable(container, {
              data            : datax,
              colWidths       : [50, 100, 250, 50, 50, 50, 50, 50, 50, 50, 50, 50],
              rowHeaders      : false,
              colHeaders      : false,
              fixedRowsTop    : 3,
              fixedColumnsLeft: 3,
              contextMenu     : true,
              mergeCells      : data_merge,
              className       : "htCenter htMiddle",              
              afterChange     : function (change, source) {
                                  if (source === 'loadData') {
                                    return; //don't save this change
                                  }          
                                  clearTimeout(autosaveNotification);
                                  console.log("NIS:"+datax[change[0][0]][1]+" Topik:"+datax[1][cell_topik(change[0][1])]+" Awal:"+((change[0][2] == null)||((change[0][2]).trim() == "") ? "kosong" : change[0][2])+" Jadi:"+change[0][3]);
                                  //trim() buat ngilangin whitelook characters
                                  //Menyimpan data dan menghitung waktunya
                                  ajax('../../../../../model/hot/demo/json/save.json', 'GET', JSON.stringify({data: change}), function (data) {
                                    autosaveNotification = setTimeout(function() {
                                      //exampleConsole.innerText ='Changes will be autosaved';
                                    }, 1000);
                                  });
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
                                },
              cells           : function (row, col, prop) {
                                  var cellProperties = {};

                                  if (row === 0 || col === 0) {
                                    cellProperties.readOnly = true; // make cell read-only
                                  }if (row === 2 || col === 2) {
                                    cellProperties.readOnly = true; // make cell read-only
                                  }if (row === 1 || col === 1) {
                                    cellProperties.readOnly = true; // make cell read-only
                                  }if (col === 3) {
                                    cellProperties.readOnly = true; // make cell read-only
                                  }if (col === 4) {
                                    cellProperties.readOnly = true; // make cell read-only
                                  }if (col === 5) {
                                    cellProperties.readOnly = true; // make cell read-only
                                  }if (row ===0 ){                
                                    cellProperties.renderer = headerRowRenderer; // uses function directly
                                  }if (row ===1 ){                
                                    cellProperties.renderer = headerRowRenderer; // uses function directly
                                  }if (row ===2 ){                
                                    cellProperties.renderer = headerRowRenderer; // uses function directly
                                  }
                                  return cellProperties;
                                }
            });
            
            function ajax(url, method, params, callback) {
              var obj;

              try {
                obj = new XMLHttpRequest();
              } catch (e) {
                try {
                  obj = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                  try {
                    obj = new ActiveXObject("Microsoft.XMLHTTP");
                  } catch (e) {
                    alert("Your browser does not support Ajax.");
                    return false;
                  }
                }
              }
              obj.onreadystatechange = function () {
                if (obj.readyState == 4) {
                  callback(obj);
                }
              };
              obj.open(method, url, true);
              obj.setRequestHeader("X-Requested-With", "XMLHttpRequest");
              obj.setRequestHeader("Content-type","application/x-www-form-urlencoded");
              obj.send(params);

              return obj;
            }
          </script>
        </div>

      </div>

    </div>

  </div>
  
</div>
	</div>
</div>
<div class="col-sm-1 col-md-1">
</div>
<div class="row" style="margin-top: 420px; margin-bottom: -358px; position: fixed; right: 0; left: 0; bottom: 0; background: #2980b9; line-height: 67%">
	<div class="th-box no-border transparent text-center">
		<a class="btn btn-info btn-lg">Save</a>
		&nbsp; &nbsp; &nbsp; &nbsp;
		<a class="btn btn-info btn-lg">Save</a>
		&nbsp; &nbsp; &nbsp; &nbsp;
		<a class="btn btn-info btn-lg">Save</a>
	</div>
</div>

