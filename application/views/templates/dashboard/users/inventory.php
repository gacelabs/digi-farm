<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-lg-12">
				<h1>Inventory</h1>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<a href="dashboard/add-product" class="btn btn-sm btn-primary">Add a product</a>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
							<div class="row">
								<div class="col-sm-12 col-md-6">
									<div class="dataTables_length" id="example1_length">
										<label>Show entries
											<select name="example1_length" aria-controls="example1" class="custom-select custom-select-sm form-control form-control-sm">
												<option value="10">10</option>
												<option value="25">25</option>
												<option value="50">50</option>
												<option value="100">100</option>
											</select>
										</label>
									</div>
								</div>
								<div class="col-sm-12 col-md-6">
									<div id="tablesearch_filter" class="dataTables_filter float-right">
										<label>Search:<input type="search" id="search" name="search" class="form-control form-control-sm" placeholder="" aria-controls="tablesearch">
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<table id="product-list" class="table table-bordered table-striped dataTable dtr-inline" role="grid" aria-describedby="product-list_info">
										<thead>
											<tr role="row">
												<th class="sorting" tabindex="0" aria-controls="product-list" rowspan="1" colspan="1">Featured Photo</th>
												<th class="sorting" tabindex="0" aria-controls="product-list" rowspan="1" colspan="1">Product Title</th>
												<th class="sorting" tabindex="0" aria-controls="product-list" rowspan="1" colspan="1">Measurement</th>
												<th class="sorting" tabindex="0" aria-controls="product-list" rowspan="1" colspan="1">Price</th>
												<th class="sorting" tabindex="0" aria-controls="product-list" rowspan="1" colspan="1">In Stock</th>
												<th class="sorting_asc" tabindex="0" aria-controls="product-list" rowspan="1" colspan="1" aria-sort="ascending">Posted</th>
												<th class="sorting" tabindex="0" aria-controls="product-list" rowspan="1" colspan="1">Status</th>
											</tr>
										</thead>
										<tbody>
											<tr role="row" class="odd">
												<td tabindex="0" class="sorting_1">Gecko</td>
												<td>Firefox 1.0</td>
												<td>Win 98+ / OSX.2+</td>
												<td>1.7</td>
												<td>A</td>
												<td>A</td>
												<td>
													<select name="example1_length" aria-controls="example1" class="custom-select custom-select-sm form-control form-control-sm">
														<option value="In Stock">In Stock</option>
														<option value="Sold Out">Sold Out</option>
														<option value="Inactive">Inactive</option>
													</select>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 col-md-5">
									<div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
								</div>
								<div class="col-sm-12 col-md-7">
									<div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
										<ul class="pagination">
											<li class="paginate_button page-item previous disabled" id="example1_previous">
												<a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
											</li>
											<li class="paginate_button page-item active">
												<a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">1</a>
											</li>
											<li class="paginate_button page-item ">
												<a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">2</a>
											</li>
											<li class="paginate_button page-item ">
												<a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0" class="page-link">3</a>
											</li>
											<li class="paginate_button page-item next" id="example1_next">
												<a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div>
</section>

