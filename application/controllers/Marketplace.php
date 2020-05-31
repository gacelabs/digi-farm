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
				$latlng = $this->latlng;
				// debug($latlng, 1);
				$veggies_position = $farmers_position = false;
				if ($latlng) {
					$data = nearest_locations(['latlng' => $latlng]);
					// debug($data, 1);
					if ($data) {
						$veggies_position = $farmers_position = $distances = [];
						foreach ($data as $loc) $distances[$loc['user_id']][] = $loc['distance'];
						foreach ($data as $key => $loc) {
							unset($loc['created']); unset($loc['last_updated']);

							$products = $this->custom->get('product_location', ['location_id'=>$loc['id']]);
							$veggies_position = products_by_location($products, $loc, $veggies_position);

							$users = $this->db->join('user_location', 'user_location.user_id = user.id', 'left')
								->select('user.*, "'.$loc['distance'].'" AS distance, "'.$loc['unit'].'" AS unit, user_location.farm_name, user_location.address')
								->get_where('user', ['user_location.user_id'=>$loc['user_id'], 'user_location.id'=>$loc['id']]);
							if ($users->num_rows()) {
								// debug($users->result_array(), 1);
								foreach ($users->result_array() as $key => $user) {
									$farmers_position[] = $user;
								}
							}
						}
					}
				}
				// debug($veggies_position, 1);
				$this->session->set_userdata('near_veggies', $veggies_position);
				// debug($farmers_position, 1);
				$this->session->set_userdata('near_farmers', $farmers_position);
				return [
					'veggies_position' => $veggies_position,
					'farmers_position' => $farmers_position,
				];
			}
		);
		$this->load->view('templates/dashboard/landing', $data);
	}

}
