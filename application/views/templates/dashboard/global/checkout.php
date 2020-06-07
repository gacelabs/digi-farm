<?php
	$carts = $db();
	// debug($carts, 1);
	$delivery_options = get_data_table('delivery_option');
	$payment_methods = get_data_table('payment_method');
?>
<section class="content" style="padding-top: 20px;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="card card-outline card-warning">
					<div class="card-header">
						<h3 class="card-title">Checkout</h3>
					</div>
					<form action="cart/place-order" method="post" id="save-product" class="form-validate">
						<div class="card-body">
							<div id="step_1">
								<p>Delivery Options</p>
								<div class="form-group">
									<div class="custom-control custom-checkbox">
										<?php foreach ($delivery_options as $key => $option): ?>
											<input class="custom-control-input delivery_option" type="radio" id="delivery_option_id<?php echo $option['id'];?>" name="delivery_option_id" value="<?php echo $option['id'];?>">
											<label for="delivery_option_id<?php echo $option['id'];?>" class="custom-control-label"><?php echo $option['label'];?> + <span class="currency">₱</span> 100</label>
											<br>
										<?php endforeach ?>
									</div>
								</div>
								<hr>
							</div>


							<div class="d-none" id="step_2">
								<p>Payment Method</p>
								<div class="form-group">
									<div class="custom-control custom-checkbox">
										<?php foreach ($payment_methods as $key => $method): ?>
											<input class="custom-control-input payment_method" type="radio" id="payment_method_id<?php echo $method['id'];?>" name="payment_method_id" value="<?php echo $method['id'];?>">
											<label for="payment_method_id<?php echo $method['id'];?>" class="custom-control-label"><?php echo $method['label'];?> + <span class="currency">₱</span> 50 <i class="fas fa-question-circle"></i></label>
											<br>
										<?php endforeach ?>
									</div>
								</div>
								<hr>
							</div>

							<div id="step_details">
								<div class="col">
									<p>Order Details</p>
									<?php if ($carts):
										$total_amount = 0;
										?>
										<ul>
											<?php foreach ($carts as $key => $product): ?>
												<li>
													<label>Item</label>
													<?php echo $product['name'];?>
												</li>
												<li>
													<img alt="Avatar" class="table-avatar" src="<?php check_file_and_render($product['path'], '37x37?text= ?');?>" />
												</li>
												<li>
													<label>Price</label>
													₱<?php echo $product['price'];?>
												</li>
												<li>
													<label>Quantity</label>
													<?php echo $product['qty'];?>
												</li>
												<li>
													<label>Total</label>
													₱<?php echo $product['subtotal'];?>
												</li>
												<?php
													$total_amount += (float)$product['subtotal'];
												?>
											<?php endforeach ?>
											<li>
												<label>Sub total</label>
												₱<span id="subtotal"><?php echo $total_amount;?></span>
											</li>
											<li class="d-none" id="delivery_fee" data-price="90">
												<label>Delivery fee</label>
												₱90 <!-- SAMPLE LANG -->
											</li>
											<li class="d-none" id="transaction_fee" data-price="60">
												<label>Transaction fee</label>
												₱60
											</li>
											<li>
												<label>Total amount</label>
												₱<span id="total_amount"><?php echo $total_amount;?></span>
											</li>
										</ul>
									<?php else: ?>
										<div>NO TRANSACTIONS</div>
									<?php endif ?>
								</div>
							</div>

							<div class="row d-none" id="step_3">
								<div class="col">
									<button type="submit">Proceed</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- <form action="cart/place-order" method="post" id="save-product" class="form-validate">
	<div class="row" id="step_1">
		<div class="col">
			<h1>Delivery Options</h1>
			<select id="delivery_option_id" name="delivery_option_id" required="required">
				<option value="0">Select</option>
				<option value="1">Lalamove</option>
			</select>
		</div>
	</div>

	<div class="row d-none" id="step_2">
		<div class="col">
			<h1>Payment Method</h1>
			<select id="payment_method_id" name="payment_method_id" required="required">
				<option value="0">Select</option>
				<option value="1">Cash on delivery</option>
				<option value="2">Paypal (Credit / Debit)</option>
			</select>
		</div>
	</div>

	<div class="row" id="step_details">
		<div class="col">
			<h1>Order Details</h1>
			<?php if ($carts):
				$total_amount = 0;
				?>
				<ul>
					<?php foreach ($carts as $key => $product): ?>
						<li>
							<label>Item</label>
							<?php echo $product['name'];?>
						</li>
						<li>
							<img alt="Avatar" class="table-avatar" src="<?php check_file_and_render($product['path'], '37x37?text= ?');?>" />
						</li>
						<li>
							<label>Price</label>
							₱<?php echo $product['price'];?>
						</li>
						<li>
							<label>Quantity</label>
							<?php echo $product['qty'];?>
						</li>
						<li>
							<label>Total</label>
							₱<?php echo $product['subtotal'];?>
						</li>
						<?php
							$total_amount += (float)$product['subtotal'];
						?>
					<?php endforeach ?>
					<li>
						<label>Sub total</label>
						₱<span id="subtotal"><?php echo $total_amount;?></span>
					</li>
					<li class="d-none" id="delivery_fee" data-price="15">
						<label>Delivery fee</label>
						₱15  SAMPLE LANG 
					</li>
					<li class="d-none" id="transaction_fee" data-price="10">
						<label>Transaction fee</label>
						₱10
					</li>
					<li>
						<label>Total amount</label>
						₱<span id="total_amount"><?php echo $total_amount;?></span>
					</li>
				</ul>
			<?php else: ?>
				<div>NO TRANSACTIONS</div>
			<?php endif ?>
		</div>
	</div>

	<div class="row d-none" id="step_3">
		<div class="col">
			<button type="submit">Proceed</button>
		</div>
	</div>
</form> -->