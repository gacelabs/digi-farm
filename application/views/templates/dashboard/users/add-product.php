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
		<form action="/dashboard/add-product/" method="post" id="add-product" class="form-validate" enctype="multipart/form-data">
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
									<?php $category = get_data_and_construct('product_category', 'value'); ?>
									<div class="form-group">
										<label for="category_id">Category</label>
										<select class="form-control custom-select" id="category_id" name="product[category_id]" required="required">
											<option value="0">Select one</option>
											<?php if ($category): ?>
												<?php foreach ($category['select'] as $value => $label): ?>
													<option value="<?php echo $value;?>" <?php echo ($category['selected']==$value) ? 'selected' : '';?>><?php echo $label;?></option>
												<?php endforeach ?>
											<?php endif ?>
										</select>
									</div>
								</div>
								<div class="col-lg-8 col-md-8">
									<div class="form-group">
										<label for="name">Name</label>
										<input type="text" id="name" name="product[name]" class="form-control" required="required" />
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="description">Description</label>
								<textarea id="description" name="product[description]" class="form-control" rows="4" required="required"></textarea>
							</div>

							<div class="row">
								<div class="col-lg-4 col-md-4">
									<label for="current_price">Price</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">₱</span>
										</div>
										<input type="number" id="current_price" name="product[current_price]" class="form-control" required="required" />
									</div>
								</div>
								<div class="col-lg-4 col-md-4">
									<?php $measurements = get_data_and_construct('product_measurement', 'value'); ?>
									<div class="form-group">
										<label for="measurement">Measurement</label>
										<select class="form-control custom-select" id="measurement" name="product[measurement]" required="required">
											<option value="0">Select one</option>
											<?php if ($measurements): ?>
												<?php foreach ($measurements['select'] as $value => $label): ?>
													<option value="<?php echo $value;?>" <?php echo ($measurements['selected']==$value) ? 'selected' : '';?>><?php echo $label;?></option>
												<?php endforeach ?>
											<?php endif ?>
										</select>
									</div>
								</div>

								<div class="col-lg-4 col-md-4">
									<div class="form-group">
										<label for="stocks">In Stock</label>
										<input type="number" id="stocks" name="product[stocks]" class="form-control" required="required" />
									</div>
								</div>

								<!-- Show this only if user has 2 or more farms -->
								<div class="col-lg-12">
									<hr>
									<?php $locations = get_data_and_construct('user_location', 'id', 'ddloc'); ?>
									<p>Which of your farms this product is available?</p>
									<div class="form-group">
										<!-- <select class="form-control select2" id="farm-branch" name="product[location_id][]" multiple required="required"> -->
										<select class="form-control custom-select" id="farm-branch" name="product[location_id]" required="required">
											<option value="0">Select one</option>
											<?php if ($locations): ?>
												<?php foreach ($locations['select'] as $id => $address): ?>
													<option value="<?php echo $id;?>" <?php echo ($locations['selected']==$id) ? 'selected' : '';?>><?php echo $address;?></option>
												<?php endforeach ?>
											<?php endif ?>
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
										<input type="file" class="custom-file-input" name="product_photo[]" required="required">
										<label class="custom-file-label" for="featured-photo">Choose file</label>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label for="featured-photo">More photos</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" name="product_photo[]">
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

