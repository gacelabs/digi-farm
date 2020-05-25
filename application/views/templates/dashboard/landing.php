<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $this->load->view('templates/dashboard/global/page_head'); ?>
		<style type="text/css">
			.error {
				border-color: #f35757;
				padding-right: 2.25rem;
				background-image: url('assets/admin/images/error.svg');
				background-repeat: no-repeat;
				background-position: right calc(.375em + .1875rem) center;
				background-size: calc(.75em + .375rem) calc(.75em + .375rem);
			}
			.elem-block {
				width: 100%;
				min-width: 100%;
			}
			.form-control.border-bottom {
				background-color: transparent !important;
				border: 0 none !important;
				border-bottom: 2px solid #fff !important;
				border-radius: 0 !important;
			}
			.select2-container--default .select2-selection--multiple .select2-selection__choice {
				background-color: #007bff;
				border-color: #006fe6;
				color: #fff;
				padding: 0 10px;
				margin-top: .31rem;
			}
			.select2-container .select2-selection--single {
				height: 38px !important;
			}
			.select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple {
				border-color: #ced4da;
			}
			.select2-container--default .select2-selection--single .select2-selection__arrow {
				top: 5px;
				right: 5px
			}
		</style>
		<script type="text/javascript">
			var currPage = "<?php echo $body_id;?>-page";
		</script>
	</head>

	<body id="<?php echo $body_id;?>-page" <?php echo (!empty($body_class) ? "class='".$body_class." layout-navbar-fixed layout-fixed'": ""); ?>>

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
				<?php echo active_menu(2, 'dashboard');?>
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
			<!-- <aside class="control-sidebar control-sidebar-dark"> -->
				<!-- Control sidebar content goes here -->
			<!-- </aside> -->
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