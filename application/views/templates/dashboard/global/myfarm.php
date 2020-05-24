<section class="content" style="padding-top: 20px;">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<div class="card card-success card-outline">
					<div class="card-tools" style="position:absolute;top:0;left:5px;">
						<span class="badge badge-secondary" data-toggle="modal" data-target="#modal-default" style="cursor:pointer;"><i class="far fa-edit"></i> Edit</span>
					</div>
					<img src="http://placehold.it/1080x200" width="100%" height="150px" alt="">
					<div class="card-body box-profile">
						<div class="text-center" style="margin-top: -75px;">
							<img class="profile-user-img img-fluid img-circle" src="http://placehold.it/128x128" alt="User profile picture">
						</div>
						<h3 class="profile-username text-center">Poi Garcia</h3>
					</div>
					<!-- /.card-body -->
				</div>

				<div class="row products">
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="slider-item">
							<div class="card">
								<div class="card-header" style="padding:0;">
									<img src="http://placehold.it/300x300" width="100%" class="" alt="">
								</div>
								<div class="card-body">
									The body of the card
								</div>
								<div class="card-footer">
									The footer of the card
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="slider-item">
							<div class="card">
								<div class="card-header" style="padding:0;">
									<img src="http://placehold.it/300x300" width="100%" class="" alt="">
								</div>
								<div class="card-body">
									The body of the card
								</div>
								<div class="card-footer">
									The footer of the card
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="slider-item">
							<div class="card">
								<div class="card-header" style="padding:0;">
									<img src="http://placehold.it/300x300" width="100%" class="" alt="">
								</div>
								<div class="card-body">
									The body of the card
								</div>
								<div class="card-footer">
									The footer of the card
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-4 col-md-4 col-sm-12 hidden-xs">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">About Poi's farm</h3>
						<div class="card-tools">
							<a href="settings" class="badge badge-default"><i class="far fa-edit"></i> Edit</a>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div>
							<strong><i class="fas fa-map-marker-alt mr-1"></i> Farm #1 name</strong>
							<p class="text-muted">Bagong Nayon, Antipolo City</p>
						</div>

						<hr>

						<div>
							<strong><i class="fas fa-map-marker-alt mr-1"></i> Farm #2 name</strong>
							<p class="text-muted">Muzon, SJDM, Bulacan</p>
						</div>

						<hr>

						<div>
							<strong><i class="fas fa-map-marker-alt mr-1"></i> Farm #3 name</strong>
							<p class="text-muted">Tinajeros, Malabon City</p>
						</div>

						<hr>

						<div>
							<strong><i class="fas fa-store-alt mr-1"></i> About</strong>
							<p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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
			<form action="" method="post">
				<div class="modal-body">
					<div class="form-group">
						<label for="banner_photo">Banner</label>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="banner_photo">
								<label class="custom-file-label" for="banner_photo">Choose file</label>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="banner_photo">Profile</label>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="banner_photo">
								<label class="custom-file-label" for="banner_photo">Choose file</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary">Upload</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>