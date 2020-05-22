<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<base href="<?php echo base_url();?>">
	<title>Chat App | SendData</title>
	<link rel="icon" type="image/png" sizes="256x256" href="assets/images/icon.png">

	<link rel="stylesheet" href="assets/admin/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/admin/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/admin/css/chat.css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="assets/admin/js/html5shiv.min.js"></script>
		<script src="assets/admin/js/respond.min.js"></script>
	<![endif]-->
	<!-- <link rel="stylesheet" href="assets/admin/css/fonts.googleapis.css"> -->
</head>

<body style="background: transparent;">
	<section class="container">
		<div style="position: absolute; bottom: 0px; right: 0;">
			<div class="box direct-chat direct-chat-warning" style="margin: 0px; border-top: unset !important;">
				<div class="box-header with-border" data-widget="collapse" style="cursor: pointer;">
					<img class="img-circle img-sm" src="assets/images/icon.png">
					<h3 class="box-title hidden-lg heading" style="vertical-align: middle; margin-left: 10px; margin-top: 5px;">How can we help you?</h3>
					<h3 class="box-title hidden-xs">DPT Chat</h3>
					<!-- <div class="box-tools">
						<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="3 New Messages">3</span>
					</div> -->
				</div>
				<div class="box-body" style="">
					<div class="direct-chat-messages"></div>
				</div>
				<div class="box-footer" style="">
					<div class="input-group">
						<textarea id="message" placeholder="Type Message ..." class="form-control" style="height: 34px; resize: none;"></textarea>
						<span class="input-group-btn">
							<button type="submit" class="btn btn-warning btn-flat" id="send_data" style="margin-left: -20px; z-index: 3;">Send</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>

<div class="hide">
	<div id="theirs" class="direct-chat-msg">
		<div class="direct-chat-info clearfix">
			<div class="direct-chat-timestamp text-center">23 Jan 2:00 pm</div>
		</div>
		<img class="direct-chat-img" src="assets/images/profiles/Administrator-1-YJ6TG.jpg" alt="Message User Image">
		<div class="direct-chat-text pull-left" style="margin-left: 10px !important;"></div>
	</div>
	<div id="mine" class="direct-chat-msg right">
		<div class="direct-chat-info clearfix">
			<div class="direct-chat-timestamp text-center">23 Jan 2:05 pm</div>
		</div>
		<img class="direct-chat-img" src="assets/images/profiles/Administrator-1-YJ6TG.jpg" alt="Message User Image">
		<div class="direct-chat-text pull-right" style="margin-right: 10px !important;"></div>
	</div>
</div>

<script type="text/javascript" src="assets/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/admin/js/adminlte.min.js"></script>
<?php if ((bool)strstr($_SERVER['HTTP_HOST'], 'local') == TRUE) { ?>
	<script type="text/javascript" src="assets/admin/js/dpt.local.min.js" id="push-thru-scripts"></script>
<?php } else { ?>
	<script type="text/javascript" src="assets/admin/js/dpt.min.js" id="push-thru-scripts"></script>
<?php } ?>
<script type="text/javascript" src="assets/admin/js/chat-app.js"></script>
</html>