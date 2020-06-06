<?php
	$orders = $db();
	// debug($orders, 1);
?>

<!-- Main content -->
<section class="content pt-2">
	<!-- Default box -->
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Orders</h3>
		</div>
		<div class="card-body p-0">
			<table class="table table-striped projects">
				<thead>
					<tr>
						<th>#</th>
						<th>Delivery Address</th>
						<th>Delivery Option</th>
						<th>Payment Method</th>
						<th>Product(s)</th>
						<th>Status</th>
						<th>Tender Amount</th>
						<th>Expected Delivery Date</th>
						<th>Tracking Number</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($orders): ?>
						<?php foreach ($orders as $key => $order): ?>
						<?php
							$delivery_option = get_data_table('delivery_option', 'id', $order['delivery_option_id']);
							$payment_method = get_data_table('payment_method', 'id', $order['payment_method_id']);
							$products = unserialize($order['items']);
						?>
						<tr style="cursor: pointer;" onclick="window.location.href = 'order/<?php echo $order['code'];?>'">
							<td align="center"><?php echo $key+1;?></td>
							<td><?php echo $order['address'];?></td>
							<td><?php echo $delivery_option['label'];?></td>
							<td><?php echo $payment_method['label'];?></td>
							<td>
								<ul class="list-inline">
									<?php foreach ($products as $index => $product): ?>
									<li class="list-inline-item">
										<img alt="<?php echo $product['name'];?>" class="table-avatar" src="<?php check_file_and_render($product['path'], '37x37?text=Item');?>" />
									</li>
									<?php endforeach ?>
								</ul>
							</td>
							<td><span class="badge badge-success"><?php echo $order['status'];?></span></td>
							<td data-sort="<?php echo $order['total_amount'];?>">₱<?php echo $order['total_amount'];?></td>
							<td data-sort="<?php echo strtotime($order['last_updated']);?>"><?php echo format_date($order['last_updated']);?></td>
							<td><?php echo $order['code'];?></td>
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

