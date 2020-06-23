<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-lg-12">
				<h3 class="m-0 text-dark">Settings</h3>
			</div>
		</div>
	</div>
</section>
<?php
	$profile_data = $db();
	// debug($profile_data);
	$info = $profile_data['profile']['user'];
?>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">Farm Locations</h3>
					</div>
					<?php
						$locations = $profile_data['profile']['user_location'];
						// debug($locations);
					?>
					<form role="form" class="form-validate" action="dashboard/settings/<?php echo $info['id'];?>" method="post">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-6">
									<?php foreach ($locations as $key => $row): ?>
										<?php
										$latlng = '';
										if ($row['lat'] != '' AND $row['lng'] != '') {
											$latlng = json_encode(['lat'=>$row['lat'], 'lng'=>$row['lng']]);
										}
										?>
										<div class="row location-panel" <?php echo $key == 0 ? 'id="farm-location-template"' : '';?> data-index="<?php echo $key;?>">
											<input type="hidden" data-name="id" name="user_location[<?php echo $key;?>][id]" value="<?php echo $row['id'];?>" />
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<?php if ($key == 0): ?><label class="d-none d-sm-block">Farm name</label><?php endif ?>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<label for="farm_name<?php echo $key;?>" class="input-group-text"><i class="fas fa-seedling"></i></label>
													</div>
													<input type="text" id="farm_name<?php echo $key;?>" class="form-control" data-name="farm_name" name="user_location[<?php echo $key;?>][farm_name]" value="<?php echo $row['farm_name'];?>">
												</div>
											</div>
											<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
												<?php if ($key == 0): ?><label class="d-none d-sm-block">Location</label><?php endif ?>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<label for="farm_location<?php echo $key;?>" class="input-group-text"><i class="fas fa-map-marker-alt"></i></label>
													</div>
													<input type="text" id="farm_location<?php echo $key;?>" class="address form-control" data-name="address" name="user_location[<?php echo $key;?>][address]" required="required" value="<?php echo $row['address'];?>" />
												</div>
											</div>
											<input type="hidden" class="latlng" data-name="latlng" name="user_location[<?php echo $key;?>][latlng]" value='<?php echo $latlng;?>' />
										</div>
									<?php endforeach ?>
								</div>

								<div class="col-lg-6">
									<div id="map-box" style="width: 100%; height: 425px; margin-bottom: 15px;">
										<img src="http://placehold.it/565x225?text=Map" width="100%">
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button type="button" class="btn btn-primary new-farm" style="margin-right:10px;">Add farm</button>
							<button type="submit" class="btn btn-default">Save</button>
						</div>
					</form>
				</div>
			</div>

			<!-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="card card-success card-outline">
					<div class="card-header">
						<h3 class="card-title">Farm Map</h3>
					</div>
					<div class="card-body">
						<div id="map-box" style="width: 100%; height: 425px; margin-bottom: 15px;">
							<img src="http://placehold.it/565x225?text=Map" width="100%">
						</div>
					</div>
				</div>
			</div> -->

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="card card-success card-outline">
					<div class="card-header">
						<h3 class="card-title">About</h3>
					</div>
					<form role="form" class="form-validate" action="dashboard/settings/<?php echo $info['id'];?>" method="post">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>Farm history</label>
										<?php if ($info['about']) $height = 'style="height: 132px;"'; ?>
										<textarea class="form-control" rows="3" required="required" name="user[about]" <?php echo isset($height) ? $height : '' ?>><?php echo $info['about'];?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-default">Save</button>
						</div>
					</form>
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title">My Farm - Photos</h3>
					</div>
					<form role="form" action="/dashboard/settings/<?php echo $info['id'];?>" method="post" class="form-validate" enctype="multipart/form-data">
						<div class="card-body">
							<div class="form-group">
								<label for="banner_photo">Banner</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="banner_photo" name="user[banner]" required="required">
										<label class="custom-file-label" for="banner_photo">Choose file</label>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label for="user_photo">Profile</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="user_photo" name="user[photo]" required="required">
										<label class="custom-file-label" for="user_photo">Choose file</label>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-default">Upload</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- INFO WINDOW -->
	<div id="info-window" style="position: fixed;">UI HERE!</div>
</section>