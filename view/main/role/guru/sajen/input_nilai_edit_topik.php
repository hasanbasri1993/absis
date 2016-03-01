<?php
if (isset($_POST['topik_id']) && isset($_POST['topik_nama']) && isset($_POST['edit_uts']) && isset($_POST['topik_singkatan'])){
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');
	$get_topik_id = $_POST['topik_id'];
	$get_topik_nama = $_POST['topik_nama'];
	$get_topik_singkatan = $_POST['topik_singkatan'];
	$get_edit_uts = $_POST['edit_uts'];
	$a = "";
	$b = "";
	if ($get_edit_uts == "sebelum") {
		$a = "checked";
	} else {
		$b = "checked";
	}
	?>
	<div class="col-md-2">
	</div>
	<div class="col-md-8">
		<div class="form-group">
			<label>Nama Topik</label>
			<input name="topik_id" id="topik_id" class="topik_id" topik-id="<?php echo "$get_topik_id";?>" type="hidden" value="<?php echo "$get_topik_id";?>" class="form-control" >
			<input name="topik" type="text" value="<?php echo "$get_topik_nama";?>" class="form-control" required>
			<p class="help-block"></p>
		</div>
		<div class="form-group">
			<label>Nama Topik Singkatan (10 Karakter)</label>
			<input name="topik_singkat" type="text" value="<?php echo "$get_topik_singkatan";?>" class="form-control " maxlength="10" required>
			<p class="help-block">Ini digunakan hanya untuk memudahkan pengunaan excel</p>
		</div>
		<p>Pilihan Tambah Topik</p>
		<div class="radio">
			<label>
				<input type="radio" value="sebelum" class="i-grey-square edit_UTS" name="UTS" <?php echo "$a";?>>
				Sebelum UTS
			</label>
		</div>
		<div class="radio">
			<label>
				<input type="radio" value="setelah" class="i-grey-square edit_UTS" name="UTS" <?php echo "$b";?>>
				Setelah UTS
			</label>
		</div>			
	</div>
	<div class="col-md-2">
	</div>
	<?php
} else {
	echo "not found bro...";
}
?>