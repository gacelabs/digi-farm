<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('templates/dashboard/global/page_head'); ?>
	</head>

	<body id="body" <?php echo (!empty($body_class) ? "class='".$body_class."'": ""); ?>>

		<div class="wrapper" <?php echo (!empty($wrapper_class) ? "class='".$wrapper_class."'": "" ); ?>>

			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<?php
				if (!empty($view['nav_view'])) {
					foreach ($view['nav_view'] as $value) {
						$this->load->view($value);
					}
				}
			?>
			</nav>
			<!-- /.navbar -->
			
			<!-- Main Sidebar Container -->
			<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<?php
				if (!empty($view['sidebar_view'])) {
					foreach ($view['sidebar_view'] as $value) {
						$this->load->view($value);
					}
				}
			?>
			</aside>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
			<?php
				if (!empty($view['contentdata_view'])) {
					foreach ($view['contentdata_view'] as $value) {
						$this->load->view($value);
					}
				}
			?>
			</div>
			<!-- /.content-wrapper -->

			<?php $this->load->view('templates/dashboard/global/page_footer'); ?>

			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
				<!-- Control sidebar content goes here -->
			</aside>
			<!-- /.control-sidebar -->

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
				<?php if ($key == 1): ?>
					<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
					<script>
						$.widget.bridge('uibutton', $.ui.button)
					</script>
					<!-- Bootstrap 4 -->
				<?php endif ?>
			<?php }; ?>
		<?php }; ?>

	</body>
</html>