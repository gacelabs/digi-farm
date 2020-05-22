<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel text-white text-center">
			<p class="zero-gaps"><?php echo $user->admin;?></p>
		</div>
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">PROJECTS</li>
			<?php if ($projects): ?>
				<?php foreach($projects as $project => $rows) { ?>
					<?php $split = explode('|', $project); ?>
					<li class="treeview<?php echo $split[0] == $this->uri->segment(2) ? ' menu-open active' : '';?>" target-dash="<?php echo $project; ?>">
						<a href="projects/<?php echo $split[0];?>"><i class="fa fa-globe"></i> <span id="origin-name-<?php echo $split[0];?>"><?php echo $split[1];?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu"<?php echo $split[0] == $this->uri->segment(2) ? ' style="display: block;"' : '';?>>
							<?php foreach($rows as $row => $val) { ?>
							<li><a href="projects/<?php echo $split[0];?>"><i class="<?php echo $val['icon'] ?>"></i> <span><?php echo $val['label']; ?></span></a></li>
							<?php } ?>
						</ul>
					</li>
				<?php } ?>
			<?php endif ?>
		</ul>
		<ul class="sidebar-menu" data-widget="tree">
			<?php foreach($menus as $name => $menu) { ?>
				<li class="header"><?php echo strtoupper($name);?></li>
				<?php foreach($menu as $nav => $row) { ?>
					<li class="<?php echo $row['active'];?>"><a href="<?php echo $row['link']; ?>"><i class="<?php echo $row['icon']; ?>"></i> <span><?php echo $row['label']; ?></span></a></li>
				<?php } ?>
			<?php } ?>
		</ul>
	</section>
</aside>

<div class="content-wrapper">