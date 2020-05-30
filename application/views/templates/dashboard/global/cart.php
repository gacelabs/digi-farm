<?php
	$carts = $db();
	// debug($carts);
?>
<!-- Main content -->
<section class="content pt-2">
	<!-- Default box -->
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Cart</h3>
			<div class="card-tools">
				<a href="/" class="btn btn-sm btn-primary">
					<i class="fas fa-shopping-bag"></i> Continue Shopping
				</a>
				<!-- <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
					<i class="fas fa-times"></i>
				</button> -->
			</div>
		</div>
		<div class="card-body p-0">
			<table class="table table-striped projects">
				<thead>
					<tr>
						<th style="width: 1%;">
							#
						</th>
						<th style="width: 30%;">
							Product Name
						</th>
						<th style="width: 20%;">
							Cart Items
						</th>
						<th>
							Progress
						</th>
						<th style="width: 8%;" class="text-center">
							Status
						</th>
						<th style="width: 20%;"></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($carts):
						$row = 0;
						?>
						<?php foreach ($carts as $key => $cart): ?>
							<tr data-rowid="<?php echo $key;?>">
								<td><?php echo $row+=1;?></td>
								<td>
									<a href="/product/view?id=<?php echo $cart['id'];?>">
										<?php echo $cart['name'];?>
									</a>
									<br />
									<small>
										<?php $datetime = explode('.', $cart['added']);?>
										Created | <?php echo date('F j, Y g:i a', strtotime($datetime[0]));?>
									</small>
								</td>
								<td>
									<ul class="list-inline">
										<li class="list-inline-item">
											<img alt="Avatar" class="table-avatar" src="<?php check_file_and_render($cart['path'], '37x37?text= ?');?>" />
										</li>
									</ul>
								</td>
								<td class="project_progress">
									<div class="progress progress-sm">
										<div class="progress-bar bg-green" role="progressbar" aria-volumenow="57" aria-volumemin="0" aria-volumemax="100" style="width: 57%;"></div>
									</div>
									<small>
										57% Complete
									</small>
								</td>
								<td class="project-state">
									<?php
										$status = 'Added';
										if (isset($cart['status'])) {
											$status = $cart['status'];
										}
									?>
									<span class="badge badge-success"><?php echo $status;?></span>
								</td>
								<td class="project-actions text-right">
									<a class="btn btn-primary btn-sm" href="#">
										<i class="fas fa-folder"> </i>
										Checkout
									</a>
									<!-- <a class="btn btn-info btn-sm" href="#">
										<i class="fas fa-pencil-alt"> </i>
										Edit
									</a> -->
									<a href="/cart/remove/<?php echo $key;?>" class="btn btn-danger btn-sm" href="#">
										<i class="fas fa-trash"> </i>
										Cancel
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
