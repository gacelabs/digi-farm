<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('global/page_head'); ?>
	</head>

	<body id="body" <?php echo (!empty($body_class) ? "class='".$body_class."'": ""); ?>>

		<div id="wrapper" <?php echo (!empty($wrapper_class) ? "class='".$wrapper_class."'": "" ); ?>>
			
			<section id="nav">
				<?php

					if (!empty($view['nav_view'])) {
						foreach ($view['nav_view'] as $value) {
							$this->load->view($value);
						}
					}

				?>
			</section>

			<section id="top">
				<?php

					if (!empty($view['top_view'])) {
						foreach ($view['top_view'] as $value) {
							$this->load->view($value);
						}
					}

				?>
			</section>

			<section id="middle">
				<?php

					if (!empty($view['middle_view'])) {
						foreach ($view['middle_view'] as $value) {
							$this->load->view($value);
						}
					}

				?>
			</section>

			<section id="bottom">
				<?php

					if (!empty($view['bottom_view'])) {
						foreach ($view['bottom_view'] as $value) {
							$this->load->view($value);
						}
					}

				?>
			</section>

			<section id="footer">
				<?php

					if (!empty($view['footer_view'])) {
						foreach ($view['footer_view'] as $value) {
							$this->load->view($value);
						}
					}

				?>
			</section>

		</div>

		<?php foreach ($post_body as $key => $value) { ?>
			<?php

				if (!empty($value)) {
					$this->load->view($value);
				}

			?>
		<?php }; ?>

		<?php foreach ($footer_css as $key => $value) { ?>
			<?php if (!empty($value)) { ?>
				<link rel="stylesheet" type="text/css" href="<?php echo ($value); ?>">
			<?php }; ?>
		<?php }; ?>

		<?php foreach ($footer_js as $key => $value) { ?>
			<?php if (!empty($value)) { ?>
				<script type="text/javascript" src="<?php echo ($value) ?>"></script>
			<?php }; ?>
		<?php }; ?>

	</body>
</html>