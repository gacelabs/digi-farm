<section class="content-header">
	<h1>Account Profile</h1>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-3">
			<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle profile-photo" src="<?php echo $user->photo;?>" alt="Profile picture" style="cursor: pointer;">
					<input type="file" class="hide" cloned-tag="profile-photo">

					<h3 class="profile-username text-center"><?php echo $user->company;?></h3>
					<p class="text-muted text-center"><?php echo $user->admin;?></p>

					<p class="text-muted text-left">Domains</p>
					<?php if ($projects) {?>
						<ul class="list-group list-group-unbordered">
							<?php foreach ($projects as $project => $row) {?>
								<?php $split = explode('|', $project); ?>
								<li class="list-group-item">
									<b><?php echo $split[1];?></b> <a class="pull-right"><?php echo ($row['sub1']['data']->expired == 1) ? 'inactive' : ($row['sub1']['data']->allowed == 0 ? 'inactive':'active');?></a>
								</li>
							<?php }?>
						</ul>
						<p class="text-muted text-left">Channels</p>
						<ul class="list-group list-group-unbordered">
							<?php foreach ($projects as $project => $row) {?>
								<?php $split = explode('|', $project); ?>
								<?php $channels = $this->account->check(array('id'=>$user->id))->get_channels(trim($split[0]));?>
								<?php if ($channels) {?>
									<?php foreach ($channels as $res) {?>
										<?php if (!isset($isset[$res['channel']])): 
											$isset[$res['channel']] = TRUE;
											?>
											<?php if ($res['sent'] > 0): ?>
												<li class="list-group-item">
													<b><?php echo $res['channel'];?></b> <a class="pull-right"><?php echo ($res['sent'] > 0) ? 'active' : 'inactive';?></a>
												</li>
											<?php endif ?>
										<?php endif ?>
									<?php }?>
								<?php }?>
							<?php }?>
						</ul>
					<?php }?>
				</div>
			</div>
		</div>

		<div class="col-md-9">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
					<li><a href="#projects" data-toggle="tab" aria-expanded="true">Projects</a></li>
					<li><a href="#new_domain" data-toggle="tab" aria-expanded="true">Add Domain</a></li>
					<li><a href="#app_files" data-toggle="tab" aria-expanded="true">App Files</a></li>
					<li><a href="#app_credits" data-toggle="tab" aria-expanded="true">App Credentials</a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="settings">
						<?php if ($this->input->get('status')) {?>
							<?php if ($this->input->get('status') != 'existing') {?>
								<div class="callout callout-<?php echo $this->input->get('status') == 'canceled' ? 'danger':'success';?>">
									<h4>Transaction was <?php echo strtoupper($this->input->get('status'));?>!</h4>
									<?php if ($this->input->get('status') == 'canceled') {?>
										Please retry and select other option for payment.
									<?php }?>
								</div>
							<?php } else {?>
								<div class="callout callout-warning">
									<h4>Domain already exist!</h4>
									Please set and enter different domain.
								</div>
							<?php }?>
						<?php }?>
						<form class="form-horizontal" method="post" action="admin/save_profile">
							<input type="hidden" name="id" value="<?php echo $user->id;?>" />
							<input type="hidden" name="photo" class="profile-photo" value="" />
							<div class="form-group">
								<label for="company" class="col-sm-2 control-label">Company</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="company" name="company" value="<?php echo $user->company;?>" placeholder="Name">
								</div>
							</div>
							<div class="form-group">
								<label for="email" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="email" name="email" value="<?php echo $user->email;?>" placeholder="Email">
								</div>
							</div>
							<div class="form-group">
								<label for="admin" class="col-sm-2 control-label">Admin Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="admin" name="admin" value="<?php echo $user->admin;?>" placeholder="Admin Name">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<div class="checkbox">
										<label>
											<input type="checkbox" onclick="this.checked ? $('#password').removeAttr('disabled').attr('type', 'text') : $('#password').attr({'disabled': 'disabled', 'type': 'password'});"> Change password ?
										</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="password" class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" name="password" disabled value="<?php echo $user->orig_pass;?>" id="password" placeholder="Password" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-success">Submit</button>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="projects">
						<?php if ($projects) {?>
							<?php foreach ($projects as $project => $row) {?>
								<?php 
								$split = explode('|', $project);
								$sub_data = $row['sub1']['data'];
								?>
								<div class="row" style="padding: 10px;">
									<div class="col-lg-12">
										<div class="box">
											<div class="box-header with-border">
												<h3 class="box-title origin-name" style="cursor: pointer;">
													<font style="font-size: 22px; font-weight: bold;"><?php echo $sub_data->origin;?></font>
													<span class="fa fa-pencil" style="margin-left: 10px;"></span>
												</h3>
												<form class="col-lg-5 form-origin" style="display: none; padding: 0;" action="save_origin">
													<div class="input-group">
														<input type="hidden" name="projects[id]" value="<?php echo $sub_data->id;?>">
														<input type="url" class="form-control" placeholder="Enter Domain URL" name="projects[origin]" value="<?php echo $sub_data->origin;?>">
														<div class="input-group-btn">
															<button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button>
														</div>
													</div>
												</form>
												<div class="box-tools pull-right">
													<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
													</button>
												</div>
											</div>
											<div class="box-body" style="height: auto;">
												<div class="row">
													<div class="col-md-<?php echo in_array($sub_data->package_type, array('Business', 'Customed')) ? '6':'4';?>">
														<div class="box box-default">
															<div class="box-header">
																<h3 class="box-title"><?php echo $sub_data->package_type;?></h3>
															</div>
															<div class="box-body" style="height: auto;">
																<?php 
																switch ($sub_data->package_type) {
																	case 'Business':?>
																	<ul>
																		<li>50K Upfront Payload per Month for Php 7k</li>
																		<li>Metered Succeeding 1K Payload for Php 1K</li>
																		<li>24/7 Email Support</li>
																	</ul>
																	<?php if ($sub_data->expired) { ?>
																		<div class="text-danger text-center" style="font-size: 18px;">
																			<strong>Click "Pay Now" for<br>Succeeding 1K Payload.</strong>
																		</div>
																	<?php } ?>
																	<?php
																	break;
																	case 'Customed':?>
																	<?php if ($sub_data->expired OR $sub_data->allowed == 0): 
																		$payload_value = 1;
																		if ($sub_data->payload != 2000) {
																			$payload_value = (int)$sub_data->payload / 1000;
																		}
																		?>
																		<div class="range-field">
																			<input type="text" id="<?php echo $project;?>" class="p-0 calculatorSlider" data-slider-min="1" data-slider-max="15" data-slider-step="1" data-slider-value="<?php echo $payload_value;?>" data-slider-handle="custom" style="width: 100%;">
																		</div>
																		<div class="row mb-3">
																			<div class="col-md-6 text-center">
																				Payload
																				<div class="col-lg">
																					<strong class="payloadLimit">0</strong>
																				</div>
																			</div>
																			<div class="col-md-6 text-center">
																				Price
																				<div class="col-lg">
																					<b>Php </b><strong class="clientPrice">0</strong>
																				</div>
																			</div>
																		</div>
																	<?php endif ?>
																	<ul>
																		<li>Monthly Metered Payload</li>
																		<li><span class="payloadLimit"><?php echo $sub_data->payload;?></span> Payload for Php <span class="clientPrice"><?php echo number_format($sub_data->price);?></span></li>
																		<li>24/7 Email Support</li>
																	</ul>
																	<?php if ($sub_data->expired) { ?>
																		<div class="text-danger text-center" style="font-size: 18px;">
																			<strong>Payload Limit Reached!<br>Click "Pay Now" to Renew Service.</strong>
																		</div>
																	<?php } ?>
																	<?php
																	break;
																	default:?>
																	<ul>
																		<li>2 Months Max</li>
																		<li>1K Max Payload per month</li>
																		<li>Limited Support</li>
																	</ul>
																	<?php
																	break;
																}
																$color = 'default'; $color_text = 'Current'; $form = 0;
																if ($sub_data->expired) {
																	$color = 'danger'; $color_text = 'Expired';
																	if ($sub_data->package_type != 'Free') {
																		$color = 'success'; $color_text = 'Renew';
																		if ($sub_data->package_type == 'Business') {
																			$form = 3;
																		} else {
																			$form = 4;
																		}
																	}
																} elseif ($sub_data->expired == 0 AND $sub_data->allowed == 0) {
																	if ($sub_data->package_type == 'Business') {
																		$form = 1;
																	} else {
																		$form = 2;
																	}
																}
																?>
															</div>
															<div class="box-footer text-center">
																<?php if ($form == 1) {?>
																	<form class="paypal-form" was-clicked="0" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" project-id="<?php echo $sub_data->id;?>">
																		<input type="hidden" name="cmd" value="_s-xclick">
																		<input type="hidden" name="hosted_button_id" value="E5AG27MNR39YE">
																		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
																		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
																	</form>
																<?php } else if ($form == 2) {?>
																	<form data-formid="<?php echo $project;?>" class="paypal-form" was-clicked="0" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" project-id="<?php echo $sub_data->id;?>">
																		<input type="hidden" name="cmd" value="_s-xclick">
																		<input type="hidden" name="hosted_button_id" value="LC4TU9WK275NN">
																		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
																		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
																	</form>
																<?php } else if ($form == 3) {?>
																	<form class="paypal-form" was-clicked="0" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" project-id="<?php echo $sub_data->id;?>">
																		<input type="hidden" name="cmd" value="_s-xclick">
																		<input type="hidden" name="hosted_button_id" value="WDC5DZBDVGQTS">
																		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
																		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
																	</form>
																<?php } else if ($form == 4) {?>
																	<form data-formid="<?php echo $project;?>" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" project-id="<?php echo $sub_data->id;?>">
																		<input type="hidden" name="cmd" value="_s-xclick">
																		<input type="hidden" name="hosted_button_id" value="4EY23X582T95L">
																		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
																		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
																	</form>
																<?php } else {?>
																	<a href="#" style="pointer-events: none; margin: 9px 0 9px;" class="btn btn-<?php echo $color;?> btn-block"><b><?php echo $color_text;?></b></a>
																<?php }?>
															</div>
														</div>
													</div>
													<?php if (in_array($sub_data->package_type, array('Free', 'Customed'))) {?>
														<div class="col-md-<?php echo in_array($sub_data->package_type, array('Business', 'Customed')) ? '6':'4';?>">
															<div class="box box-danger">
																<div class="box-header">
																	<h3 class="box-title">Business</h3>
																</div>
																<div class="box-body" style="height: auto;">
																	<ul>
																		<li>50K Upfront Payload per Month for Php 7k</li>
																		<li>Metered Succeeding 1K Payload for Php 1K</li>
																		<li>24/7 Email Support</li>
																	</ul>
																</div>
																<div class="box-footer text-center">
																	<form class="paypal-form" was-clicked="0" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" project-id="<?php echo $sub_data->id;?>">
																		<input type="hidden" name="cmd" value="_s-xclick">
																		<input type="hidden" name="hosted_button_id" value="E5AG27MNR39YE">
																		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
																		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
																	</form>
																</div>
															</div>
														</div>
													<?php }?>
													<?php if (in_array($sub_data->package_type, array('Free', 'Business'))) {
														$payload_value = 1;
														if ($sub_data->payload != 2000) {
															$payload_value = (int)$sub_data->payload / 1000;
														}
														?>
														<div class="col-md-<?php echo in_array($sub_data->package_type, array('Business', 'Customed')) ? '6':'4';?>">
															<div class="box box-success">
																<div class="box-header">
																	<h3 class="box-title">Customed</h3>
																</div>
																<div class="box-body" style="height: auto;">
																	<div class="range-field">
																		<input type="text" id="<?php echo $project;?>" class="p-0 calculatorSlider" data-slider-min="1" data-slider-max="15" data-slider-step="1" data-slider-value="<?php echo $payload_value;?>" data-slider-handle="custom" style="width: 100%;">
																	</div>
																	<div class="row mb-3">
																		<div class="col-md-6 text-center">
																			Payload
																			<div class="col-lg">
																				<strong class="payloadLimit">0</strong>
																			</div>
																		</div>
																		<div class="col-md-6 text-center">
																			Price
																			<div class="col-lg">
																				<b>Php </b><strong class="clientPrice">0</strong>
																			</div>
																		</div>
																	</div>
																	<ul>
																		<li>Monthly Metered Payload</li>
																		<li><span class="payloadLimit"><?php echo $sub_data->payload;?></span> Payload for Php <span class="clientPrice"><?php echo number_format($sub_data->price);?></span></li>
																		<li>24/7 Email Support</li>
																	</ul>
																</div>
																<div class="box-footer text-center">
																	<form data-formid="<?php echo $project;?>" class="paypal-form" was-clicked="0" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" project-id="<?php echo $sub_data->id;?>">
																		<input type="hidden" name="cmd" value="_s-xclick">
																		<input type="hidden" name="hosted_button_id" value="LC4TU9WK275NN">
																		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
																		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
																	</form>
																</div>
															</div>
														</div>
													<?php }?>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php }?>
						<?php }?>
					</div>
					<div class="tab-pane" id="new_domain">
						<form class="form-horizontal" method="post" action="accounts/add_domain">
							<input type="hidden" name="accounts[id]" value="<?php echo $user->id;?>" />
							<div class="form-group">
								<label for="url-name" class="col-sm-2 control-label">Website URL/Domain</label>
								<div class="col-sm-10">
									<input type="url" name="projects[origin]" id="url-name" class="form-control" placeholder="https://www.website.com" required />
								</div>
							</div>
							<div class="form-group">
								<label for="package_type" class="col-sm-2 control-label">Package Type</label>
								<div class="col-sm-10">
									<select class="form-control" name="projects[package_type]" id="package_type" required>
										<option value="">-- Select Package --</option>
										<option value="Free">Free</option>
										<option value="Business">Business</option>
										<option value="Customed">Customed</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-success">Submit</button>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="app_files">
						<?php if ($projects) {?>
							<div class="box" style="border-top: none;">
								<?php foreach ($projects as $project => $row) {?>
									<?php 
									$split = explode('|', $project);
									$sub_data = $row['sub1']['data'];
									?>
									<div class="box-body">
										<a href="generate_files/<?php echo $sub_data->app_key;?>" id="<?php echo $sub_data->id;?>" class="btn btn-block btn-social btn-info" style="letter-spacing: 2px;" target="_blank">
											<i class="fa fa-download"></i>Click&nbsp;&nbsp;this&nbsp;&nbsp;to&nbsp;&nbsp;<b>GENERATE&nbsp;&nbsp;APP&nbsp;&nbsp;Files</b>&nbsp;&nbsp;for&nbsp;&nbsp;project&nbsp;&nbsp;<strong><code><?php echo $sub_data->domain;?></code></strong>
										</a>
									</div>
								<?php }?>
							</div>
						<?php }?>
					</div>
					<div class="tab-pane" id="app_credits">
						<?php if ($projects) {?>
							<code class="nohighlight">
								<span class="fa fa-info-circle"></span> 
								<strong>NOTE:</strong>
								<span class="small">REGENATE APP FILES ALSO AFTER CHANGING THE PROJECTS APP KEY AND REPLACE THE EXISTING SCRIPT AND CLASS LIBRARY.</span>
								<br><br>
							</code>
							<?php foreach ($projects as $project => $row) {?>
								<?php 
								$split = explode('|', $project);
								$sub_data = $row['sub1']['data'];
								?>
								<form class="form-horizontal regen-keys" method="post" action="regenerate_keys">
									<input type="hidden" name="accounts[id]" class="account-id" value="<?php echo $user->id;?>" />
									<input type="hidden" name="projects[id]" class="project-id" value="<?php echo $sub_data->id;?>" />
									<input type="hidden" name="projects[app_key]" class="app-key" value="<?php echo $sub_data->app_key;?>" />
									<div class="form-group">
										<label for="url-name" class="col-sm-2 control-label"><?php echo $sub_data->domain;?> APP KEY</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="app_key_<?php echo $sub_data->id;?>" value="<?php echo $sub_data->app_key;?>" placeholder="<?php echo $sub_data->app_key;?>" disabled />
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-success">Regenerate</button>
										</div>
									</div>
								</form>
							<?php }?>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
