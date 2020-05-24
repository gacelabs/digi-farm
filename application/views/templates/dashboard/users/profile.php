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
									<input type="text"  class="form-control" id="first_name" name="user[first_name]" value="<?php echo $info['first_name'];?>" required="required">
								</div>
								<div class="col-6 form-group">
									<label for="last_name">Last Name</label>
									<input type="text"  class="form-control" id="last_name" name="user[last_name]" value="<?php echo $info['last_name'];?>" required="required">
								</div>

								<div class="col-6 form-group">
									<label for="email">Email</label>
									<input type="email" class="form-control" id="email" name="user[email_address]" value="<?php echo $info['email_address'];?>" required="required">
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

				<?php
					$settings = $profile_data['app_settings'];
					// debug($settings);
					$password_id = 0;
				?>
				<div class="card card-secondary">
					<div class="card-header">
						<h3 class="card-title">App Settings</h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<form class="form-validate" action="dashboard/profile/<?php echo $info['id'];?>" method="post">
						<div class="card-body">
							<div class="row">
							<?php foreach ($settings as $id => $row): ?>
								<?php 
								if ($row['name'] == 'password') {
									$password_id = $id;
									continue;
								}
								switch ($row['type']) {
									case '1': /*checkbox*/
									?>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" name="user_app_settings[<?php echo $id;?>][value]" <?php echo ($row['value'] == 'checked') ? 'checked="checked"' : '' ?> value="1" />
										</div>
									<?php
									break;
									case '2': /*radio*/
									?>
										<div class="custom-control custom-radio">
											<input type="radio" class="custom-control-input" name="user_app_settings[<?php echo $id;?>][value]" <?php echo ($row['value'] == 'checked') ? 'checked="checked"' : '' ?> value="1" />
										</div>
									<?php
									break;
									default: /*input*/
									?>
										<div class="col-6 form-group">
											<input type="text" class="form-control" name="user_app_settings[<?php echo $id;?>][value]" value="<?php echo $row['value'];?>" />
										</div>
										<div class="col-6 form-group">
											<?php echo $row['label'];?>
										</div>
									<?php
									break;
								}?>
								<input type="hidden" name="user_app_settings[<?php echo $id;?>][type]" value="<?php echo $row['type'];?>" />
							<?php endforeach ?>
							</div>
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
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">Farm Locations</h3>
					</div>
					<form class="form-validate" action="dashboard/profile/<?php echo $info['id'];?>" method="post">
						<div class="card-body">
							<div id="map-box" style="width: 100%; height: 200pt; margin-bottom: 15px;"></div>
							<?php foreach ($locations as $key => $row): ?>
								<?php
								$latlng = '';
								if ($row['lat'] != '' AND $row['lng'] != '') {
									$latlng = json_encode(['lat'=>$row['lat'], 'lng'=>$row['lng']]);
								}
								?>
								<div class="location-panel" <?php echo $key == 0 ? 'id="farm-location-template"' : '';?>>
									<div class="row">
										<input type="hidden" data-name="id" name="user_location[<?php echo $key;?>][id]" value="<?php echo $row['id'];?>" />
										<div class="col-6">
											<div class="form-group">
												<?php if ($key == 0): ?><label for="farm_name">Farm name</label><?php endif ?>
												<input type="text" id="farm_name" class="form-control" data-name="farm_name" name="user_location[<?php echo $key;?>][farm_name]" value="<?php echo $row['farm_name'];?>">
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<?php if ($key == 0): ?><label for="address">Address</label><?php endif ?>
												<input type="text" id="address" class="address form-control" data-name="address" name="user_location[<?php echo $key;?>][address]" value="<?php echo $row['address'];?>" />
											</div>
										</div>
										<input type="hidden" class="latlng" data-name="latlng" name="user_location[<?php echo $key;?>][latlng]" value='<?php echo $latlng;?>' />
									</div>
								</div>
							<?php endforeach ?>
						</div>

						<div class="card-footer">
							<button type="submit" class="btn btn-default">Save</button>
							<button type="button" class="btn btn-default pull-right new-farm">New farm</button>
						</div>
					</form>
				</div>

				<div class="card card-default">
					<div class="card-header">
						<h3 class="card-title">Password Reset</h3>
					</div>
					<!-- /.card-header -->
					<?php if (has_get('error')): ?>
						<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Error!</strong> <?php echo get_url_var('error');?>
						</div>
					<?php endif ?>
					<!-- form start -->
					<form class="form-validate" action="dashboard/profile/<?php echo $info['id'];?>" method="post">
						<div class="card-body">
							<div class="row">
								<div class="col-6 form-group">
									<label for="current_password">Current password</label>
									<input type="password" class="form-control" name="user_app_settings[<?php echo $password_id;?>][current_password]" id="current_password" value="" required="required">
								</div>
								<div class="col-6 form-group">
									<label for="new_password">New password</label>
									<input type="password" class="form-control" id="new_password" name="user_app_settings[<?php echo $password_id;?>][value]" value="" required="required">
								</div>
							</div>
						</div>
						<!-- /.card-body -->
						<div class="card-footer">
							<button type="submit" class="btn btn-danger">Reset</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- INFO WINDOW -->
	<div id="info-window">UI HERE!</div>
</section>

