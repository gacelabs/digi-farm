<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketplace extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$cart = getsave_prev_cart();
		if ($cart) redirect(base_url());
	}

	public function index()
	{
		$data = array(
			'meta' => array(),
			'title' => 'Marketplace | Farmapp',
			'head_css' => $this->dash_defaults('head_css', [
				base_url().'assets/css/slider.css',
				base_url().'assets/css/slick-theme.css',
				base_url().'assets/css/home.css',
				base_url().'assets/admin/css/custom-admin.css'
			]),
			'head_js' => $this->dash_defaults('head_js'),
			'body_id' => strtolower(__CLASS__),
			'body_class' => strtolower(__CLASS__),
			'wrapper_class' => 'marketplace',
			'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
				'nav_view' => array(
					'templates/dashboard/global/nav'
				),
				'sidebar_view' => array(
					'templates/dashboard/global/sidebar'
				),
				'contentdata_view' => array(
					'templates/dashboard/global/marketplace'
				)
			),
			'footer_css' => $this->dash_defaults('footer_css'),
			'footer_js' => $this->dash_defaults('footer_js', [
				base_url().'assets/js/slider.js',
				base_url().'assets/js/slider.init.js',
				base_url('assets/js/marketplace.js')
			]),
			'post_body' => array(
			),
			'db' => function() {
				return [
					'veggies_position' => $this->products_sessions['veggies_position'],
					'farmers_position' => $this->products_sessions['farmers_position'],
				];
			}
		);
		$this->load->view('templates/dashboard/landing', $data);
	}

}
