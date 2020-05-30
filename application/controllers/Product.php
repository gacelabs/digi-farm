<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	public function view()
	{
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
				base_url('assets/admin/js/adminlte.min.js'),
				base_url('assets/admin/js/custom-js.js'),
				base_url('assets/admin/js/product.js')
			]),
			'post_body' => array(
			),
			'db' => function() {
				$post = $this->input->post() ? $this->input->post() : ($this->input->get() ? $this->input->get() : false); 
				return $post;
			}
		);
		$this->load->view('templates/dashboard/landing', $data);
	}

}
