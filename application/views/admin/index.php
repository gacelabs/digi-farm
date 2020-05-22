<div class="container-fluid">
	<section class="content-header admin-content-title text-center">
		<h1>All Projects</h1>
	</section>
	<hr>
	<?php // debug($projects);?>
	<!-- Admin Content Body -->
	<?php 
		if ($projects) {
			foreach ($projects as $key => $row) {
				$channels = $this->account->check(array('id'=>$this->user->id))->get_channels($row['sub1']['data']->id);
				$this->load->view('admin/projects/index', array('project'=>$row['sub1']['data'], 'channels'=>$channels, 'accumulated'=>$accumulated[$row['sub1']['data']->id]));
			}
		}
		if (FALSE) {?>
			<p>TEST PAYMENT</p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="SFGX5HQ5Q348S">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		<?php }
	?>
</div>