<?php
	$inventory = $db($this->uri->segment(2));
	// debug($inventory);
	$product = $inventory['product'];
	$user_id = $current_profile['user']['id'];
	$product_id = $inventory['product_id'];
?>
<form action="/save-product/<?php echo $product_id;?>" method="post" id="save-product" class="form-validate" enctype="multipart/form-data">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-lg-12">
					<h3 class="m-0 text-dark"><?php echo $product ? 'Edit' : 'New';?> Product <input type="submit" value="<?php echo $product ? 'Save' : 'Post';?> Product" class="btn btn-success float-right" /></h3>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
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
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<?php 
										$selected = 0;
										if ($product) {
										 	$selected = $product['category_id'];
										}
										$category = get_data_and_construct('product_category', 'id', 'dd', $selected);
									?>
									<div class="form-group">
										<label>Category</label>
										<select class="form-control select2" id="category_id" name="product[category_id]" required="required" style="width: 100%;height: 38px;">
											<option selected="selected" disabled="disabled" value="0">Select one</option>
											<?php if ($category): ?>
												<?php foreach ($category['select'] as $value => $label): ?>
													<option value="<?php echo $value;?>" <?php echo ($category['selected']==$value) ? 'selected' : '';?>><?php echo $label;?></option>
												<?php endforeach ?>
											<?php endif ?>
										</select>
									</div>
								</div>
								<?php 
									$name = '';
									if ($product) {
									 	$name = $product['name'];
									}
								?>
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
									<div class="form-group">
										<label for="name">Name</label>
										<input type="text" id="name" name="product[name]" class="form-control" required="required" value="<?php echo $name;?>" />
									</div>
								</div>
							</div>
							<?php 
								$description = '';
								if ($product) {
								 	$description = $product['description'];
								}
							?>
							<div class="form-group">
								<label for="description">Description</label>
								<textarea id="description" name="product[description]" class="form-control" rows="4" required="required"><?php echo $description;?></textarea>
							</div>
							<?php 
								$current_price = '';
								if ($product) {
								 	$current_price = $product['current_price'];
								}
							?>
							<div class="row">
								<div class="col-lg-4 col-md-4">
									<label for="current_price">Price</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">₱</span>
										</div>
										<input type="number" id="current_price" name="product[current_price]" class="form-control" required="required" value="<?php echo $current_price;?>" />
									</div>
								</div>
								<div class="col-lg-4 col-md-4">
									<?php
										$selected = '';
										if ($product) {
										 	$selected = $product['measurement'];
										} 
										$measurements = get_data_and_construct('product_measurement', 'value', 'dd', $selected);
									?>
									<div class="form-group">
										<label>Measurement</label>
										<select class="form-control select2" id="measurement" name="product[measurement]" required="required" style="width: 100%;height: 38px;">
											<option selected="selected" disabled="disabled" value="">Select one</option>
											<?php if ($measurements): ?>
												<?php foreach ($measurements['select'] as $value => $label): ?>
													<option value="<?php echo $value;?>" <?php echo ($measurements['selected']==$value) ? 'selected' : '';?>><?php echo $label;?></option>
												<?php endforeach ?>
											<?php endif ?>
										</select>
									</div>
								</div>
								<?php 
									$stocks = '';
									if ($product) {
									 	$stocks = $product['stocks'];
									}
								?>
								<div class="col-lg-4 col-md-4">
									<div class="form-group">
										<label for="stocks">In Stock (Qty)</label>
										<input type="number" id="stocks" name="product[stocks]" class="form-control" required="required" value="<?php echo $stocks;?>" />
									</div>
								</div>

								<!-- Show this only if user has 2 or more farms -->
								<div class="col-lg-12">
									<hr>
									<?php
										$selected = [];
										if ($product) {
										 	$selected = explode(',', $product['location_id']);
										} 
										$locations = get_data_and_construct('user_location', 'id', 'ddloc', $selected);
										// debug($locations, 1);
									?>
									<p>Which of your farms this product is available?</p>
									<div class="form-group">
										<select class="select2 form-control custom-select" id="farm-branch" name="product[location_id][]" required="required" multiple="multiple" data-placeholder="Select farm" style="width: 100%;">
											<?php if ($locations): ?>
												<?php foreach ($locations['select'] as $id => $address): ?>
													<option value="<?php echo $id;?>" <?php echo (in_array($id, $locations['selected'])) ? 'selected' : '';?>><?php echo $address;?></option>
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
										<input type="file" class="custom-file-input" name="product_photo[]"<?php echo $product ? '' : ' required="required"';?>>
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
					<input type="submit" value="<?php echo $product ? 'Save' : 'Post';?> Product" class="btn btn-success float-right" />
				</div>
			</div>
		</div>
	</section>
</form>
