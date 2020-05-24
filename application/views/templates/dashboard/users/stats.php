
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-lg-12">
					<h3 class="m-0 text-dark">Dashboard</h3>
				</div>
			</div>
		</div>
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Small boxes (Stat box) -->
			<div class="row">
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-info">
						<div class="inner">
							<h3>150</h3>

							<p>Orders Sold</p>
						</div>
						<div class="icon">
							<i class="ion ion-bag"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-success">
						<div class="inner">
							<h3><sup style="font-size: 20px">₱</sup>1,780</h3>

							<p>Earnings</p>
						</div>
						<div class="icon">
							<i class="ion ion-stats-bars"></i>
						</div>
						<p href="#" class="small-box-footer">May 23, 2020</p>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-warning">
						<div class="inner">
							<h3>839</h3>

							<p>Top Selling</p>
						</div>
						<div class="icon">
							<i class="ion ion-arrow-up-a"></i>
						</div>
						<p href="#" class="small-box-footer">Romaine Red Lettuce</p>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-6">
					<!-- small box -->
					<div class="small-box bg-danger">
						<div class="inner">
							<h3>65</h3>

							<p>Cancelled</p>
						</div>
						<div class="icon">
							<i class="ion ion-pie-graph"></i>
						</div>
						<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
			</div>
			<!-- /.row -->
			<!-- Main row -->
			<div class="row">
				<!-- Left col -->
				<section class="col-lg-6 connectedSortable">
					<!-- Custom tabs (Charts with tabs)-->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">
								<i class="fas fa-chart-pie mr-1"></i>
								Sales
							</h3>
							<div class="card-tools">
								<ul class="nav nav-pills ml-auto">
									<li class="nav-item">
										<a class="nav-link active" href="#sales-chart" data-toggle="tab">Line Chart</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#revenue-chart" data-toggle="tab">Time Chart</a>
									</li>
								</ul>
							</div>
						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content p-0">
								<!-- Morris chart - Sales -->
								<div class="chart tab-pane active" id="sales-chart">
									<canvas id="chart2" height="300"></canvas>                         
								</div>
								<div class="chart tab-pane" id="revenue-chart">
									<canvas id="chart1" height="300"></canvas>                         
								</div>
							</div>
						</div><!-- /.card-body -->
					</div>
					<!-- /.card -->

					<!-- Map card -->
					<div class="card bg-gradient-primary">
						<div class="card-header border-0">
							<h3 class="card-title">
								<i class="fas fa-map-marker-alt mr-1"></i>
								Visitors
							</h3>
							<!-- card tools -->
							<div class="card-tools">
								<button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
							<!-- /.card-tools -->
						</div>
						<div class="card-body">
							<div id="world-map" style="height: 250px; width: 100%;"></div>
						</div>
						<!-- /.card-body-->
						<div class="card-footer bg-transparent">
							<div class="row">
								<div class="col-4 text-center">
									<div id="sparkline-1"></div>
									<div class="text-white">Visitors</div>
								</div>
								<!-- ./col -->
								<div class="col-4 text-center">
									<div id="sparkline-2"></div>
									<div class="text-white">Online</div>
								</div>
								<!-- ./col -->
								<div class="col-4 text-center">
									<div id="sparkline-3"></div>
									<div class="text-white">Sales</div>
								</div>
								<!-- ./col -->
							</div>
							<!-- /.row -->
						</div>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.Left col -->
				<!-- right col (We are only adding the ID to make the widgets sortable)-->
				<section class="col-lg-6 connectedSortable">

					<!-- Product Movement -->
					<div class="card bg-gradient-info">
						<div class="card-header border-0">
							<h3 class="card-title">
								<i class="fas fa-th mr-1"></i>
								Product Movement
							</h3>

							<div class="card-tools">
								<button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="card-body">
							<canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
						</div>
						<!-- /.card-body -->
						<div class="card-footer bg-transparent">
							<div class="row">
								<div class="col-4 text-center">
									<input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
									data-fgColor="#39CCCC">

									<div class="text-white">Mail-Orders</div>
								</div>
								<!-- ./col -->
								<div class="col-4 text-center">
									<input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
									data-fgColor="#39CCCC">

									<div class="text-white">Online</div>
								</div>
								<!-- ./col -->
								<div class="col-4 text-center">
									<input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
									data-fgColor="#39CCCC">

									<div class="text-white">In-Store</div>
								</div>
								<!-- ./col -->
							</div>
							<!-- /.row -->
						</div>
						<!-- /.card-footer -->
					</div>
					<!-- /.card -->

					<!-- Calendar -->
					<div class="card bg-gradient-success">
						<div class="card-header border-0">
							<h3 class="card-title">
								<i class="far fa-calendar-alt"></i>
								Calendar
							</h3>
							<!-- tools card -->
							<div class="card-tools">
								<!-- button with a dropdown -->
								<button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
									<i class="fas fa-minus"></i>
								</button>
							</div>
							<!-- /. tools -->
						</div>
						<!-- /.card-header -->
						<div class="card-body pt-0">
							<!--The calendar -->
							<div id="calendar" style="width: 100%"></div>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</section>
				<!-- right col -->
			</div>
			<!-- /.row (main row) -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->