<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public $shall_not_pass = true;

	public function __construct()
	{
		parent::__construct();
		// debug($this->accounts->profile['user'], 1);
		if ($this->accounts->profile['user']['farmer'] == 0) {
			if (in_array($this->router->method, ['index','inventory','save_product','my_farm','settings'])) {
				redirect(base_url());
			}
		}
	}

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
			$user_id = $id; $message = '';
			$user = $this->accounts->profile['user'];
			if ($id == $user['id']) {
				// debug($set, 1);
				if (isset($set['user'])) {
					/*if (!isset($set['user']['farmer'])) {
						$set['user']['farmer'] = 0;
					} else {
						$set['user']['farmer'] = (bool)$set['user']['farmer'];
					}*/
					$this->custom->save('user', $set['user'], ['id' => $id]);
				}
				if (isset($set['user_app_settings'])) {
					foreach ($set['user_app_settings'] as $settings_id => $values) {
						if (isset($values['type'])) {
							if (!isset($values['value']) AND $values['type'] > 0) {
								$values['value'] = '';
							}
							$values['value'] = ($values['type'] > 0 AND $values['value'] == 1) ? 'checked' : $values['value'];
							unset($values['type']);
						}
						$check = true;
						if (isset($values['current_password'])) {
							$check = check_app_settings('password', ['value' => $values['current_password']]);
							// debug($check, 1);
							unset($values['current_password']);
						}
						if ($check) {
							$this->custom->save('user_app_settings', $values, ['user_id' => $user_id, 'id' => $settings_id]);
						} else {
							$message = 'Current password not match!';
						}
					}
				}
				$this->accounts->update($id);
			} else {
				$message = 'That was not your profile! Stop hacking the system!';
			}
			$url = base_url('profile');
			if ($message != '') {
				$url = base_url('profile?error='.$message);
			}
			redirect($url);
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
					base_url('assets/js/profile.js'),
				]),
				'post_body' => array(
					'templates/dashboard/modals/farmer-info'
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
			'title' => ucfirst(__FUNCTION__).' | Farmapp',
			'head_css' => $this->dash_defaults('head_css', [
				base_url('assets/admin/template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'),
				base_url('assets/admin/template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'),
			]),
			'head_js' => $this->dash_defaults('head_js'),
			'body_id' => strtolower(__FUNCTION__),
			'body_class' => strtolower(__FUNCTION__),
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
			'footer_js' => $this->dash_defaults('footer_js', [
				base_url('assets/admin/template/plugins/datatables/jquery.dataTables.min.js'),
				base_url('assets/admin/template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'),
				base_url('assets/admin/template/plugins/datatables-responsive/js/dataTables.responsive.min.js'),
				base_url('assets/admin/template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'),
				base_url('assets/js/products.js'),
			]),
			'post_body' => array( // html elements. these are declared before </body> closing tag. use for modals, etc. example: 'folder/filename'
				''
			),
			'db' => function() {
				$user = $this->accounts->profile['user'];
				$products = $this->db->join('product_category', 'product_category.id = product.category_id', 'left')
					->join('activity', 'activity.id = product.activity_id', 'left')
					->join('product_photo', 'product_photo.product_id = product.id AND product_photo.is_main = 1', 'left')
					->select('product.*, activity.label AS status, product_category.label AS category, product_photo.path AS photo')
					->get_where('product', ['product.user_id'=>$user['id']]);
				// debug($products->result(), 1);
				return [
					'products' => $products->num_rows() ? $products->result_array() : false,
				];
			}
		);
		$this->load->view('templates/dashboard/landing', $data);
	}
	
	public function save_product($id=0)
	{
		$post = $this->input->post();
		if ($post) {
			// debug($post, 1);
			$user = $this->accounts->profile['user'];
			// debug($_FILES);
			$product_id = 0;
			if (isset($post['product'])) {
				$post['product']['user_id'] = $user['id'];
				$location_ids = $post['product']['location_id'];
				if (is_array($post['product']['location_id'])) {
					$post['product']['location_id'] = implode(',', $post['product']['location_id']);
				}
				// debug($post, 1);
				if ($id) {
					$this->custom->save('product', $post['product'], ['id'=>$id]);
					$product_id = $id;
				} else {
					$product_id = $this->custom->create('product', $post['product']);
				}
				// $product_id = 1;
				if (count($location_ids)) {
					$this->custom->remove('product_location', ['user_id'=>$user['id'], 'product_id'=>$product_id]);
					foreach ($location_ids as $location_id) {
						$this->custom->create('product_location', ['user_id'=>$user['id'], 'product_id'=>$product_id, 'location_id'=>$location_id]);
					}
				}
			}
			if (isset($_FILES['product_photo']) AND $product_id > 0) {
				$data = files_upload($_FILES, false, $user['id'].'/product_photo', $post['product']['name']);
				// debug($data, 1);
				foreach ($data as $key => $row) {
					$photo = [];
					if ($row['status']) {
						$photo['product_id'] = $product_id;
						$photo['name'] = $post['product']['name'].'-'.$key;
						$photo['description'] = $post['product']['description'].'-'.$key;
						$photo['path'] = $row['url_path'];
						$photo['is_main'] = $row['keyname'] == 0 ? 1 : 0;
						$check = $this->custom->get('product_photo', ['product_id'=>$product_id, 'is_main'=>1], false, 'row');
						if ($check) $photo['is_main'] = 0;
						$this->custom->create('product_photo', $photo);
					}
					// debug($photo);
				}
			}
			// debug($post, 1);
			redirect(base_url('inventory'));
		} else {
			$data = array(
				'meta' => array(),
				'title' => ucwords(clean_string_name(__FUNCTION__, ' ', '_')).' | Farmapp',
				'head_css' => $this->dash_defaults('head_css', [
					base_url('assets/admin/template/plugins/daterangepicker/daterangepicker.css'),
					base_url('assets/admin/template/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'),
					base_url('assets/admin/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'),
					base_url('assets/admin/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'),
					base_url('assets/admin/template/plugins/select2/css/select2.min.css'),
					base_url('assets/admin/template/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'),
				]),
				'head_js' => $this->dash_defaults('head_js'),
				'body_id' => strtolower(__FUNCTION__),
				'body_class' => strtolower(__FUNCTION__),
				'wrapper_class' => 'save-product',
				'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
					'nav_view' => array(
						'templates/dashboard/global/nav'
					),
					'sidebar_view' => array(
						'templates/dashboard/global/sidebar'
					),
					'contentdata_view' => array(
						'templates/dashboard/users/save-product'
					)
				),
				'footer_css' => $this->dash_defaults('footer_css'),
				'footer_js' => $this->dash_defaults('footer_js', [
					base_url('assets/admin/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js'),
					base_url('assets/admin/template/plugins/select2/js/select2.full.min.js'),
					base_url('assets/admin/template/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js'),
					base_url('assets/admin/template/plugins/moment/moment.min.js'),
					base_url('assets/admin/template/plugins/inputmask/min/jquery.inputmask.bundle.min.js'),
					base_url('assets/admin/template/plugins/daterangepicker/daterangepicker.js'),
					base_url('assets/admin/template/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'),
					base_url('assets/admin/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'),
					base_url('assets/admin/template/plugins/bootstrap-switch/js/bootstrap-switch.min.js'),
					base_url('assets/js/jquery.validation.min.js'),
					base_url('assets/js/validator.js'),
					base_url('assets/js/products.js'),
				]),
				'post_body' => array(),
				'db' => function($id=0) {
					$product_id = ''; $product = false;
					if ($id) {
						$product = $this->custom->get('product', ['id'=>$id], false, 'row');
						$product_id = $id;
					}
					return [
						'product' => $product,
						'product_id' => $product_id,
					];
				}
			);
			$this->load->view('templates/dashboard/landing', $data);
		}
	}

	public function my_farm($id=0)
	{
		$set = $this->input->post();
		if ($id) {
			$user_id = $id; $message = '';
			$user = $this->accounts->profile['user'];
			if ($id == $user['id']) {
				if (isset($_FILES['user'])) {
					// debug($_FILES, 1);
					$data = files_upload($_FILES, false, $user['id'].'/user_photo');
					// debug($data, 1);
					foreach ($data as $key => $row) {
						$photo = [];
						if ($row['status']) {
							if ($row['keyname'] == 'banner') {
								$photo['banner'] = $row['url_path'];
							} else {
								$photo['photo'] = $row['url_path'];
							}
							$this->custom->save('user', $photo, ['id' => $user_id]);
						}
						// debug($photo);
					}
				}
				$this->accounts->update($id);
			} else {
				$message = 'This is not You!';
			}
			$url = base_url('farm');
			if ($message != '') {
				$url = base_url('farm?error='.$message);
			}
			redirect($url);
		} else {
			$data = array(
				'meta' => array(),
				'title' => 'My Farm | Farmapp',
				'head_css' => $this->dash_defaults('head_css'),
				'head_js' => $this->dash_defaults('head_js'),
				'body_id' => strtolower(__CLASS__),
				'body_class' => strtolower(__CLASS__),
				'wrapper_class' => 'my-farm',
				'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
					'nav_view' => array(
						'templates/dashboard/global/nav'
					),
					'sidebar_view' => array(
						'templates/dashboard/global/sidebar'
					),
					'contentdata_view' => array(
						'templates/dashboard/global/myfarm'
					)
				),
				'footer_css' => $this->dash_defaults('footer_css'),
				'footer_js' => $this->dash_defaults('footer_js', [
					base_url('assets/admin/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js'),
					base_url('assets/js/jquery.validation.min.js'),
					base_url('assets/js/validator.js'),
					base_url('assets/js/farm.js'),
					base_url('assets/admin/js/custom-js.js')
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

	public function settings($id=0)
	{
		$set = $this->input->post();
		if ($set OR $id) {
			// debug($set, 1);
			$user_id = $id; $message = '';
			$user = $this->accounts->profile['user'];
			if ($id == $user['id']) {
				// debug($_FILES, 1);
				if (isset($set['user'])) {
					$this->custom->save('user', $set['user'], ['id' => $id]);
				}
				if (isset($_FILES['user'])) {
					$data = files_upload($_FILES, false, $user['id'].'/user_photo');
					// debug($data, 1);
					foreach ($data as $key => $row) {
						$photo = [];
						if ($row['status']) {
							if ($key == 0) { /**/
								$photo['banner'] = $row['url_path'];
							} else {
								$photo['photo'] = $row['url_path'];
							}
							$this->custom->save('user', $photo, ['id' => $user_id]);
						}
						// debug($photo);
					}
				}
				// debug($set['user_location'], 1);
				if (isset($set['user_location'])) {
					foreach ($set['user_location'] as $key => $location) {
						$location_id = (is_numeric($location['id']) AND $location['id'] > 0) ? $location['id'] : 0;
						$latlng = json_decode($location['latlng'], true);
						$location = array_merge($location, $latlng);
						unset($location['latlng']);
						unset($location['id']);
						// debug($location_id);
						$empty = ((trim($location['address']) == '' OR trim($location['farm_name']) == '') AND $key > 0);
						if ($location_id == 0 AND $empty == false) {
							$location['user_id'] = $user_id;
							$this->custom->create('user_location', $location);
						} else {
							if ($empty) {
								$this->custom->remove('user_location', ['id' => $location_id]);
							} else {
								$this->custom->save('user_location', $location, ['id' => $location_id]);
							}
						}
					}
				}
				$this->accounts->update($id);
			} else {
				$message = 'This is not You!';
			}
			$url = base_url('settings');
			if ($message != '') {
				$url = base_url('settings?error='.$message);
			}
			redirect($url);
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
				'wrapper_class' => 'settings',
				'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
					'nav_view' => array(
						'templates/dashboard/global/nav'
					),
					'sidebar_view' => array(
						'templates/dashboard/global/sidebar'
					),
					'contentdata_view' => array(
						'templates/dashboard/users/settings'
					)
				),
				'footer_css' => $this->dash_defaults('footer_css'),
				'footer_js' => $this->dash_defaults('footer_js', [
					base_url('assets/admin/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js'),
					base_url('assets/js/jquery.validation.min.js'),
					base_url('assets/js/validator.js'),
					'https://maps.googleapis.com/maps/api/js?key=AIzaSyBbNbxnm4HQLyFO4FkUOpam3Im14wWY0MA&libraries=places',
					base_url('assets/js/markerclustererplus.min.js'),
					base_url('assets/js/map-script.js'),
					base_url('assets/js/settings.js'),
				]),
				'post_body' => array(

				),
				'db' => function() {
					$user = $this->accounts->profile['user'];
					$this->accounts->update($user['id']);
					// debug($this->accounts->profile, 1);
					return [
						'profile' => $this->accounts->profile,
					];
				}
			);
			$this->load->view('templates/dashboard/landing', $data);
		}
	}

}
