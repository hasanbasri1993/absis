<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <title>TEST</title>

  <!--
  Loading Handsontable (full distribution that includes all dependencies)
  -->
  <link data-jsfiddle="common" rel="stylesheet" media="screen" href="hot/dist/handsontable.full.css">
  <script data-jsfiddle="common" src="hot/dist/handsontable.full.js"></script>


</head>

<body>


<div class="wrapper">
  <div class="wrapper-row">

    <div id="container">
      <div class="columnLayout">        

        <br>
        <br>
        <div class="handsontable" id="tb_new" style="width: 1400px; height: 300px; overflow: hidden" ></div>
	        <script type="text/javascript" data-jsfiddle="tb_new">
	            var myData = Handsontable.helper.createSpreadsheetData(100, 20),
	              container = document.getElementById('tb_new'),
	              positions = document.getElementById('positions'),
	              hot;

	            data_topik=[['Aljabar',10],['Eksponen',14],['Logaritma',13],['Logika',24],['Aritmatika',99],['HADGajhdbs',99]]; // Data Topik dan id-topik

	            // ARRAY UNTUK HEADER TABEL
	            data_header=[
	            	['', 'NIS', 'NAMA', 'NILAI AKHIR'	,'x'	,'KKM'	,'UJIAN','x'	],
	                ['No', 'x'	, 'x'	, 'x'			,'x'	,'x'	,'x'	,'x'	],
	                ['', 'x'	, 'x'	, 'UTS'			,'UAS'	,'x'	,'UTS'	,'UAS'	]
	            ];
	            // INPUT TOPIK KE data_header
	            var c = 5;
	            for (i=0;i < data_topik.length; i++){
	            	c = c+3;
	            	data_header[0][c]= 'TOPIK';data_header[0][c+1]= 'TOPIK';data_header[0][c+2]= 'TOPIK';
	            	data_header[1][c]= data_topik[i][0];data_header[1][c+1]= 'x';data_header[1][c+2]= 'x';
	            	data_header[2][c]= 'UT';data_header[2][c+1]= 'UL';data_header[2][c+2]= 'T';
	            };
	            // END ARRAY UNTUK HEADER TABEL

	            
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



	            // ARRAY UNTUK NAMA & NILAI TIAP TOPIK
	            data_nilai=[            
	            ];

	            //PENGULANGAN SISWA DAN NILAI
	            for (i = 0; i < 1000; i++) {
	            	data_nilai.push([i+1, 21202060+i, 'Sudirman Sukijan Sucirman', 90, 87, , , , ]);
				};


	            datax = data_header.concat(data_nilai), container = document.getElementById('tb_new'),hot;

	            function headerRowRenderer(instance, td, row, col, prop, value, cellProperties) {
				    Handsontable.renderers.TextRenderer.apply(this, arguments);
				    td.style.fontWeight = 'bold';
				    td.style.color = 'black';
				    td.style.background = '#ecf0f1';
				}

	          	function greyRenderer(instance, td, row, col, prop, value, cellProperties) {
				  	Handsontable.renderers.TextRenderer.apply(this, arguments);
				  	td.style.color = 'black';
				}


	            hot = new Handsontable(container, {
	              data: datax,
	              colWidths: [50, 100, 300, 50, 50, 50, 50, 50, 50, 50, 50, 50],
	              rowHeaders: false,
	              colHeaders: false,
	              fixedRowsTop: 3,
	              fixedColumnsLeft: 3,
	              contextMenu: true,
	              mergeCells: data_merge,
	              className: "htCenter htMiddle",
	              cells: function (row, col, prop) {
				      var cellProperties = {};

				      if (row === 0 || col === 0) {
				        cellProperties.readOnly = true; // make cell read-only
				        cellProperties.renderer = greyRenderer;
				      }if (row === 2 || col === 2) {
				        cellProperties.readOnly = true; // make cell read-only
				        cellProperties.renderer = greyRenderer;
				      }if (row === 1 || col === 1) {
				        cellProperties.readOnly = true; // make cell read-only
				        cellProperties.renderer = greyRenderer;
				      }if (col === 3) {
				        cellProperties.readOnly = true; // make cell read-only
				        cellProperties.renderer = greyRenderer;
				      }if (col === 4) {
				        cellProperties.readOnly = true; // make cell read-only
				        cellProperties.renderer = greyRenderer;
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


	        </script>
        </div>

      </div>

    </div>

  </div>
  
</div>


</body>
</html>
