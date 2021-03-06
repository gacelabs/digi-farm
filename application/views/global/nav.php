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
			<a class="navbar-brand" href="<?php echo base_url(); ?>">
				<span class="hidden-xs">FarmApp</span>
				<i class="glyphicon glyphicon-home visible-xs"></i>
			</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right navbar-buttons">
				<?php if ($current_profile): /*debug($current_profile, 1);*/ ?>
				<!-- Show if user is logged in -->
					<?php if (is_farmer($current_profile)): ?>
						<li><a href="dashboard/save-product">Sell Veggies!</a></li>
					<?php endif ?>
					<li><a href="<?php echo base_url('dashboard'); ?>" style="padding-right:0;"><?php echo ucwords(get_fullname($current_profile)); ?></a></li>
				<?php else: ?>
					<li><a href="">Marketplace</a></li>
					<li><a href="login">Login / Sign up</a></li>
				<?php endif ?>
			</ul>
		</div><!-- /.navbar-collapse -->
		
	</div><!-- /.container-fluid -->
</nav>

