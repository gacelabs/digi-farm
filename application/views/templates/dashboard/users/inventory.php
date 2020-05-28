<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-lg-12">
				<h3 class="m-0 text-dark">Inventory</h3>
			</div>
		</div>
	</div>
</section>
<?php
	$inventory = $db();
	// debug($inventory);
	$products = $inventory['products'];
?>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<a href="save-product" class="btn btn-sm btn-primary">Add a product</a>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<table id="product-list" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Featured Photo</th>
									<th>Product Title</th>
									<th>Measurement</th>
									<th>Price</th>
									<th>In Stock</th>
									<th>Posted</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($products): ?>
									<?php foreach ($products as $key => $product): ?>
									<tr style="cursor: pointer;" onclick="window.location.href = 'save-product/<?php echo $product['id'];?>'">
										<td align="center">
											<img class="img-responsive elevation-2" src="<?php echo $product['photo'];?>" style="width: 3rem;">
										</td>
										<td><?php echo $product['name'];?></td>
										<td><?php echo $product['measurement'];?></td>
										<td><?php echo $product['current_price'];?></td>
										<td><?php echo $product['stocks'];?></td>
										<td><?php echo $product['created'];?></td>
										<td><?php echo $product['status'];?></td>
									</tr>
									<?php endforeach ?>
								<?php endif ?>
							</tbody>
						</table>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div>
</section>

