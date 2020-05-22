<!-- Admin Content Body -->
<div class="content container-fluid" id="admin-content-body">
	<div class="domain-project-content active" id="domaingoeshere">
		<section class="content-header admin-content-title" style="padding-top:0;">
			<h1 id="dashDomain"><?php echo $project->domain;?> <small>Project Summary</small></h1>
		</section>
		<hr>
		<div class="container-fluid">
			<div class="admin-content-container">
				<canvas class="barChart" project-id="<?php echo $project->id;?>" height="90"></canvas>
				<?php echo $accumulated;?>
			</div>
			<div class="admin-content-container">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Channel Details</h3>
						<!-- <div class="box-tools">
							<ul class="pagination pagination-sm no-margin pull-right">
								<li><a href="#">«</a></li>
								<li><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">»</a></li>
							</ul>
						</div> -->
					</div>
					<!-- /.box-header -->
					<div class="box-body no-padding">
						<table class="table">
							<tbody><tr>
								<th style="width: 10px">#</th>
								<th>Events:Channels</th>
								<!-- <th>Sent</th> -->
								<th style="width: 40px">Used</th>
							</tr>
							<?php if ($channels) {?>
								<?php foreach ($channels as $key => $row) {?>
									<tr>
										<td><?php echo $row['no'];?>.</td>
										<td><?php echo $row['channel'];?></td>
										<!-- <td>
											<div class="progress progress-xs">
												<div class="progress-bar progress-bar-danger" style="width: 55%"></div>
											</div>
										</td> -->
										<td><span class="badge bg-green"><?php echo $row['sent'];?> time(s)</span></td>
									</tr>
								<?php }?>
							<?php } else {?>
								<tr>
									<td colspan="100%" class="text-center">NO ACTIVITIES FOUND</td>
								</tr>
							<?php }?>
						</tbody></table>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<div class="admin-content-container">
				<h4>Package Information</h4>
				<?php
					$color = 'green'; $color_text = 'Active';
					if ($project->expired) {
						$color = 'red'; $color_text = 'Expired';
					} elseif ($project->allowed == 0) {
						$color = 'orange'; $color_text = 'Inactive';
					}
				?>
				<p><i class="fa fa-check text-success icon-left"></i><?php echo $project->package_type;?>&nbsp;&nbsp;&nbsp;&nbsp;<span class="badge bg-<?php echo $color;?>"><?php echo $color_text;?></span></p>
			</div>
		</div>
	</div>
</div>