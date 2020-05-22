<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public $shall_not_pass = true;

	public function index()
	{
		$data = array(
			'meta' => array(
				''
			),
			'title' => 'Welcome to FarmApp!',
			'head_css' => $this->default('head_css'),
			'head_js' => $this->default('head_js'),
			'body_id' => strtolower(__CLASS__),
			'body_class' => strtolower(__CLASS__),
			'wrapper_class' => '',
			'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
				'nav_view' => array(
					'global/nav'
				),
				'top_view' => array(
					'templates/dashboard/index'
				),
				'middle_view' => array(

				),
				'bottom_view' => array(

				),
				'footer_view' => array(

				)
			),
			'footer_css' => $this->default('footer_css'),
			'footer_js' => $this->default('footer_js', [
				base_url('assets/js/chartjs/Chart.bundle.min.js'),
				base_url('assets/js/chartjs/charts.js'),
			]),
			'post_body' => array( // html elements. these are declared before </body> closing tag. use for modals, etc. example: 'folder/filename'
				''
			),
			'db' => array( // data to pass specifically to this page
				
			)
		);

		$this->load->view('templates/home', $data);
	}

	public function profile($value='')
	{
		$data = array(
			'meta' => array(
				''
			),
			'title' => ucfirst(__FUNCTION__).' | Farmapp',
			'head_css' => array( // path to css files, appended with base_url(). these are declared within page <head> opening tag. example: base_url().'assets/css/bootstrap.min.css'
				base_url().'assets/css/bootstrap.min.css',
				base_url().'assets/css/font-awesome.min.css',
				base_url().'assets/css/global.css',
				base_url().'assets/css/login.css',
				base_url().'assets/css/responsive.css'
			),
			'head_js' => array( // path to js files, appended with base_url(). these are declared within page <head> opening tag. example: base_url().'assets/js/jquery.min.js'
				''
			),
			'body_id' => __FUNCTION__,
			'body_class' => __FUNCTION__,
			'wrapper_class' => '',
			'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
				'nav_view' => array(
					'global/nav'
				),
				'top_view' => array(
					'templates/dashboard/profile'
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
				base_url().'assets/js/jquery.validation.min.js',
				base_url().'assets/js/login.js',
				base_url().'assets/js/validator.js'
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
