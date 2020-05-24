
<!-- Brand Logo -->
<a href="" class="brand-link">
	<img src="assets/admin/template/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3"
	style="opacity: .8">
	<span class="brand-text font-weight-light">FarmApp</span>
</a>

<!-- Sidebar -->
<div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
	<div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div>
	<div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;"><div class="os-resize-observer"></div></div>
	<div class="os-content-glue" style="margin: 0px -7px; width: 249px; height: 651px;"></div>
	<div class="os-padding">
		<div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
			<div class="os-content" style="padding: 0px 7px; height: 100%; width: 100%;">
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
						<a href="profile/<?php print_r($current_profile['user']['id']);?>" class="d-block"><?php echo get_fullname($current_profile);?> <small><i class="fas fa-cog"></small></i></a>
					</div>
				</div>
						
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
						<li class="nav-item">
							<a href="" class="nav-link <?php active_menu(1, '');?>">
								<i class="nav-icon fas fa-store"></i>
								<p>Marketplace</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="" class="nav-link">
								<i class="fas fa-shopping-basket nav-icon"></i>
								<p>Orders <span class="right badge badge-success">23</span></p>
							</a>
						</li>
						<li class="nav-item has-treeview <?php active_menu(1, 'dashboard', true);?> <?php active_menu(1, 'inventory', true);?> <?php active_menu(1, 'orders', true);?> <?php active_menu(1, 'add-product', true);?> <?php active_menu(1, 'farm', true);?> <?php active_menu(1, 'settings', true);?>">
							<a href="javascript:;" class="nav-link <?php active_menu(1, 'dashboard');?> <?php active_menu(1, 'inventory');?> <?php active_menu(1, 'add-product');?> <?php active_menu(1, 'farm');?> <?php active_menu(1, 'settings');?>">
								<i class="nav-icon fas fa-store-alt"></i>
								<p>Farm <i class="right fas fa-angle-left"></i></p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="farm" class="nav-link <?php active_menu(1, 'farm');?>">
										<i class="fas fa-seedling nav-icon"></i>
										<p>My Farm</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="inventory" class="nav-link <?php active_menu(1, 'inventory');?> <?php active_menu(1, 'add-product');?>">
										<i class="fas fa-warehouse nav-icon"></i>
										<p>Inventory</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="dashboard" class="nav-link <?php active_menu(1, 'dashboard');?>">
										<i class="nav-icon fas fa-chart-line"></i>
										<p>Dashboard</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="settings" class="nav-link <?php active_menu(1, 'settings');?>">
										<i class="fas fa-sliders-h nav-icon"></i>
										<p>Settings</p>
									</a>
								</li>
							</ul>
						</li>

						<li class="nav-item has-treeview <?php active_menu([1,2], 'admin/stats', true);?>">
							<a href="javascript:;" class="nav-link">
								<i class="nav-icon fas fa-users-cog"></i>
								<p>Admin <i class="right fas fa-angle-left"></i></p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="admin/stats" class="nav-link <?php active_menu(2, 'stats', true);?>">
										<i class="fas fa-chart-area nav-icon"></i>
										<p>App Stats</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-header">HELP</li>
						<li class="nav-item">
							<a href="./index.html" class="nav-link">
								<i class="fas fa-question nav-icon"></i>
								<p>FAQs</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="./index.html" class="nav-link">
								<i class="fas fa-gavel nav-icon"></i>
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
		</div>
	</div>
	<div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
		<div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div></div>
	</div>
	<div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
		<div class="os-scrollbar-track"><div class="os-scrollbar-handle" style="height: 55.5366%; transform: translate(0px, 288px);"></div></div>
	</div>
	<div class="os-scrollbar-corner"></div>
</div>
<!-- /.sidebar -->
