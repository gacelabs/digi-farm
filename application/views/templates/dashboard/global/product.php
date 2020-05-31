<?php
	$product = $db();
	// debug($product, 1);
?>
<section class="content" style="padding-top: 15px;padding-bottom: 15px">
	<div class="container-fluid">

		<div class="card card-solid">
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-sm-6">
						<h3 class="d-inline-block d-sm-none"><?php echo $product['name'];?></h3>
						<div class="col-12">
							<div class="product-image-blowup">
								<img src="<?php check_file_and_render($product['photo'], '300x700?text=Product');?>" class="product-image" alt="Product Image">
							</div>
						</div>
						<div class="col-12 product-image-thumbs">
							<div class="product-image-thumb active" >
								<img src="<?php check_file_and_render($product['photo'], '300x700?text=Product');?>" alt="Product Image">
							</div>
							<div class="product-image-thumb"><img src="assets/images/props/beans.jpg" alt="Product Image"></div>
							<div class="product-image-thumb" ><img src="assets/images/props/chilis.jpg" alt="Product Image"></div>
							<div class="product-image-thumb" ><img src="assets/images/props/eggplants.jpg" alt="Product Image"></div>
							<div class="product-image-thumb" ><img src="assets/images/props/peppers.jpg" alt="Product Image"></div>
						</div>
					</div>
					<div class="col-12 col-sm-6">
						<h3 class="my-3"><?php echo $product['name'];?></h3>

						<div class="bg-gray py-2 px-3 mt-4">
							<h2 class="mb-0">
								<span class="currency">₱</span><?php echo $product['current_price'];?>
							</h2>
							<h4 class="mt-0">
								<small>per <?php echo $product['measurement'];?></small>
							</h4>
						</div>

						<div class="mt-4">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label>In Stock: <?php echo $product['stocks'];?></label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">
											Quantity
										</span>
									</div>
									<input type="number" min="1" max="<?php echo $product['stocks'];?>" class="form-control" />
									<div class="input-group-append">
										<div class="input-group-text"><?php echo $product['measurement'];?></div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-3">
								<?php if ($product): ?>
									<a class="btn btn-primary btn-lg" href="cart/add?id=<?php echo $product['id'];?>">
										<i class="fas fa-cart-plus fa-lg mr-2"></i> 
										Add to Cart
									</a>
								<?php endif ?>
							</div>

							<hr>

							<div class="mt-3">
								<div class="timeline">
									<div class="time-label">
										<span class="bg-green" style="padding:4px 10px;">Delivery timeline</span>
									</div>
									<div>
										<i class="fas fa-store-alt bg-blue"></i>
										<div class="timeline-item">
											<span class="time"><span class="badge badge-primary"><i class="fas fa-map-marker-alt"></i> 1.4 KM</span></span>
											<h3 class="timeline-header"><b>From</b> Poi's Antipolo City farm</h3>
										</div>
									</div>
									<div>
										<i class="fas fa-truck bg-orange text-white" style="padding-left: 3px;"></i>
										<div class="timeline-item">
											<span class="time"><i class="fas fa-clock"></i> 15 min</span>
											<h3 class="timeline-header no-border">Estimated Delivery time</h3>
										</div>
									</div>
									<div>
										<i class="fas fa-home bg-green"></i>
										<div class="timeline-item">
											<span class="time"><i class="fas fa-dolly-flatbed"></i> Arrived</span>
											<h3 class="timeline-header no-border"><b>To</b> your house</h3>
										</div>
									</div>
									<div>
										<i class="fas fa-check bg-gray"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-4">
					<nav class="w-100">
						<div class="nav nav-tabs" id="product-tab" role="tablist">
							<a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
						</div>
					</nav>
					<div class="tab-content p-3" id="nav-tabContent">
						<div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
							<div>
								<p>
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae condimentum erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed posuere, purus at efficitur hendrerit, augue elit lacinia arcu, a eleifend sem elit et nunc. Sed rutrum vestibulum est, sit amet cursus dolor fermentum vel. Suspendisse mi nibh, congue et ante et, commodo mattis lacus. Duis varius finibus purus sed venenatis. Vivamus varius metus quam, id dapibus velit mattis eu. Praesent et semper risus. Vestibulum erat erat, condimentum at elit at, bibendum placerat orci. Nullam gravida velit mauris, in pellentesque urna pellentesque viverra. Nullam non pellentesque justo, et ultricies neque. Praesent vel metus rutrum, tempus erat a, rutrum ante. Quisque interdum efficitur nunc vitae consectetur. Suspendisse venenatis, tortor non convallis interdum, urna mi molestie eros, vel tempor justo lacus ac justo. Fusce id enim a erat fringilla sollicitudin ultrices vel metus.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
