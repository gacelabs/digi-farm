<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

	public function index()
	{
		$data = array(
			'meta' => array(
				''
			),
			'title' => 'Product Title | Price | FarmApp', // format: Product Title | Price | FarmApp
			'head_css' => array( // path to css files, appended with base_url(). these are declared within page <head> opening tag. example: base_url().'assets/css/bootstrap.min.css'
				base_url().'assets/css/bootstrap.min.css',
				base_url().'assets/css/font-awesome.min.css',
				base_url().'assets/css/slider.css',
				base_url().'assets/css/slick-theme.css',
				base_url().'assets/css/global.css',
				base_url().'assets/css/product-live.css',
				base_url().'assets/css/responsive.css'
			),
			'head_js' => array( // path to js files, appended with base_url(). these are declared within page <head> opening tag. example: base_url().'assets/js/jquery.min.js'
				''
			),
			'body_id' => 'product-live',
			'body_class' => 'product-live',
			'wrapper_class' => '',
			'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
				'nav_view' => array(
					'global/nav'
				),
				'top_view' => array(
					'products/live-details',
				),
				'middle_view' => array(
					
				),
				'bottom_view' => array(

				),
				'footer_view' => array(

				)
			),
			'footer_css' => array( // path to css files, appended with base_url(). these are declared before </body> closing tag. example: base_url().'assets/css/bootstrap.min.css'
				''
			),
			'footer_js' => array( // path to js files, appended with base_url(). these are declared before </body> closing tag. example: base_url().'assets/js/jquery.min.js'
				base_url().'assets/js/jquery.min.js',
				base_url().'assets/js/bootstrap.min.js',
				base_url().'assets/js/slider.js',
				base_url().'assets/js/main.js'
			),
			'post_body' => array( // html elements. these are declared before </body> closing tag. use for modals, etc. example: 'folder/filename'
				''
			),
			'db' => array( // data to pass specifically to this page
				
			)
		);

		$this->load->view('templates/home', $data);
	}

}
