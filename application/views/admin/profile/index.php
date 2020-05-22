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
					<li class="active"><a href="#projects" data-toggle="tab" aria-expanded="true">Projects</a></li>
					<li><a href="#new_domain" data-toggle="tab" aria-expanded="true">Add Domain</a></li>
					<li><a href="#app_files" data-toggle="tab" aria-expanded="true">App Files</a></li>
					<li><a href="#app_credits" data-toggle="tab" aria-expanded="true">App Credentials</a></li>
					<li><a href="#settings" data-toggle="tab" aria-expanded="true">Settings</a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="projects">
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
						<div class="row" style="padding: 10px;">
							<div class="col-lg-12">
								<!-- LOOP HERE FOR PROJECTS -->
								<?php if ($projects) {?>
								<?php foreach ($projects as $index => $row) {?>
								<?php 
									$split = explode('|', $index); 
									$project = $row['sub1']['data'];
									$package_type = $project->package_type;
									$col_size = $package_type == 'Free' ? '4':'6';
								?>
								<div class="box">
									<div class="box-header with-border">
										<h3 class="box-title origin-name" style="cursor: pointer;">
											<font style="font-size: 22px; font-weight: bold;"><?php echo $project->origin;?></font>&nbsp;
											<span class="fa fa-pencil" style="margin-left: 10px;" title="EDIT"></span>&nbsp;
											<span class="fa fa-file-archive-o" style="margin-left: 10px;" title="ARCHIVE"></span>
										</h3>
										<form class="col-lg-5 form-origin" style="display: none; padding: 0;" action="save_origin">
											<div class="input-group">
												<input type="hidden" name="projects[id]" value="<?php echo $project->id;?>">
												<input type="url" class="form-control" placeholder="Enter Domain URL" name="projects[origin]" value="<?php echo $project->origin;?>">
												<div class="input-group-btn">
													<button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button>
													<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>
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
											<?php if (strtolower($package_type) == 'free'): ?>
												<div class="col-md-<?php echo $col_size;?>">
													<div class="box box-default">
														<div class="box-header">
															<h3 class="box-title">FREE</h3>
														</div>
														<div class="box-body" style="height: 152px;">
															<ul>
																<li>FREE 2 Months Max</li>
																<li>20000 Max Payload</li>
																<li>Limited Support</li>
															</ul>
														</div>
														<div class="box-footer text-center">
															<?php if ($project->expired): ?>
																<a href="javascript:void(0);" class="btn btn-danger btn-lg btn-block"><b>Expired</b></a>
															<?php else: ?>
																<a href="javascript:void(0);" class="btn btn-default btn-lg btn-block"><b>Active</b></a>
															<?php endif ?>
														</div>
													</div>
												</div>
											<?php endif ?>
											<?php
												$payload_value = 1; $payload = $project->payload; $price = $project->price;
												if (strtolower($package_type) == 'customed') {
													$payload_value = (int)$payload / 1000;
												} else {
													$payload = '1000'; $price = '1000';
												}
											?>
											<div class="col-md-<?php echo $col_size;?>">
												<div class="box box-danger">
													<div class="box-header">
														<h3 class="box-title">CUSTOMED</h3>
													</div>
													<form class="paypal-form" action="projects/subscribe" method="post">
														<div class="box-body" style="height: 152px;">
															<?php if ($project->allowed == 0 OR $project->expired OR strtolower($package_type) != 'customed'): ?>
																<div class="range-field">
																	<input type="text" name="payload" id="<?php echo $index;?>" class="p-0 calculatorSlider" data-slider-min="1" data-slider-max="10" data-slider-step="1" data-slider-value="<?php echo $payload_value;?>" data-slider-handle="custom" style="width: 95%;">
																	<input type="hidden" name="price" class="clientPriceVal" value="1000">
																	<input type="hidden" name="project_id" value="<?php echo $project->id;?>">
																	<input type="hidden" name="package_type" value="Customed">
																</div>
																<div class="row mb-3">
																	<div class="col-md-6 col-xs-6 text-center">
																		Payload
																		<div class="col-lg">
																			<strong class="payloadLimit">1000</strong>
																		</div>
																	</div>
																	<div class="col-md-6 col-xs-6 text-center">
																		Price
																		<div class="col-lg">
																			<b>USD </b><strong class="clientPrice">26</strong>
																		</div>
																	</div>
																</div>
															<?php endif ?>
															<ul>
																<li>Metered Payload per Month</li>
																<li><span class="payloadLimit"><?php echo $payload;?></span> Payload for USD <span class="clientPrice"><?php echo number_format($price);?></span></li>
																<li>24/7 Email Support</li>
															</ul>
														</div>
														<div class="box-footer text-center">
															<?php if ($project->expired AND strtolower($package_type) == 'customed'): ?>
																<button class="btn paypal-btn btn-lg btn-warning btn-block"><b>Continue</b></button>
															<?php elseif ($project->allowed == 0 OR strtolower($package_type) != 'customed'): ?>
																<button class="btn paypal-btn btn-lg btn-primary btn-block"><b>Subscribe</b></button>
															<?php else: ?>
																<a href="javascript:void(0);" class="btn btn-default btn-lg btn-block"><b>Active</b></a>
															<?php endif ?>
														</div>
													</form>
												</div>
											</div>
											<div class="col-md-<?php echo $col_size;?>">
												<div class="box box-success">
													<div class="box-header">
														<h3 class="box-title">BUSINESS</h3>
													</div>
													<form class="paypal-form" action="projects/subscribe" method="post">
														<input type="hidden" name="payload" value="500000">
														<input type="hidden" name="price" value="145">
														<input type="hidden" name="project_id" value="<?php echo $project->id;?>">
														<input type="hidden" name="package_type" value="Business">
														<div class="box-body" style="height: 152px;">
															<ul>
																<li>500000 Upfront Payload per Month for USD 145</li>
																<li>Metered Succeeding 1000 Payload for USD 26</li>
																<li>24/7 Email Support</li>
															</ul>
														</div>
														<div class="box-footer text-center">
															<?php if ($project->expired AND strtolower($package_type) == 'business'): ?>
																<button class="btn paypal-btn btn-lg btn-warning btn-block"><b>Continue</b></button>
															<?php elseif ($project->allowed == 0 OR strtolower($package_type) != 'business'): ?>
																<button class="btn paypal-btn btn-lg btn-primary btn-block"><b>Subscribe</b></button>
															<?php else: ?>
																<a href="javascript:void(0);" class="btn btn-default btn-lg btn-block"><b>Active</b></a>
															<?php endif ?>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php }?>
								<?php }?>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="new_domain">
						<form class="form-horizontal form-add-domain" method="post" action="accounts/add_domain">
							<input type="hidden" name="accounts[id]" value="<?php echo $user->id;?>" />
							<div class="form-group">
								<label for="url-name" class="col-sm-2 control-label">Website URL/Domain</label>
								<div class="col-sm-10" style="display: inline-flex;">
									<select class="custom-select col-lg-3 col-sm-3" id="url-protocol">
										<option value="https://">https://</option>
										<option value="http://">http://</option>
									</select>
									<input type="text" id="url-name" class="form-control" placeholder="Enter Domain URL" required="required" data-type="url" value="" />
								</div>
								<input type="hidden" name="projects[origin]" id="url-origin" class="form-control" />
								<input type="hidden" name="projects[domain]" id="url-domain" class="form-control" />
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
								<?php foreach ($projects as $index => $row) {?>
									<?php 
									$split = explode('|', $index);
									$project = $row['sub1']['data'];
									?>
									<div class="box-body" id="app-files-<?php echo $project->id;?>">
										<a href="generate_files/<?php echo $project->app_key;?>" id="<?php echo $project->id;?>" class="btn btn-block btn-social btn-info" style="letter-spacing: 5px;" target="_blank" title="for project <?php echo $project->domain;?>">
											<i class="fa fa-download"></i>Click this to <b style="letter-spacing: 0px;">GENERATE Application Files</b> for project <strong><code><?php echo $project->domain;?></code></strong>
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
							<?php foreach ($projects as $index => $row) {?>
								<?php 
								$split = explode('|', $index);
								$project = $row['sub1']['data'];
								?>
								<form class="form-horizontal regen-keys" id="regen-keys-<?php echo $project->id;?>" method="post" action="regenerate_keys">
									<input type="hidden" name="accounts[id]" class="account-id" value="<?php echo $user->id;?>" />
									<input type="hidden" name="projects[id]" class="project-id" value="<?php echo $project->id;?>" />
									<input type="hidden" name="projects[app_key]" class="app-key" value="<?php echo $project->app_key;?>" />
									<div class="form-group">
										<label for="url-name" class="col-sm-2 control-label"><?php echo $project->domain;?> APP KEY</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="app_key_<?php echo $project->id;?>" value="<?php echo $project->app_key;?>" placeholder="<?php echo $project->app_key;?>" disabled />
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
					<div class="tab-pane" id="settings">
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
				</div>
			</div>
		</div>
	</div>
</section>