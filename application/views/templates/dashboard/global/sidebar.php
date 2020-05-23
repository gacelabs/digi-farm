
<!-- Brand Logo -->
<a href="" class="brand-link">
	<img src="assets/admin/template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
	style="opacity: .8">
	<span class="brand-text font-weight-light">Farmapp</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
	<!-- Sidebar user panel (optional) -->
	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
		<?php
			$fullName = explode(" ", ucwords(get_fullname($current_profile)));
			$initials = "";
			foreach ($fullName as $w) {
				$initials .= $w[0];
			}
		?>
		<div class="image">
			<img src="http://placehold.it/160x160?text=<?php echo $initials; ?>" class="img-circle elevation-2" alt="">
		</div>
		<div class="info">
			<a href="#" class="d-block"><?php echo ucwords(get_fullname($current_profile)); ?></a>
		</div>
	</div>

	<!-- Sidebar Menu -->
	<nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

			<li class="nav-item">
				<a href="dashboard" class="nav-link <?php echo $body_class=="profile"? "dashboard": ""; ?>">
					<i class="nav-icon fas fa-chart-line"></i>
					<p>Dashboard</p>
				</a>
			</li>

			<li class="nav-item">
				<a href="dashboard/profile" class="nav-link <?php echo $body_class=="profile"? "active": ""; ?>">
					<i class="nav-icon fas fa-address-card"></i>
					<p>Profile</p>
				</a>
			</li>

			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-boxes"></i>
					<p>Products <i class="right fas fa-angle-left"></i></p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Farm Stats</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Dashboard v2</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Dashboard v3</p>
						</a>
					</li>
				</ul>
			</li>

			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-users-cog"></i>
					<p>Admin <i class="right fas fa-angle-left"></i></p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="./index.html" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>App Stats</p>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-header">HELP</li>
			<li class="nav-item">
				<a href="./index.html" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>FAQs</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="./index.html" class="nav-link">
					<i class="far fa-circle nav-icon"></i>
					<p>Policies</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="sign_out" class="nav-link">
					<i class="fas fa-sign-out-alt nav-icon"></i>
					<p>Log out</p>
				</a>
			</li>
		</ul>
	</nav>
	<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->