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
					base_url('assets/admin/js/product.js')
				]),
				'post_body' => array(
				),
				'db' => function() {
					$product = $this->db->join('product_category', 'product_category.id = product.category_id', 'left')
						->join('activity', 'activity.id = product.activity_id', 'left')
						->join('product_photo', 'product_photo.product_id = product.id AND product_photo.is_main = 1', 'left')
						->select('product.*, activity.label AS status, product_category.label AS category, product_photo.path AS photo')
						->get_where('product', ['product.id'=>$this->uri->segment(2)]);
					// debug($product, 1);
					return $product->num_rows() ? $product->row_array() : false;
				}
			);
			$this->load->view('templates/dashboard/landing', $data);
		} else {
			redirect(base_url());
		}
	}

}
