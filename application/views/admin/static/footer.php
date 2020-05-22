		</div>
		
		<footer class="main-footer">
			<strong><a href="/admin">Send-Data</a>&copy; <span class="yearNow"></span></strong>
		</footer>

	</div>

	<script type="text/javascript" src="assets/admin/js/jquery.min.js"></script>
	<script type="text/javascript" src="assets/admin/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/admin/js/bootstrap-slider.js"></script>
	<script type="text/javascript" src="assets/admin/js/moment.min.js"></script>
	<script type="text/javascript" src="assets/public/js/ajaxq.js"></script>
	<script type="text/javascript" src="assets/admin/js/adminlte.min.js"></script>
	<script type="text/javascript" src="assets/admin/js/charts.min.js"></script>
	<?php if ((bool)strstr($_SERVER['HTTP_HOST'], 'local') == TRUE): ?>
		<script type="text/javascript" src="assets/admin/js/dpt.local.min.js" id="push-thru-scripts"></script>
	<?php else: ?>
		<script type="text/javascript" src="assets/admin/js/dpt.min.js" id="push-thru-scripts"></script>
	<?php endif ?>
	<script type="text/javascript" src="assets/admin/js/main.js"></script>
</body>
</html>