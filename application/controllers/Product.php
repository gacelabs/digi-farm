<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	public function index($id=false, $name=false)
	{
		if ($id AND $name) {
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
					$product_id = $this->uri->segment(2);
					$product = $estimated = false;
					// debug($this->latlng);
					if (is_numeric($product_id)) {
						$near_veggies = $this->session->userdata('near_veggies');
						if (isset($near_veggies[$product_id])) {
							$product = $near_veggies[$product_id];
							$product['pos'] = $product_id;
							$estimated = calculate_distance($product['distance']);
							$product['estimated'] = actual_estimate($estimated);
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

}
