		<base href="<?php echo base_url(); ?>" target="_blank">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<?php
			foreach ($meta as $key => $value) {
				echo ($value);
			}
		?>

		<title><?php echo $title; ?></title>

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
