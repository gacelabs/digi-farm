
<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
	<img src="assets/admin/template/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3"
	style="opacity: .8">
	<span class="brand-text font-weight-light"><?php echo $current_profile['user']['farm_name'];?></span>
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
					<div class="image">
						<img src="assets/admin/template/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image" />
					</div>
					<div class="info">
						<a href="#" class="d-block"><?php echo get_fullname($current_profile);?></a>
					</div>
				</div>

				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
						<li class="nav-header">DASHBOARD</li>
						<li class="nav-item">
							<a href="/dashboard/" class="nav-link <?php active_menu(2, '');?>">
								<i class="nav-icon fa fa-chart-pie"></i>
								<p>
									Statistics
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="/dashboard/profile/" class="nav-link <?php active_menu(2, 'profile');?>">
								<i class="nav-icon fa fa-user"></i>
								<p>
									Profile
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="/dashboard/post-product/" class="nav-link <?php active_menu(2, 'post-product');?>">
								<i class="nav-icon fa fa-pepper-hot"></i>
								<p>
									Post product
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="/dashboard/inventory/" class="nav-link <?php active_menu(2, 'inventory');?>">
								<i class="nav-icon fa fa-warehouse"></i>
								<p>
									Inventory
								</p>
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
