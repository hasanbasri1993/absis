<div class="row">
	<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3" id="7">
		<div class="the-box bg-danger no-border card-info text-center" style="z-index: 0">
			<h4><br></h4>
			<h1><i class="fa fa-bank icon-square icon-lg icon-danger"></i></h1>
			<h1>KELAS 7</h1>
			<p> &nbsp; </p>
		</div>
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">
		<?php

		$range = range('A', 'I');
		foreach ($range as $kelas) {
		?>
		<div class="the-box no-border">
			<form method="GET" action="">
				<div class="media user-card-sm">
					<a class="pull-left">
						<i class="fa icon-square icon-md icon-danger">
							<p style="font-family: lato;"><?php echo $kelas;?></p>
						</i>
						<input type="hidden" value="akademik_penempatan_siswa" id="a" name="p">
						<input type="hidden" value="<?php echo "7".$kelas;?>" id="kelas" name="kelas">
						<input type="hidden" value="atur" id="state" name="state">
					</a>
					<div class="right-button">											
						<button class="btn btn-info" type="submit">Atur Kelas <i class="fa fa-chevron-right "></i></button>
					</div>
				</div>
			</form>
		</div>
		<?php
		}
		?>						
	</div>
</div>
<br />
<div class="row">
	<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3" id="7">
		<div class="the-box bg-warning no-border card-info text-center" style="z-index: 0">
			<h4><br></h4>
			<h1><i class="fa fa-bank icon-square icon-lg icon-warning"></i></h1>
			<h1>KELAS 8</h1>
			<p>&nbsp; </p>
		</div>
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">
		<?php

		$range = range('A', 'I');
		foreach ($range as $kelas) {
		?>
		<div class="the-box no-border">
			<form method="GET" action="">
				<div class="media user-card-sm">
					<a class="pull-left">
						<i class="fa icon-square icon-md icon-warning">
							<p style="font-family: lato;"><?php echo $kelas;?></p>
						</i>
						<input type="hidden" value="akademik_penempatan_siswa" id="a" name="p">
						<input type="hidden" value="<?php echo "8".$kelas;?>" id="kelas" name="kelas">
						<input type="hidden" value="atur" id="state" name="state">
					</a>
					<div class="right-button">											
						<button class="btn btn-info" type="submit">Atur Kelas <i class="fa fa-chevron-right "></i></button>
					</div>
				</div>
			</form>
		</div>
		<?php
		}
		?>						
	</div>
</div>
<br />
<div class="row">
	<div class="col-sm-1 col-md-3 col-md-2 col-lg-3">
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3" id="7">
		<div class="the-box bg-success no-border card-info text-center" style="z-index: 0">
			<h4><br></h4>
			<h1><i class="fa fa-bank icon-square icon-lg icon-success"></i></h1>
			<h1>KELAS 9</h1>
			<p>&nbsp; </p>
		</div>
	</div>
	<div class="col-sm-5 col-md-4 col-lg-3">
		<?php

		$range = range('A', 'I');
		foreach ($range as $kelas) {
		?>
		<div class="the-box no-border">
			<form method="GET" action="">
				<div class="media user-card-sm">
					<a class="pull-left">
						<i class="fa icon-square icon-md icon-success">
							<p style="font-family: lato;"><?php echo $kelas;?></p>
						</i>
						<input type="hidden" value="akademik_penempatan_siswa" id="a" name="p">
						<input type="hidden" value="<?php echo "9".$kelas;?>" id="kelas" name="kelas">
						<input type="hidden" value="atur" id="state" name="state">
					</a>
					<div class="right-button">											
						<button class="btn btn-info" type="submit">Atur Kelas <i class="fa fa-chevron-right "></i></button>
					</div>
				</div>
			</form>
		</div>
		<?php
		}
		?>							
	</div>
</div>