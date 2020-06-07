<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Controller {

	public function index()
	{
		$data = array(
			'meta' => array(),
			'title' => ucfirst(__CLASS__).' | Farmapp',
			'head_css' => $this->dash_defaults('head_css'),
			'head_js' => $this->dash_defaults('head_js'),
			'body_id' => strtolower(__CLASS__),
			'body_class' => strtolower(__CLASS__),
			'wrapper_class' => strtolower(__CLASS__),
			'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
				'nav_view' => array(
					'templates/dashboard/global/nav'
				),
				'sidebar_view' => array(
					'templates/dashboard/global/sidebar'
				),
				'contentdata_view' => array(
					'templates/dashboard/users/orders'
				)
			),
			'footer_css' => $this->dash_defaults('footer_css'),
			'footer_js' => $this->dash_defaults('footer_js', [
				base_url('assets/admin/js/orders.js')
			]),
			'post_body' => array(
			),
			'db' => function() {
				$user = $this->accounts->profile['user'];
				$who = ['user_id' => $user['id']];
				if ($user['farmer']) {
					$who = ['from_user_id' => $user['id']];
				}
				$orders = $this->custom->get('order', $who);
				return $orders;
			}
		);
		$this->load->view('templates/dashboard/landing', $data);
	}

	public function tracking($code=false)
	{
		$data = array(
			'meta' => array(),
			'title' => ucfirst(__CLASS__).' | Farmapp',
			'head_css' => $this->dash_defaults('head_css', [
				base_url().'assets/css/slider.css',
				base_url().'assets/css/slick-theme.css',
				base_url().'assets/css/home.css',
				base_url().'assets/admin/css/custom-admin.css'
			]),
			'head_js' => $this->dash_defaults('head_js'),
			'body_id' => strtolower(__CLASS__),
			'body_class' => strtolower(__CLASS__),
			'wrapper_class' => strtolower(__CLASS__),
			'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
				'nav_view' => array(
					'templates/dashboard/global/nav'
				),
				'sidebar_view' => array(
					'templates/dashboard/global/sidebar'
				),
				'contentdata_view' => array(
					'templates/dashboard/users/tracking'
				)
			),
			'footer_css' => $this->dash_defaults('footer_css'),
			'footer_js' => $this->dash_defaults('footer_js', [
				base_url('assets/admin/js/orders.js')
			]),
			'post_body' => array(
			),
			'db' => function() {
				$tracking_number = $this->uri->segment(2);
				$user = $this->accounts->profile['user'];
				$who = ['code' => $tracking_number, 'user_id' => $user['id']];
				if ($user['farmer']) {
					$who = ['code' => $tracking_number, 'from_user_id' => $user['id']];
				}
				$order = $this->custom->get('order', $who, false, 'row');
				return $order;
			}
		);
		$this->load->view('templates/dashboard/landing', $data);
	}

}
