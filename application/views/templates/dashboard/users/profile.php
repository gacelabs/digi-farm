<?php
	$profile_data = $db();
	// debug($profile_data);
	$info = $profile_data['profile']['user'];
?>

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-lg-12">
				<h1>Profile</h1>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Profile</h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<form class="form-validate" action="dashboard/profile/<?php echo $info['id'];?>" method="post">
						<!-- <label>
							Farm name
							<input type="text" name="user[farm_name]" value="<?php echo $info['farm_name'];?>">
						</label> -->

						<div class="card-body">
							<div class="row">
								<div class="col-6 form-group">
									<label for="first_name">First Name</label>
									<input type="text"  class="form-control" id="first_name" name="user[first_name]" value="<?php echo $info['first_name'];?>">
								</div>
								<div class="col-6 form-group">
									<label for="last_name">Last Name</label>
									<input type="text"  class="form-control" id="last_name" name="user[last_name]" value="<?php echo $info['last_name'];?>">
								</div>

								<div class="col-6 form-group">
									<label for="email">Email</label>
									<input type="email" class="form-control"  id="email" name="user[email_address]" value="<?php echo $info['email_address'];?>">
								</div>

								<div class="col-6 form-group">
									<label>Status</label>
									<select class="form-control" name="user[activity_id]">
										<?php 
											$selected = $profile_data['profile_dropdown']['selected'];
											$select = $profile_data['profile_dropdown']['select'];
											foreach ($select as $id => $value): ?>

											<option<?php echo $selected == $id ? ' selected="selected"' : '';?> value="<?php echo $id;?>"><?php echo $value;?></option>

										<?php endforeach ?>
									</select>
								</div>
							</div>
						</div>
						<!-- /.card-body -->

						<div class="card-footer">
							<button type="submit" class="btn btn-default">Save</button>
						</div>
					</form>
				</div>
			</div>

			<div class="col-lg-6 col-md-6">
				<?php
					$settings = $profile_data['app_settings'];
					// debug($settings);
				?>
				<div class="card card-secondary">
					<div class="card-header">
						<h3 class="card-title">App Settings</h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->

					<form class="form-validate" action="dashboard/profile/<?php echo $info['id'];?>" method="post">
						<div class="card-body">
						<?php foreach ($settings as $id => $row): ?>
							<label>
								<?php if ($row['checkbox']): ?>
									<?php if ($row['value'] == 'checked'): ?>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="user_app_settings[<?php echo $id;?>][value]" checked="checked" value="1" />
										</div>
										<?php else: ?>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" name="user_app_settings[<?php echo $id;?>][value]" value="1" />
											</div>
										<?php endif ?>
								<?php else: ?>
									<?php echo $row['label'];?>
									<input type="text" name="user_app_settings[<?php echo $id;?>][value]" value="<?php echo $row['value'];?>" />
								<?php endif ?>
								<input type="hidden" name="user_app_settings[<?php echo $id;?>][checkbox]" value="<?php echo $row['checkbox'];?>" />
							</label>
						<?php endforeach ?>
						</div>
						<!-- /.card-body -->

						<div class="card-footer">
							<button type="submit" class="btn btn-default">Save</button>
						</div>
					</form>
				</div>
			</div>

			<div class="col-lg-6">
				<?php
				$locations = $profile_data['profile']['user_location'];
	// debug($locations);
				?>
				<!-- MULTIPLE TO KAYA DAPAT MATRON UI NG ADD ANOTHER -->
				<div class="card card-secondary">
					<div class="card-header">
						<h3 class="card-title">Farm Locations</h3>
					</div>
					<form class="form-validate" action="dashboard/profile/<?php echo $info['id'];?>" method="post">
						<div class="card-body">
							<?php foreach ($locations as $key => $row): ?>
								<?php
								$latlng = '';
								if ($row['lat'] != '' AND $row['lng'] != '') {
									$latlng = json_encode(['lat'=>$row['lat'], 'lng'=>$row['lng']]);
								}
								?>
								<div class="location-panel">
									<div class="map-box" style="width: 100%; height: 200pt;"></div>
									<input type="hidden" class="id" name="user_location[<?php echo $key;?>][id]" value="<?php echo $row['id'];?>" />
									<div class="col-6 form-group">
										<label for="address">Address</label>
										<input type="text" id="address" class="address form-control" name="user_location[<?php echo $key;?>][address]" required="required" value="<?php echo $row['address'];?>" />
									</div>
									<input type="hidden" class="latlng" name="user_location[<?php echo $key;?>][latlng]" value='<?php echo $latlng;?>' />
								</div>
							<?php endforeach ?>
						</div>

						<div class="card-footer">
							<button type="submit" class="btn btn-default">Save</button>
							<button class="btn btn-default pull-right">Add Location</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

