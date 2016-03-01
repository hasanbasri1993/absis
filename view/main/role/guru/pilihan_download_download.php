<style>
body.tooltips{
	overflow-y: hidden !important; 
}
</style>
<div class="row">
  	<div style="float:left;padding-left:2%;position:fixed" class="col-md-3">
  		<br />
  		<h4 class="bolded">Cetak Dokumen PDF</h4>
  		<form role="form" target="preview">
  			<input type="hidden" name="sajen" value="pilihan_download_pdf_proses">
  			<input type="hidden" name="state" value="pdf">
	  		<table style="width:100%">
	  			<tr>
	  				<td style="width:30%">Dokumen</td>
	  				<td colspan="2">
	  					<select name="tipe" class="form-control select-tipe" id="select_tipe" onchange>
	  						<?php
	  						$get_tipe = $_GET['tipe'];
	  						$get_state = $_GET['state'];
	  						//absesni
	  						//pdf
	  						if ($get_tipe == "absensi"){
	  							$a = "selected";
	  						} else {
	  							$a = "";
	  						}
	  						if ($get_tipe == "uts"){
	  							$b = "selected";
	  						} else {
	  							$b = "";
	  						}
	  						if ($get_tipe == "uas"){
	  							$c = "selected";
	  						} else {
	  							$c = "";
	  						}
	  						if ($get_tipe == "ukk"){
	  							$d = "selected";
	  						} else {
	  							$d = "";
	  						}
	  						if ($get_tipe == "buku_induk"){
	  							$e = "selected";
	  						} else {
	  							$e = "";
	  						}	  						
	  						?>
							<option>Pilih</option>	  						
							<option value="absensi" <?php echo $a;?>>Absensi</option>
							<option value="uts" <?php echo $b;?>>Rapor UTS</option>
							<option value="uas" <?php echo $c;?>>Rapor UAS</option>
							<option value="ukk" <?php echo $d;?>>Rapor Kenaikan Kelas</option>
							<option value="buku_induk" <?php echo $e;?>>Buku Induk Siswa</option>
						</select>
					</td>
					<td>
					</td>
	  			</tr>
	  			<tr>
	  				<td>Kelas</td>
	  				<td>
	  					<select name="kelas" class="form-control select-kelas" id="select_kelas"> 
	  						<option>Kelas</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
						</select>
					</td>
					<td>
						<select name="subkelas" class="form-control select-subkelas" id="select_subkelas">
							<option>Sub Kelas</option>
							<option value="all">Semua</option>
							<?php
							$length = range('A', 'I');
							foreach ($length as $kelas){
								echo "<option value='" . $kelas . "'>" . $kelas ."</option>";
							}
							?>
						</select>
					</td>
	  			</tr>
	  			<tr>
	  				<td> &nbsp;</td>
	  			</tr>
	  			<tr>
	  				<td>
	  				</td>
	  				<td colspan="2" style="text-align:right">
	  					<a class="btn btn-danger" href="?p=pilihan_download">
	  						Kembali
	  					</a>
	  				</td>
	  			</tr>
	  		</table>
		</form>

		<hr>
		<form target="_blank">
			<table style="width:100%;">
				<tr>
					<td style="text-align:center;">
						<a class="btn btn-info" disabled href="" id="tbl_1">Simpan sebagai PDF</a><br /> &nbsp; <br />
						<a class="btn btn-info" disabled href="" id="tbl_2" target="_blank">Simpan sebagai Excel</a><br />  &nbsp; <br />
					</td>
				</tr>
			</table>
		</form>
  	</div>
  	<div style="float:right; padding-left: 0px;padding-right: 0px;" class="col-md-9" >
  		<div class="the-box no-border full" style="padding-right: 4px;">
  			<?php
  			$_GET['kelas'] = "";
  			$subkelas = "";
  			if (isset($_GET['kelas'])){
  				$_GET['kelas'] = $_GET['kelas'];
  			}
  			if (isset($_GET['subkelas'])){
  				$subkelas = $_GET['subkelas'];
  			}
  			if (isset($_GET['tipe'])){
  				$tipe = $_GET['tipe'];
  			}
  			?>
	  		<iframe id="preview" name="preview" src="?sajen=pilihan_download_pdf_proses&tipe=<?php echo $tipe;?>&kelas=<?php echo $_GET['kelas']; ?>&subkelas=<?php echo $subkelas; ?>" scrolling="yes" style="height:85.5vh;" >
	  		</iframe>
	  	</div>
  	</div>
</div>