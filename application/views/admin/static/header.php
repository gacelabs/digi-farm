<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<base href="<?php echo base_url();?>">
	<title>Admin Dashboard | Send-Data</title>
	<link rel="icon" type="image/png" sizes="256x256" href="assets/images/icon.png">

	<link rel="stylesheet" href="assets/admin/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/admin/css/bootstrap-slider.css">
	<link rel="stylesheet" href="assets/admin/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/admin/css/ionicons.min.css">
	<link rel="stylesheet" href="assets/admin/css/AdminLTE.min.css">
	<link rel="stylesheet" href="assets/admin/css/skin-black.min.css">
	<link rel="stylesheet" href="assets/admin/css/style.css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
  	<script src="assets/admin/js/html5shiv.min.js"></script>
  	<script src="assets/admin/js/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="assets/admin/css/fonts.googleapis.css">
	<script type="text/javascript" id="main-script">
		var oUser = <?php echo (isset($this->user)) ? json_encode($this->user) : 'null';?>;
		var oUserProjects = <?php echo (isset($this->projects)) ? json_encode($this->projects) : 'null';?>;
		var APP_KEY = '<?php echo APP_KEY;?>';
		var pushthru = null;
		var oLicense = <?php echo json_encode(unserialize(PAYLOAD_LICENSE));?>;
		var DEFAULT_PAYLOAD_FEE = <?php echo (float)DEFAULT_PAYLOAD_FEE;?>;
		var MAX_FREE_PAYLOAD = <?php echo MAX_FREE_PAYLOAD;?>;
	</script>
</head>

<body class="hold-transition skin-black sidebar-mini">
	<script type="text/javascript">
		(function(d, s, id) {
			var js, dptjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = 'http://local.app.send-data/dpt_sdk/66CD77215D7C92B6FD862BAEB831AF3A';
			dptjs.parentNode.insertBefore(js, dptjs);
		}(document, 'script', 'dpt-chat-sdk'));
	</script>
	<div class="dpt-chat" page_id="1"></div>

	<div class="toast-overlay">
		<div class="toast">
			<div class="toast-header">
				<strong class="mr-auto">Toast</strong>
				<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="toast-body">
				Hello, world! This is a toast message.
			</div>
			<div class="toast-footer">
				<div class="btn-group pull-right">
					<button class="btn btn-xs" style="display: none;">Save</button>
					<button class="btn btn-danger btn-xs" style="display: none;">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<div class="wrapper">
		<?php if ($this->uri->segment(1) != 'admin_login'): ?>
			<header class="main-header">
				<a href="/admin" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><img src="assets/images/icon.png" style="width: 40px;"></span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><img src="assets/images/icon.png" style="width: 50px; margin-left: -30px;"><b>Send-Data</b></span>
				</a>
				<nav class="navbar navbar-static-top" role="navigation">
					<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
				</nav>
			</header>
		<?php endif ?>
