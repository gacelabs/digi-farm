<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-lg-12">
				<h1>New Product</h1>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<form action="" method="post" id="add-product">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Product Details</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="category_id">Category</label>
										<select class="form-control custom-select" id="category_id" name="category_id">
											<option selected="" disabled="">Select one</option>
											<option value="lettuce">Lettuce</option>
											<option value="Tomatoes">Tomatoes</option>
											<option value="mustard">Mustard</option>
											<option value="others">Others</option>
										</select>
									</div>
								</div>
								<div class="col-lg-8 col-md-8">
									<div class="form-group">
										<label for="name">Name</label>
										<input type="text" id="name" name="name" class="form-control" />
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="description">Description</label>
								<textarea id="description" name="description" class="form-control" rows="4"></textarea>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<label for="current_price">Price</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">₱</span>
										</div>
										<input type="number" id="current_price" name="current_price" class="form-control" />
									</div>
								</div>

								<div class="col-lg-4 col-md-4">
									<div class="form-group">
										<label for="measurement">Measurement</label>
										<select class="form-control custom-select" id="measurement" name="measurement">
											<option selected="" disabled="">Select one</option>
											<option value="kg">kg</option>
											<option class="bundle">bundle</option>
											<option value="box">box</option>
										</select>
									</div>
								</div>

								<div class="col-lg-4 col-md-4">
									<div class="form-group">
										<label for="stocks">In Stock</label>
										<input type="number" id="stocks" name="stocks" class="form-control" />
									</div>
								</div>

								<!-- Show this only if user has 2 or more farms -->
								<div class="col-lg-12">
									<hr>
									<p>Which of your farms this product is available?</p>
									<div class="form-group">
										<select class="form-control custom-select" id="farm-branch" name="farm-branch">
											<option selected="" disabled="">Select one</option>
											<option value="Bagong Nyaon, Antipolo">Bagong Nyaon, Antipolo</option>
											<option class="Muzon, SJDM Bulacan">Muzon, SJDM Bulacan</option>
											<option value="Tinajeros, Malabon">Tinajeros, Malabon</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="card card-secondary">
						<div class="card-header">
							<h3 class="card-title">Photos</h3>

							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="featured-photo">Featured photo</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="featured-photo">
										<label class="custom-file-label" for="featured-photo">Choose file</label>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label for="featured-photo">More photos</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="featured-photo">
										<label class="custom-file-label" for="featured-photo">Choose file</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<a href="dashboard/inventory" class="btn btn-default">Cancel</a>
					<input type="submit" value="Post Product" class="btn btn-success float-right" />
				</div>
			</div>
		</form>
	</div>
</section>

