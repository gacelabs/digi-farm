<?php
	$profile_data = $db();
	// debug($profile_data);
	$info = $profile_data['profile']['user'];
?>

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-lg-12">
				<h3 class="m-0 text-dark">Profile</h3>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<?php if (has_get('error')): ?>
			<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration: none;">&times;</a>
				<strong>Error!</strong> <?php echo get_url_var('error');?>
			</div>
		<?php endif ?>
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Profile</h3>
					</div>
					<form class="form-validate" action="profile/<?php echo $info['id'];?>" method="post">
						<div class="card-body">
							<div class="row">
								<div class="col-6 form-group">
									<label for="first_name">First name</label>
									<input type="text"  class="form-control" id="first_name" name="user[first_name]" value="<?php echo $info['first_name'];?>">
								</div>
								<div class="col-6 form-group">
									<label for="last_name">Last name</label>
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
												<?php if ($id == 1 OR $id == 2): ?>
													<option<?php echo $selected == $id ? ' selected="selected"' : '';?> value="<?php echo $id;?>"><?php echo $value;?></option>
												<?php endif ?>
										<?php endforeach ?>
									</select>
								</div>
							</div>
						</div>

						<div class="card-footer">
							<button type="submit" class="btn btn-default">Save</button>
						</div>
					</form>
				</div>

				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title">Home Address</h3>
					</div>
					<!-- form start -->
					<form class="form-validate" action="profile/<?php echo $info['id'];?>" method="post">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
									<div class="input-group">
										<div class="input-group-prepend">
											<label for="home_address_1" class="input-group-text">Home #1</label>
										</div>
										<input type="text" id="home_address_1" class="form-control" name="home_address_1" placeholder="My house" />
										<div class="input-group-prepend">
											<label class="input-group-text">Default <input type="radio" name="home_default" style="margin-left: 10px;" /></label>
										</div>
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
									<label for="street">Block /Lot /House # Street</label>
									<input type="text" class="form-control" id="street" name="street" value="" />
								</div>

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
									<label for="subdivision">Subdivision/ Village/ Compound</label>
									<input type="text" class="form-control" id="subdivision" name="subdivision" value="" />
								</div>

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group">
									<label for="region">Region</label>
									<input type="text" class="form-control" id="region" name="region" value="" />
								</div>

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group">
									<label for="city">City</label>
									<input type="text" class="form-control" id="city" name="city" value="" />
								</div>

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group">
									<label for="postal">Postal Code</label>
									<input type="text" class="form-control" id="postal" name="postal" value="" />
								</div>

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><hr></div>

								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group mt-3">
									<div class="input-group">
										<div class="input-group-prepend">
											<label for="home_address_1" class="input-group-text">Home #2</label>
										</div>
										<input type="text" id="home_address_1" class="form-control" name="home_address_1" placeholder="My mother's house" />
										<div class="input-group-prepend">
											<label class="input-group-text">Default <input type="radio" name="home_default" style="margin-left: 10px;" /></label>
										</div>
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
									<label for="street">Block /Lot /House # Street</label>
									<input type="text" class="form-control" id="street" name="street" value="" />
								</div>

								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
									<label for="subdivision">Subdivision/ Village/ Compound</label>
									<input type="text" class="form-control" id="subdivision" name="subdivision" value="" />
								</div>

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group">
									<label for="region">Region</label>
									<input type="text" class="form-control" id="region" name="region" value="" />
								</div>

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group">
									<label for="city">City</label>
									<input type="text" class="form-control" id="city" name="city" value="" />
								</div>

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 form-group">
									<label for="postal">Postal Code</label>
									<input type="text" class="form-control" id="postal" name="postal" value="" />
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

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<?php
					$settings = $profile_data['app_settings'];
					// debug($settings);
					$password_id = 0;
				?>
				<div class="card card-secondary">
					<div class="card-header">
						<h3 class="card-title">App Settings</h3>
					</div>
					<form class="form-validate" action="profile/<?php echo $info['id'];?>" method="post">
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
										<div class="col-12 form-group">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" type="checkbox" id="<?php echo strtolower(str_replace(' ', '_', $row['label']));?>" name="user_app_settings[<?php echo $id;?>][value]" <?php echo ($row['value'] == 'checked') ? 'checked=""' : '' ?> value="1" />
												<label for="<?php echo strtolower(str_replace(' ', '_', $row['label']));?>" class="custom-control-label"><?php echo $row['label'];?></label>
											</div>
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
										<div class="col-4 form-group">
											<?php echo $row['label'];?>
										</div>
										<div class="col-8 form-group">
											<input type="text" class="form-control" name="user_app_settings[<?php echo $id;?>][value]" value="<?php echo $row['value'];?>" />
										</div>
									<?php
									break;
								}?>
								<input type="hidden" name="user_app_settings[<?php echo $id;?>][type]" value="<?php echo $row['type'];?>" />
							<?php endforeach ?>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-default">Save</button>
						</div>
					</form>
				</div>

				<div class="card card-default">
					<div class="card-header">
						<h3 class="card-title">Password Reset</h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<form class="form-validate" action="profile/<?php echo $info['id'];?>" method="post">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
									<label for="current_password">Current password</label>
									<input type="password" class="form-control" name="user_app_settings[<?php echo $password_id;?>][current_password]" id="current_password" value="" required="required">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group">
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
</section>

