<?php
	$carts = $db();
	// debug($carts, 1);
?>

<?php
	$carts = $db();
	// debug($carts, 1);
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
										<input class="custom-control-input" type="radio" id="delivery_lalamove" name="delivery_option" value="0">
										<label for="delivery_lalamove" class="custom-control-label">Lalamove + <span class="currency">₱</span> 100</label>
									</div>

									<!-- <select class="form-control" id="delivery_option_id" name="delivery_option_id" required="required">
										<option value="0">Select</option>
										<option value="1">Lalamove</option>
									</select> -->
								</div>
								<hr>
							</div>


							<div class="d-none" id="step_2">
								<p>Payment Method</p>
								<div class="form-group">
									<div class="custom-control custom-checkbox">
										<input class="custom-control-input" type="radio" id="payment_cod" name="payment_option" value="0">
										<label for="payment_cod" class="custom-control-label">COD + <span class="currency">₱</span> 50 <i class="fas fa-question-circle"></i></label>
									</div>
								</div>

								<!-- <select id="payment_method_id" name="payment_method_id" required="required">
									<option value="0">Select</option>
									<option value="1">Cash on delivery</option>
									<option value="2">Paypal (Credit / Debit)</option>
								</select> -->
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
											<li class="d-none" id="delivery_fee" data-price="15">
												<label>Delivery fee</label>
												₱15 <!-- SAMPLE LANG -->
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