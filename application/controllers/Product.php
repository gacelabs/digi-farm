<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	public function index($id=false, $name=false)
	{
		if ($id AND $name) {
			$data = array(
				'meta' => array(),
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
				'footer_js' => $this->dash_defaults('footer_js'),
				'post_body' => array(
				),
				'db' => function() {
					$product = $this->custom->get('product', ['id'=>$this->uri->segment(2)], false, 'row');
					return $product;
				}
			);
			$this->load->view('templates/dashboard/landing', $data);
		} else {
			redirect(base_url());
		}
	}

}
