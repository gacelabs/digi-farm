<?php
	$product = $db();
?>

<a class="btn btn-lg btn-primary m-5" href="/cart/add?id=<?php echo $product['id'];?>">
	Add to cart
</a>