<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public $shall_not_pass = true;

	public function index()
	{
		$data = array(
			'meta' => array(),
			'title' => ucfirst(__CLASS__).' | Farmapp',
			'head_css' => $this->dash_defaults('head_css'),
			'head_js' => $this->dash_defaults('head_js'),
			'body_id' => strtolower(__CLASS__),
			'body_class' => strtolower(__CLASS__),
			'wrapper_class' => '',
			'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
				'nav_view' => array(
					'templates/dashboard/global/nav'
				),
				'sidebar_view' => array(
					'templates/dashboard/global/sidebar'
				),
				'contentdata_view' => array(
					'templates/dashboard/admin/index'
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

	public function login()
	{
		$this->load->view('templates/dashboard/admin/login');
	}

	public function dash_defaults($ext=false, $additional=[])
	{
		$default = [];
		if ($ext) {
			switch (strtolower($ext)) {
				case 'head_js':
					$default = array();
					break;

				case 'footer_js':
					$default = array(
						base_url('assets/admin/template/plugins/jquery/jquery.min.js'),
						base_url('assets/admin/template/plugins/jquery-ui/jquery-ui.min.js'),
						base_url('assets/admin/template/plugins/bootstrap/js/bootstrap.bundle.min.js'),
						base_url('assets/admin/template/plugins/chart.js/Chart.min.js'),
						base_url('assets/admin/template/plugins/sparklines/sparkline.js'),
						base_url('assets/admin/template/plugins/jqvmap/jquery.vmap.min.js'),
						base_url('assets/admin/template/plugins/jqvmap/maps/jquery.vmap.usa.js'),
						base_url('assets/admin/template/plugins/jquery-knob/jquery.knob.min.js'),
						base_url('assets/admin/template/plugins/moment/moment.min.js'),
						base_url('assets/admin/template/plugins/daterangepicker/daterangepicker.js'),
						base_url('assets/admin/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'),
						base_url('assets/admin/template/plugins/summernote/summernote-bs4.min.js'),
						base_url('assets/admin/template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'),
						base_url('assets/admin/template/dist/js/adminlte.js'),
						base_url('assets/admin/template/dist/js/pages/dashboard.js'),
						base_url('assets/admin/template/dist/js/demo.js'),
					);
					break;
				
				case 'head_css': /*head_css*/
					$default = array(
						base_url('assets/admin/template/plugins/fontawesome-free/css/all.min.css'),
						base_url('assets/admin/css/ionicons.min.css'),
						base_url('assets/admin/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'),
						base_url('assets/admin/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css'),
						base_url('assets/admin/template/plugins/jqvmap/jqvmap.min.css'),
						base_url('assets/admin/template/dist/css/adminlte.min.css'),
						base_url('assets/admin/template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'),
						base_url('assets/admin/template/plugins/daterangepicker/daterangepicker.css'),
						base_url('assets/admin/template/plugins/summernote/summernote-bs4.css'),
						base_url('assets/admin/css/sourcesanspro.css'),
					);
					break;

				case 'footer_css':
					$default = array();
					break;
			}
		}

		if (count($additional)) {
			$default = array_merge($default, $additional);
		}

		return $default;
	}

}
