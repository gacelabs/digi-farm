<?php
	$marketplace_data = $db();
	$veggies_position = $marketplace_data['veggies_position'];
	$farmers_position = $marketplace_data['farmers_position'];
	// debug($veggies_position);
	// debug($farmers_position);
?>
<?php if ($veggies_position): ?>
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-lg-12">
					<h3 class="m-0 text-dark">Veggies near you</h3>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<section class="location-slider">
						<!-- LOOP HERE -->
						<?php foreach ($veggies_position as $key => $product): ?>
							<div class="slider-item product-item">
								<a href="product/view?id=<?php echo $product['id']?>">
									<div class="card">
										<div class="card-header">
											<img src="<?php check_file_and_render($product['photo'], '300x300?text=Product');?>" class="" alt="<?php echo $product['name'];?>" style="height: 248px;">
											<div class="card-tools">
												<span class="badge badge-primary"><i class="fas fa-map-marker-alt"></i> <?php echo round($product['distance'], 2);?><?php echo strtoupper($product['unit']);?></span>
											</div>
										</div>
										<div class="card-body text-ellipsis">
											<h5><b><?php echo $product['name'];?></b></h5>
											<h4 class="zero-gap"><span class="currency">₱</span><?php echo $product['current_price']?><small style="font-size:50%;color:#aaa !important;"> / <?php echo $product['measurement']?></small></h4>
										</div>
									</div>
								</a>
							</div>
						<?php endforeach ?>
						<!-- LOOP HERE -->
					</section>
				</div>
			</div>
		</div>
	</section>
<?php endif ?>

<section class="content" style="padding:20px 0;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="container padding-zero-sm margin-bottom-15">
					<div class="division-inner box-shadow">
						<div class="row mb-2">
							<div class="col-lg-12">
								<h5 class="m-0 text-dark">Categories</h5>
							</div>
						</div>
						<section class="center category-slider">
							<div class="slider-item">
								<a href="#">
									<img src="assets/images/props/lettuce.jpg">
									<h2 class="slider-title">Lettuce</h2>
								</a>
							</div>
							<div class="slider-item">
								<a href="#">
									<img src="assets/images/props/tomatoes.jpg">
									<h2 class="slider-title">Tomatoes</h2>
								</a>
							</div>
							<div class="slider-item">
								<a href="#">
									<img src="assets/images/props/chilis.jpg">
									<h2 class="slider-title">Chilis</h2>
								</a>
							</div>
							<div class="slider-item">
								<a href="#">
									<img src="assets/images/props/eggplants.jpg">
									<h2 class="slider-title">Eggplants</h2>
								</a>
							</div>
							<div class="slider-item">
								<a href="#">
									<img src="assets/images/props/potatoes.jpg">
									<h2 class="slider-title">Potatoes</h2>
								</a>
							</div>
							<div class="slider-item">
								<a href="#">
									<img src="assets/images/props/beans.jpg">
									<h2 class="slider-title">Beans</h2>
								</a>
							</div>
							<div class="slider-item">
								<a href="#">
									<img src="assets/images/props/peppers.jpg">
									<h2 class="slider-title">Peppers</h2>
								</a>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php if ($farmers_position): ?>
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-lg-12">
					<h3 class="m-0 text-dark">Farmers nearby</h3>
				</div>
			</div>
		</div>
	</section>

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<section class="location-slider">
						<!-- LOOP Here -->
						<?php foreach ($farmers_position as $key => $farmer): ?>
							<div class="slider-item farmer-item">
								<a href="#">
									<div class="card card-success card-outline">
										<img src="<?php check_file_and_render($farmer['banner'], '1080x500?text=Banner');?>" class="farmer-item-banner" />
										<div class="box-profile">
											<div class="card-header text-center" style="margin-top:-45px;border-bottom:0 none;">
												<img class="profile-user-img img-fluid img-circle" src="<?php check_file_and_render($farmer['photo'], '80x80?text=Photo');?>" alt="User profile picture" />
											</div>
											<div class="card-footer text-center text-ellipsis" style="background-color:#fff;border-bottom-left-radius:.25rem;border-bottom-right-radius:.25rem">
												<h3 class="profile-username zero-gap"><?php echo get_fullname(['user'=>$farmer]);?></h3>
												<small class="text-grey zero-gap elem-block"><?php echo $farmer['address'];?></small>
												<span class="badge badge-primary"><i class="fas fa-map-marker-alt"></i> <?php echo round($farmer['distance'], 2);?><?php echo strtoupper($farmer['unit']);?></span>
											</div>
										</div>
									</div>
								</a>
							</div>
						<?php endforeach ?>
						<!-- LOOP Here -->
					</section>
				</div>
			</div>
		</div>
	</section>
<?php endif ?>

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-lg-12">
				<h3 class="m-0 text-dark">Best Sellers</h3>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<!-- LOOP HERE -->
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<div class="slider-item product-item">
					<a href="#">
						<div class="card">
							<div class="card-header">
								<img src="assets/images/props/lettuce.jpg" class="img-fit" alt="">
								<div class="card-tools">
									<span class="badge badge-primary"><i class="fas fa-map-marker-alt"></i> 1.3KM</span>
								</div>
							</div>
							<div class="card-body text-ellipsis">
								<h5><b>Lettuce</b></h5>
								<h4 class="zero-gap"><span class="currency">₱</span>80<small style="font-size:50%;color:#aaa !important;"> / pc</small></h4>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!-- LOOP HERE -->
		</div>
	</div>
</section>