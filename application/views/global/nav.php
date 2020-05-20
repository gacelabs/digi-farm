<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand hidden-xs" href="<?php echo base_url(); ?>">FarmApp</a>
			<form class="navbar-form navbar-left hidden-lg hidden-md hidden-sm">
				<div class="input-group input-rounded">
					<input type="text" class="form-control" placeholder="Lettuce...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Find</button>
					</span>
				</div>
			</form>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<form class="navbar-form navbar-left hidden-xs">
				<div class="input-group input-rounded">
					<input type="text" class="form-control" placeholder="Lettuce...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Find</button>
					</span>
				</div>
			</form>
			<ul class="nav navbar-nav navbar-right navbar-buttons">
				<li><a href="#">Login / Sign up</a></li>
				<!-- Show if user is logged in
					<li><a href="<?php echo base_url('admin/sell-product'); ?>">Sell Product</a></li>
					<li><a href="<?php echo base_url('logout'); ?>">Log out</a></li>
				-->
			</ul>
		</div><!-- /.navbar-collapse -->
		
	</div><!-- /.container-fluid -->
</nav>

