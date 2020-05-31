<?php
	$product = $db();
	// debug($product, 1);
?>
<?php if ($product): ?>
	<a class="btn btn-lg btn-primary m-5" href="cart/add?id=<?php echo $product['id'];?>">
		Add to cart
	</a>
<?php endif ?>