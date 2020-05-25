
<?php
	$profile_data = $db();
	$info = $profile_data['profile']['user'];
	// debug($info);
?>

<section class="content" style="padding-top: 20px;">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<div class="card card-success card-outline">
					<div class="card-tools" style="position:absolute;top:0;left:5px;">
						<span class="badge badge-secondary" data-toggle="modal" data-target="#modal-default" style="cursor:pointer;"><i class="far fa-edit"></i> Edit</span>
					</div>
					<img src="<?php check_file_and_render($info['banner'], '1080x200?text=Banner');?>" width="100%" height="150px" alt="">
					<div class="card-body box-profile">
						<div class="text-center" style="margin-top: -75px;">
							<img class="profile-user-img img-fluid img-circle" src="<?php check_file_and_render($info['photo'], '128x128?text=Photo');?>" alt="User profile picture">
						</div>
						<h3 class="profile-username text-center"><?php echo ucwords(get_fullname($current_profile));?></h3>
					</div>
					<!-- /.card-body -->
				</div>

				<div class="row products">

					<!-- LOOP HERE -->
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="slider-item product-item">
							<a href="#">
								<div class="card">
									<div class="card-header">
										<img src="assets/images/props/tomatoes.jpg" class="img-fit" alt="">
										<div class="card-tools">
											<span class="badge badge-primary"><i class="fas fa-map-marker-alt"></i> 1.3KM</span>
										</div>
									</div>
									<div class="card-body text-ellipsis">
										<h5><b>Cherry Tomatoes</b></h5>
										<h4 class="zero-gap"><span class="currency">₱</span>100<small style="font-size:50%;color:#aaa !important;"> / kg</small></h4>
									</div>
								</div>
							</a>
						</div>
					</div>
					<!-- LOOP HERE -->
				</div>
			</div>

			<div class="col-lg-4 col-md-4 col-sm-12 hidden-xs">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">About <?php echo $info['first_name']."'s"; ?> farm</h3>
						<div class="card-tools">
							<a href="settings" class="badge badge-default"><i class="far fa-edit"></i> Edit</a>
						</div>
					</div>
					<?php
						$locations = $profile_data['profile']['user_location'];
						// debug($locations);
					?>
					<!-- /.card-header -->
					<div class="card-body">
						<?php foreach ($locations as $key => $row): ?>
							<div>
								<strong><i class="fas fa-map-marker-alt mr-1"></i> Farm #<?php echo $key+1;?> <?php echo ucwords($row['farm_name']);?></strong>
								<p class="text-muted"><?php echo $row['address'];?></p>
							</div>
							<hr>
						<?php endforeach ?>
						<div>
							<strong><i class="fas fa-store-alt mr-1"></i> About</strong>
							<p class="text-muted"><?php echo $info['about'];?></p>
						</div>
					</div>
					<!-- /.card-body -->
				</div>
			</div>
		</div>
	</div>
</section>


<div class="modal fade" id="modal-default">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="/dashboard/my_farm/<?php echo $info['id'];?>" method="post" class="form-validate" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label for="banner_photo">Banner</label>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="banner_photo" name="user[banner]">
								<label class="custom-file-label" for="banner_photo">Choose file</label>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="user_photo">Profile</label>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="user_photo" name="user[photo]">
								<label class="custom-file-label" for="user_photo">Choose file</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Upload</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>