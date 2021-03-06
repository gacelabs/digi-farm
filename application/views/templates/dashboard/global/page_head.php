<base href="<?php echo base_url();?>">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
	foreach ($meta as $key => $value) {
		echo ($value);
	}
?>

<title><?php echo $title; ?></title>
<style type="text/css">
	.error {
		border: 1px solid #f35757 !important;
		padding-right: 2.25rem;
		background-image: url('assets/admin/images/error.svg');
		background-repeat: no-repeat;
		background-position: right calc(.375em + .1875rem) center;
		background-size: calc(.75em + .375rem) calc(.75em + .375rem);
	}
</style>
<script type="text/javascript">
	var currPage = "<?php echo $body_id;?>-page";
	var currLatLng = <?php echo json_encode($this->latlng);?>;
</script>

<?php foreach ($head_css as $key => $value) { ?>
	<?php if (!empty($value)) { ?>
		<link rel="stylesheet" type="text/css" href="<?php echo ($value); ?>">
	<?php }; ?>
<?php }; ?>

<?php foreach ($head_js as $key => $value) { ?>
	<?php if (!empty($value)) { ?>
		<script type="text/javascript" src="<?php echo ($value); ?>"></script>
	<?php }; ?>
<?php }; ?>

<style type="text/css">
	.nav.nav-treeview {
		padding-left: 25px;
	}
	.save_product .content-wrapper {
		padding-bottom: 30px;
	}
</style>
