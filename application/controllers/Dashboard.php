<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public $shall_not_pass = true;

	public function index()
	{
		$data = array(
			'meta' => array(),
			'title' => ucfirst(__CLASS__).' | Farmapp',
			'head_css' => $this->dash_defaults('head_css', [
				base_url('assets/admin/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'),
				base_url('assets/admin/template/plugins/jqvmap/jqvmap.min.css'),
				base_url('assets/admin/template/plugins/daterangepicker/daterangepicker.css'),
				base_url('assets/admin/template/plugins/summernote/summernote-bs4.css'),
			]),
			'head_js' => $this->dash_defaults('head_js'),
			'body_id' => strtolower(__CLASS__),
			'body_class' => strtolower(__CLASS__),
			'wrapper_class' => 'dashboard',
			'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
				'nav_view' => array(
					'templates/dashboard/global/nav'
				),
				'sidebar_view' => array(
					'templates/dashboard/global/sidebar'
				),
				'contentdata_view' => array(
					'templates/dashboard/users/stats'
				)
			),
			'footer_css' => $this->dash_defaults('footer_css'),
			'footer_js' => $this->dash_defaults('footer_js', [
				base_url('assets/admin/template/plugins/chart.js/Chart.min.js'),
				base_url('assets/admin/template/plugins/sparklines/sparkline.js'),
				base_url('assets/admin/template/plugins/jqvmap/jquery.vmap.min.js'),
				base_url('assets/admin/template/plugins/jqvmap/maps/jquery.vmap.usa.js'),
				base_url('assets/admin/template/plugins/jquery-knob/jquery.knob.min.js'),
				base_url('assets/admin/template/plugins/moment/moment.min.js'),
				base_url('assets/admin/template/plugins/daterangepicker/daterangepicker.js'),
				base_url('assets/admin/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'),
				base_url('assets/admin/template/plugins/summernote/summernote-bs4.min.js'),
				base_url('assets/admin/template/dist/js/pages/dashboard.js'),
				base_url('assets/admin/template/dist/js/demo.js'),
				base_url('assets/js/chartjs/Chart.bundle.min.js'),
				base_url('assets/js/chartjs/moment.min.js'),
				base_url('assets/js/chartjs/charts.js'),
			]),
			'post_body' => array(
			),
			'db' => array(

			)
		);
		$this->load->view('templates/dashboard/landing', $data);
	}

	public function profile($id=0)
	{
		$set = $this->input->post();
		if ($set) {
			if (isset($set['user'])) {
				$this->custom->save('user', $set['user'], ['id' => $id]);
			}
			if (isset($set['user_app_settings'])) {
				$user_id = $id;
				foreach ($set['user_app_settings'] as $settings_id => $values) {
					if (!isset($values['value']) AND $values['checkbox'] == 1) {
						$values['value'] = '';
					}
					$values['value'] = ($values['checkbox'] == 1 AND $values['value'] == 1) ? 'checked' : $values['value'];
					unset($values['checkbox']);
					$this->custom->save('user_app_settings', $values, ['user_id' => $user_id, 'id' => $settings_id]);
				}
			}
			if (isset($set['user_location'])) {
				foreach ($set['user_location'] as $key => $location) {
					$dataset = ['address' => $location['address']];
					$latlng = json_decode($location['latlng'], true);
					$dataset = array_merge($dataset, $latlng);
					$this->custom->save('user_location', $dataset, ['id' => $location['id']]);
				}
			}
			$this->accounts->update($id, function() {
				redirect(base_url('dashboard/profile'));
			});
			// debug($set, 1);
		} else {
			$data = array(
				'meta' => array(
					''
				),
				'title' => ucfirst(__FUNCTION__).' | Farmapp',
				'head_css' => $this->dash_defaults('head_css'),
				'head_js' => $this->dash_defaults('head_js'),
				'body_id' => __FUNCTION__,
				'body_class' => __FUNCTION__,
				'wrapper_class' => 'profile',
				'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
					'nav_view' => array(
						'templates/dashboard/global/nav'
					),
					'sidebar_view' => array(
						'templates/dashboard/global/sidebar'
					),
					'contentdata_view' => array(
						'templates/dashboard/users/profile'
					)
				),
				'footer_css' => $this->dash_defaults('footer_css'),
				'footer_js' => $this->dash_defaults('footer_js', [
					base_url('assets/js/jquery.validation.min.js'),
					base_url('assets/js/validator.js'),
					'https://maps.googleapis.com/maps/api/js?key=AIzaSyBbNbxnm4HQLyFO4FkUOpam3Im14wWY0MA&libraries=places',
					base_url('assets/js/profile.js'),
				]),
				'post_body' => array(

				),
				'db' => function() {
					$activity = $this->custom->get('activity');
					$user = $this->accounts->profile['user'];
					$this->accounts->update($user['id']);
					// debug($this->accounts->profile, 1);
					$app_settings = $this->accounts->profile['user_app_settings'];
					return [
						'profile' => $this->accounts->profile,
						'profile_dropdown' => construct($activity, 'dd', $user['activity_id']),
						'app_settings' => construct($app_settings, 'avdd'),
					];
				}
			);
			$this->load->view('templates/dashboard/landing', $data);
		}
	}

	public function inventory()
	{
		$data = array(
			'meta' => array(),
			'title' => ucfirst(__CLASS__).' | Farmapp',
			'head_css' => $this->dash_defaults('head_css'),
			'head_js' => $this->dash_defaults('head_js'),
			'body_id' => strtolower(__CLASS__),
			'body_class' => strtolower(__CLASS__),
			'wrapper_class' => 'inventory',
			'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
				'nav_view' => array(
					'templates/dashboard/global/nav'
				),
				'sidebar_view' => array(
					'templates/dashboard/global/sidebar'
				),
				'contentdata_view' => array(
					'templates/dashboard/users/inventory'
				)
			),
			'footer_css' => $this->dash_defaults('footer_css'),
			'footer_js' => $this->dash_defaults('footer_js'),
			'post_body' => array( // html elements. these are declared before </body> closing tag. use for modals, etc. example: 'folder/filename'
				''
			),
			'db' => array(

			)
		);
		$this->load->view('templates/dashboard/landing', $data);
	}

}
