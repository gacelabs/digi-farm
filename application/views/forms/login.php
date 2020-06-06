<div class="container">
	<?php if (has_get('error')): ?>
		<br>
		<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration: none;">&times;</a>
			<strong>Error!</strong> <?php echo get_url_var('error');?>
		</div>
	<?php endif ?>
	<div class="row" id="loign-row">
		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" id="login-bg" style="background-image: url(assets/images/props/local-farmer.jpg);"></div>

		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			
			<form action="sign_in" method="post" class="form-validate <?php echo is_url_var('page', 'sign_in') ? 'show' : 'hidden';?>" id="login">
				<h3 class="zero-gap margin-bottom-20">Buy vegetables grown by farmers near you.</h4>
				<div class="form-group">
					<label for="email_address">Email address</label>
					<input type="email" class="form-control" id="email_address" name="email_address"/>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password"/>
				</div>
				<button type="submit" class="btn btn-info btn-block">Log in</button>
			</form>

			<form action="sign_up" method="post" class="form-validate <?php echo is_url_var('page', 'sign_in') ? 'hidden' : 'show';?>" id="signup">
				<h3 class="zero-gap margin-bottom-20">Let us support the local farmers.</h4>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label for="first_name">First name</label>
							<input type="text" class="form-control" id="first_name" name="first_name"/>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label for="last_name">Last name</label>
							<input type="text" class="form-control" id="last_name" name="last_name" required="required" />
						</div>
					</div>
					
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label for="email_address">Email address</label>
							<input type="email" class="form-control" id="email_address" name="email_address"/>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password"/>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							<label for="retype_password">Retype password</label>
							<input type="password" class="form-control" id="retype_password" name="retype_password"/>
						</div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<label for="farmer">
							<input type="checkbox" id="farmer" name="farmer" value="1">
							I'm a farmer
						</label>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<button type="submit" class="btn btn-success btn-block">Sign up!</button>
					</div>
				</div>
			</form>
			
			<hr>
			
			<div style="padding-bottom: 15px;">
				<ul class="spaced-list between">
					<li>
						<button class="btn btn-sm btn-default" id="login-switch">
							<?php echo is_url_var('page', 'sign_in') ? 'Sign up' : 'Log in';?>
						</button>
					</li>
					<li>
						<a href="#" class="text-sm" style="vertical-align:sub;">Password problem?</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>