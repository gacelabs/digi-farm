<?php
	$carts = $db();
	// debug($carts, 1);
?>
<!-- Main content -->
<section class="content pt-2">
	<!-- Default box -->
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Cart</h3>
			<div class="card-tools">
				<a href="" class="btn btn-sm btn-primary">
					<i class="fas fa-shopping-bag"></i>&nbsp;&nbsp;Continue Shopping
				</a>
				<a href="cart/checkout" class="btn btn-sm btn-success">
					<i class="fas fa-cash-register"></i>&nbsp;&nbsp;CHECKOUT
				</a>
				<span class="badge badge-warning navbar-badge"><b><?php echo cart_session('count');?></b></span>
			</div>
		</div>
		<div class="card-body p-0">
			<table class="table table-striped projects">
				<thead>
					<tr>
						<th style="width: 1%;">
							#
						</th>
						<th>
							Product Name
						</th>
						<th>
							Cart Items
						</th>
						<th>
							Quantity
						</th>
						<th>
							Progress
						</th>
						<th class="text-center">
							Status
						</th>
						<th style="width: 30%;"></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($carts):
						$row = 0;
						?>
						<?php foreach ($carts as $key => $product): ?>
							<tr data-rowid="<?php echo $key;?>">
								<td><?php echo $row+=1;?></td>
								<td>
									<a href="product/<?php echo $product['pos'];?>/<?php echo $product['id'];?>/<?php echo clean_string_name($product['name']);?>">
										<?php echo $product['name'];?>
									</a>
									<br />
									<small>
										<?php $datetime = explode('.', $product['added']);?>
										Created | <?php echo date('F j, Y g:i a', strtotime($datetime[0]));?>
									</small>
								</td>
								<td>
									<ul class="list-inline">
										<li class="list-inline-item">
											<img alt="Avatar" class="table-avatar" src="<?php check_file_and_render($product['path'], '37x37?text= ?');?>" />
										</li>
									</ul>
								</td>
								<td>
									<?php echo $product['qty'];?>
								</td>
								<td class="project_progress">
									<?php
										$progress = 10;
										if (isset($product['status']) AND $product['status'] != 'Added') {
											$progress = 100;
										}
									?>
									<div class="progress progress-sm">
										<div class="progress-bar bg-green" role="progressbar" aria-volumenow="<?php echo $progress;?>" aria-volumemin="0" aria-volumemax="100" style="width: <?php echo $progress;?>%;"></div>
									</div>
									<small>
										<?php echo $progress;?>% Complete
									</small>
								</td>
								<td class="project-state">
									<?php
										$status = 'Added';
										if (isset($product['status'])) {
											$status = $product['status'];
										}
									?>
									<span class="badge badge-success"><?php echo $status;?></span>
								</td>
								<td class="project-actions text-right">
									<a href="cart/add?id=<?php echo $product['id'];?>" class="btn btn-success btn-sm" href="#">
										<i class="fas fa-plus"> </i>
									</a>
									<a href="cart/less/<?php echo $key;?>" class="btn btn-danger btn-sm" href="#">
										<i class="fas fa-minus"> </i>
									</a>
									<b>|</b>
									<a href="javascript:confirm('Sure you want to remove this item?') ? window.location = 'cart/remove/<?php echo $key;?>' : void(0)" class="btn btn-danger btn-sm" href="#">
										<i class="fas fa-trash"> </i>
									</a>
								</td>
							</tr>
						<?php endforeach ?>
					<?php else: ?>
						<tr>
							<td colspan="100%" class="text-center">No records</td>
						</tr>
					<?php endif ?>
				</tbody>
			</table>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</section>
<!-- /.content -->
