<?php
	$order = $db();
	// debug($order, 1);
	$profile = $this->accounts->profile;
	$user = $profile['user'];
?>

<section class="content pt-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<?php if ($order == false): ?>
					<div class="callout callout-info">
						<h5><i class="fas fa-info"></i> Alert:</h5>
						No Such Order
					</div>
				<?php else: ?>
					<!-- Main content -->
					<div class="invoice p-3 mb-3">
						<!-- title row -->
						<div class="row">
							<div class="col-12">
								<h4>
									<span class="text-info">Order #<?php echo $order['code'];?></span>
									<small class="float-right">Date: <?php echo format_date($order['created']);?></small>
								</h4>
							</div>
							<!-- /.col -->
						</div>
						<?php
							$from_user = get_data_table('user', 'id', $order['from_user_id']);
							$products = unserialize($order['items']);
							// debug($products, 1);
						?>
						<!-- info row -->
						<div class="row invoice-info">
							<!-- /.col -->
							<div class="col-sm-4 invoice-col">
								To
								<address>
									<strong><?php echo get_fullname(['user' => $from_user]);?></strong><br>
									<?php echo ucwords($order['address']);?><br>
									<!-- Phone: <?php // echo $from_user['phone_number'];?><br> -->
									Email: <?php echo $from_user['email_address'];?>
								</address>
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
						<!-- Table row -->
						<div class="row">
							<div class="col-12 table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Qty</th>
											<th>Product</th>
											<th>Measurement</th>
											<th>Subtotal</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($products as $index => $product): ?>
										<tr>
											<td><?php echo $product['qty'];?></td>
											<td><?php echo ucwords($product['name']);?></td>
											<td><?php echo $product['options']['measurement'];?></td>
											<td>₱<?php echo $product['subtotal'];?></td>
										</tr>
										<?php endforeach ?>
									</tbody>
								</table>
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->

						<div class="row">
							<!-- accepted payments column -->
							<div class="col-6">
								<p class="lead">Payment Methods:</p>
								<img src="assets/admin/template/dist/img/credit/visa.png" alt="Visa">
								<img src="assets/admin/template/dist/img/credit/mastercard.png" alt="Mastercard">
								<img src="assets/admin/template/dist/img/credit/american-express.png" alt="American Express">
								<img src="assets/admin/template/dist/img/credit/paypal2.png" alt="Paypal">

								<p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
									Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
									plugg
									dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
								</p>
							</div>
							<!-- /.col -->
							<div class="col-6">
								<p class="lead">Amount Due 2/22/2014</p>

								<div class="table-responsive">
									<table class="table">
										<tr>
											<th style="width:50%">Subtotal:</th>
											<td>₱<?php echo $order['subtotal'];?></td>
										</tr>
										<tr>
											<th>Delivery Fee</th>
											<td>₱<?php echo $order['delivery_fee'];?></td>
										</tr>
										<tr>
											<th>Cash Handling:</th>
											<td>₱<?php echo $order['cash_handling'];?></td>
										</tr>
										<tr>
											<th>Tender Amount:</th>
											<td>₱<?php echo $order['total_amount'];?></td>
										</tr>
									</table>
								</div>
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
						<!-- this row will not appear when printing -->
						<div class="row no-print">
							<div class="col-12">
								<!-- <a href="" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a> -->
								<button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
									Payment
								</button>
								<!-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
									<i class="fas fa-download"></i> Generate PDF
								</button> -->
							</div>
						</div>
					</div>
				<?php endif ?>
				<!-- /.invoice -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->