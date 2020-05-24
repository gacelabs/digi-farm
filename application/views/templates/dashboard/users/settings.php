<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-lg-12">
				<h3 class="m-0 text-dark">Settings</h3>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">Farm locations</h3>
					</div>
					<form role="form" action="" method="post">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<label for="farm_name">Farm name</label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-seedling"></i></span>
										</div>
										<input type="text" id="farm_name" name="farm_name" class="form-control" required="required" />
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<label for="farm_location">Location</label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
										</div>
										<input type="text" id="farm_location" name="farm_location" class="form-control" required="required" />
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-default">Save</button>
							<button type="button" class="btn btn-primary float-right new-farm">New farm</button>
						</div>
					</form>
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="card card-success card-outline">
					<div class="card-header">
						<h3 class="card-title">About</h3>
					</div>
					<form role="form" action="" method="post">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>Farm history</label>
										<textarea class="form-control" rows="3" required="required"></textarea>
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
						<h3 class="card-title">Photos</h3>
					</div>
					<form role="form" action="" method="post">
						<div class="card-body">
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
						<div class="card-footer">
							<button type="submit" class="btn btn-default">Upload</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</section>