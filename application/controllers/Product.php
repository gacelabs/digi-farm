<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	public function index($pos=false, $id=false, $name=false)
	{
		// debug($pos, 1);
		if (is_numeric($pos) AND is_numeric($id) AND $name != false ) {
			$data = array(
				'meta' => array(
					'<meta name="og:url" content="" />', // URL to the page
					'<meta name="og:title" content="" />', // Product title
					'<meta name="og:type" content="product" />',
					'<meta name="og:description" content="" />', // Product description
					'<meta name="og:image" content="" />' // URL to featured image
				),
				'title' => ucfirst(__CLASS__).' | Farmapp',
				'head_css' => $this->dash_defaults('head_css'),
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
						'templates/dashboard/global/product'
					)
				),
				'footer_css' => $this->dash_defaults('footer_css'),
				'footer_js' => $this->dash_defaults('footer_js', [
					base_url('assets/js/jquery.validation.min.js'),
					base_url('assets/js/validator.js'),
					base_url('assets/admin/js/product.js'),
				]),
				'post_body' => array(
				),
				'db' => function() {
					$position = $this->uri->segment(2);
					$product_id = $this->uri->segment(3);
					$product = $estimated = false;
					// debug($this->latlng);
					if (is_numeric($product_id)) {
						if ($this->products_sessions AND isset($this->products_sessions['veggies_position'])) {
							$near_veggies = $this->products_sessions['veggies_position'];
							if (isset($near_veggies[$position])) {
								$product = $near_veggies[$position];
								$product['pos'] = $position;
								$estimated = calculate_distance($product['distance']);
								$product['estimated'] = actual_estimate($estimated);
							}
						}
					}
					// debug($product, 1);
					return $product;
				}
			);
			$this->load->view('templates/dashboard/landing', $data);
		} else {
			redirect(base_url());
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

}
