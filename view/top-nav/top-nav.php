<?php require_once "model/class/master.php"; ?>
<div class="top-navbar info-color" style="background: #3498db">
	<div class="top-navbar-inner">
		<div class="logo-brand" style="background: #3498db;">
			<a href="?p=home"><img src="assets/img/absis-logo2-blue.png" alt="ABSIS logo" style="margin-top:13px"></a>
		</div>
		<div class="top-nav-content">
			<div class="btn-collapse-sidebar-left-2 inline-popups" id="notif" data-toggle="modal" data-target="#ModalNotif">
				<i class="fa fa-spin  fa-circle-o-notch"></i>				
			</div>
			<div class="btn-collapse-sidebar-right inline-popups" style="background:#e9573f;width:60px;padding-top: 0px;padding-bottom: 0px;">
				<div class="modal fade" id="ModalKeluar" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog" style="margin-top: 15%;">
						<div class="modal-content">
							<div class="modal-header bg-danger no-border">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Konfirmasi Keluar</h4>
							</div>
							<div class="modal-body"style="color: rgba(1,1,1,0.6);">
								<h3 class="text-center">Apakah Anda Ingin Keluar?</h3>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
								<button type="button" class="btn btn-danger logout-all" >Keluar</button>								
							</div>
						</div>
					</div>
				</div>
				<button id="logout" class="btn btn-danger btn-block" data-toggle="modal" data-target="#ModalKeluar" style="background:#e9573f;width:60px;border-top-width: 0px;border-right-width: 0px;padding-top: 20px;padding-left: 0px;padding-right: 0px;padding-bottom: 20px;border-bottom-width: 0px;border-left-width: 0px;">Keluar</button>
			</div>
			<div class="btn-collapse-nav" data-toggle="collapse" data-target="#main-fixed-nav">
				<a class="btn btn-info btn-square" style="border-width: 0px; padding: 22px 12px 22px 12px;width:60px;margin-top: -17px;margin-left: -11px; box-sizing: border-box;">
				<i class="fa fa-calendar icon-calendar"></i>
				</a>
			</div>
			<ul class="nav-user navbar-right">
				<li class="dropdown">
					<a href="" class="dropdown-toggle" data-toggle="dropdown" style="display:inline-flex; cursor:default">
						<div style="float:left;margin-top:-10px;margin-right:10px;text-align:right;font-size:14px">
							<strong><?php 
							$guru=new Guru($_SESSION['username']);
							$nama_guru=$guru->getNama();
							$_SESSION['nama'] = $nama_guru;
							echo $nama_guru;?></strong><br>
							<?php echo $_SESSION['role'];?>
						</div>
						<div style="float:right">
						</div>
					</a>
				</li>
			</ul>
			<div class="collapse navbar-collapse">
				<div class="navbar-form navbar-left" role="search">
					<div class="btn-group inline-popups">
						<button class="btn" style="background: rgb(247,249,250); color:#444;" disabled>
						TA: <strong>
								<?php 
								$ta = $_SESSION['TA']; 
								$ta_2 = $ta+1; 
								echo "$ta/$ta_2";
								?>
							</strong> 
							&nbsp;&nbsp; 
							SMT: 
							<strong>
								<?php 
								echo 
								$_SESSION['semester']
								?>
							</strong>
						</button>
						<button class="btn btn-success" data-toggle="modal" data-target="#ModalTA">
						<strong>Ganti</strong>
						</button>
					</div>
				</div>
			</div>
			<div class="modal fade" id="ModalTA" tabindex="-1" role="dialog" aria-hidden="false">
					<div class="modal-dialog transparent" style="margin-top: 10%;">
						<div class="modal-content">							
							<div class="modal-body"style="color: rgba(1,1,1,0.6);">
								<div class="row">
									<div class="col-md-12">
										<!-- <h3 class="text-center">
											Pilih Tahun Ajaran / Semester
										</h3> -->
										<br />										
											<?php											
											$get_ta = $dbo->prepare("SELECT * FROM data_ta ORDER BY tahun_ajaran ASC");
											if ($get_ta->execute()){

											    $row_get_ta = $get_ta -> fetchAll();
											    $count_row_get_ta = sizeof($row_get_ta);
											    $i = 0;
											    while($i < $count_row_get_ta){
											    	$show_ta = $row_get_ta[$i]['tahun_ajaran'];
											    	$show_semester = $row_get_ta[$i]['semester'];
											    	$show_edit_status_1 = $row_get_ta[$i]['edit_status_1'];
											    	$show_edit_status_2 = $row_get_ta[$i]['edit_status_2'];
											    	?>
													<div class='the-box bg-info no-border'>											
														<div class='row'>
															<div class='col-md-4 text-center'>
																<h4>
																	<strong>														
																		<?php 
																		$ta = $show_ta; 
																		$ta_2 = $ta+1; 
																		echo "$ta / $ta_2";
																		?>														
																	</strong>
																</h4>
															</div>
															<div class='col-md-8 text-right'>
																<?php
																if ($show_edit_status_1 == "1"){
																	$a = "<i class='fa fa-unlock-alt'></i>";
																	$x = "info";
																	$t1 = "";
																	// $state1 = "";
																} else {
																	$a = "<i class='fa fa-lock'> </i>";
																	$x = "warning";
																	$t1 = "data-toggle='tooltip' title='Hanya Dapat Dilihat'";
																	// $state1 = "disabled";
																}

																if ($show_edit_status_2 == "1"){
																	$b = "<i class='fa fa-unlock-alt'></i>";
																	$y = "info";
																	$t2 = "";
																	// $state2 = "";																	
																} else {
																	$b = "<i class='fa fa-lock'> </i>";
																	$y = "warning";
																	$t2 = "data-toggle='tooltip' title='Hanya Dapat Dilihat'";
																	// $state2 = "disabled";
																}
																$req_url = $_SERVER['REQUEST_URI'];
																?>
																<div class="btn-group">
																	<a href="?sajen=ganti_ta&url=<?php echo $req_url;?>&ta=<?php echo $show_ta;?>&semester=1" class='btn btn-<?php echo $x;?>' style='font-size: 1.15em; color:#fff;' <?php echo $t1; ?> >
																		<?php echo $a;?>Semester 1
																	</a>
																	<a href="?sajen=ganti_ta&url=<?php echo $req_url;?>&ta=<?php echo $show_ta;?>&semester=2" class='btn btn-<?php echo $y;?>' style='font-size: 1.15em; color:#fff;' <?php echo $t2; ?> >
																		<?php echo $b;?>Semester 2
	 																</a>
	 																<?php 
	 																if ($_SESSION['role'] == "admin") {
	 																?>
		 																<a href='#' class='btn btn-default edit-ta' style='font-size: 1.15em; color:#222;' ta='<?php echo $ta;?>' st='<?php echo $show_edit_status_1;?>' nd='<?php echo $show_edit_status_2;?>' data-dismiss='modal'>
																			Edit
		 																</a>
	 																<?php
	 																}
	 																?>
	 															</div>	 															
															</div>
														</div>
													</div>
													<?php
											    	$i++;
											    }
											}
											?>
									</div>
								</div>	
							</div>							
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
<?php 
if ($_SESSION['role'] == "admin") {
	?>
	<div class="modal fade" id="ModalEditTA" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" style="margin-top: 10%;">
			<div class="modal-content">
				<div class="modal-header bg-info no-border">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title text-center">Edit Tahun Ajaran <span class="show-ta-title"><span></h3>
				</div>
				<div class="modal-body"style="color: rgba(1,1,1,0.6);">
					<form class="ta-data" method="POST" action="?sajen=edit_ta" >
						<input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI'];?>">
						<input type="hidden" name="ta" value="<?php echo $ta;?>">
						<div class="row">
							<div class="col-md-6 col-sm-3">
								<div class="the-box no-border bg-info sem1" style="margin-bottom: 0px;">
									<h4 class="text-center">
										Semester 1
									</h4>
									<div class="radio">
										<label>
											<input type="radio" value="boleh" class="i-grey-square icheck-ta aaa" sem="sem1" name="1">
											Boleh Edit
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" value="tidakboleh" class="i-grey-square icheck-ta bbb" sem="sem1" name="1">
											Tidak Boleh Edit
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-3">
								<div class="the-box no-border bg-info sem2">
									<h4 class="text-center">
										Semester 2
									</h4>
									<div class="radio">
										<label>
											<input type="radio" value="boleh" class="i-grey-square icheck-ta ccc" sem="sem2" name="2">
											Boleh Edit
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" value="tidakboleh" class="i-grey-square icheck-ta ddd" sem="sem2" name="2">
											Tidak Boleh Edit
										</label>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
					<button type="button" class="btn btn-info save-ta"> Simpan </button>								
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>
<div class="modal fade" id="ModalLockScreen" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 15%;">
		<div class="modal-content">
			<div class="modal-header bg-info no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center">Lock Screen</h3>
			</div>
			<div class="modal-body"style="color: rgba(1,1,1,0.6);">
				<h4 class="text-center">Lock Screen Hanya Bertahan Hingga</h4>
				<h3 class="text-center">30 menit kedepan</h3>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
				<button type="button" class="btn btn-info lockscreen"> Lock Screen </button>								
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="ModalPassword" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 8%;">
		<div class="modal-content">
			<div class="modal-header bg-info no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title text-center">Ganti Password</h3>
			</div>
			<div class="modal-body"style="color: rgba(1,1,1,0.6);">
				<div class="row">
					<div class="col-md-2">
					</div>
					<div class="col-md-8">
						<div class="form-group">
							<label>Password Lama</label>
							<input type="password" class="current-password form-control bold-border " placeholder="Masukkan password lama">
						</div>
						<hr>
						<div class="form-group">
							<label>Password Baru</label>
							<input type="password" class="pass1 form-control bold-border" placeholder="Masukkan password baru">
						</div>
						<div class="form-group">
							<label>Masukkan Lagi Password Baru</label>
							<input type="password" class="pass2 form-control bold-border" placeholder="Masukkan lagi password baru">
						</div>
					</div>					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"> Batal </button>
				<button type="button" class="btn btn-info ganti-password-act" data-dismiss="modal"> Simpan </button>								
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalNotif" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin-top: 20vh;">
		<div class="modal-content">
			<div class="modal-header bg-info no-border">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title text-center">Aplikasi Akademik SMPN 1 Semarang</h4>
			</div>
			<div class="modal-body"style="color: rgba(1,1,1,0.6); max-height: 60vh;">
				<div-- class="row">
					<div class="col-md-4 col-sm-4 col-xs-6 text-center">
						<a href="?p=home">
							<i class="glyphicon glyphicon-home icon-circle icon-lg icon-info"></i>
						</a>
						<h4>
							Home
						</h4>
					</div>					
					<div class="col-md-4 col-sm-4 col-xs-6 text-center">
						<a href="#" data-dismiss="modal" id="password-side">
							<i class="fa fa-lock icon-circle icon-lg icon-warning"></i>
						</a>
						<h4>
							Password
						</h4>						
					</div>
					<!--div class="col-md-4 col-sm-4 col-xs-6 text-center">
						<a href="#" data-dismiss="modal" id="lockscreen-side">
							<i class="glyphicon glyphicon-time icon-circle icon-lg icon-success"></i>
						</a>
						<h4>
							Lock Screen
						</h4>
					</div-->
					<div class="col-md-4 col-sm-4 col-xs-6 text-center">
						<a href="#" data-dismiss="modal" id="logout-side">
							<i class="glyphicon glyphicon-off icon-circle icon-lg icon-danger"></i>
						</a>
						<h4>
							Logout
						</h4>
					</div>
				</div>	
				
				<button id="password" data-toggle="modal" data-target="#ModalPassword" style="visibility:hidden;">Keluar</button>
				<button id="lockscreen" data-toggle="modal" data-target="#ModalLockScreen" style="visibility:hidden;">LockScreen</button>
				<button id="editTA" data-toggle="modal" data-target="#ModalEditTA" style="visibility:hidden;">EditTA</button>
			
 				<div class="row">
					<div class="the-box transparent no-border" style="margin-bottom: 0px;">
						<div class="row">
							<div class="col-md-12 col-sm-6">
								<div class="alert alert-info alert-bold-border square fade in alert-dismissable" style="margin-bottom: 5px; background: rgb(247,249,250)">
								<i class="fa fa-info icon-circle icon-xs icon-info"></i>
								<strong>&nbsp; Untuk Menampilkan Menu Ini</strong> Tekan &nbsp; <i class="fa fa-spin fa-circle-o-notch icon-circle icon-xs icon-info"></i> &nbsp; di Bagian Atas Kiri								
								</div>
							</div>
							<div class="col-md-12 col-sm-6">
								<div class="alert alert-info alert-bold-border square fade in alert-dismissable" style="margin-bottom: 5px; background: rgb(247,249,250)">
								<i class="fa fa-info icon-circle icon-xs icon-info"></i>
								<strong>&nbsp; Anda Akan Otomatis Keluar</strong> Setelah 5 Menit Tanpa Aktivitas								
								</div>
							</div>
							<div class="col-md-12 col-sm-6">
								<div class="alert alert-info alert-bold-border square fade in alert-dismissable" style="margin-bottom: 5px; background: rgb(247,249,250)">
								<i class="fa fa-info icon-circle icon-xs icon-info"></i>
								<strong>&nbsp; Anda Akan Diperingatkan</strong> Jika Anda Offline								
								</div>
							</div>
						</div>						
					</div>
				</div>		 	
			</div>
		</div>
	</div>
</div>