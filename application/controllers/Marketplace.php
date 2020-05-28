<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketplace extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
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
				'https://maps.googleapis.com/maps/api/js?key=AIzaSyBbNbxnm4HQLyFO4FkUOpam3Im14wWY0MA&libraries=places',
				base_url('assets/js/markerclustererplus.min.js'),
				base_url('assets/js/map-script.js'),
				base_url('assets/js/marketplace.js'),
				base_url().'assets/admin/js/custom-js.js'
			]),
			'post_body' => array(
			),
			'db' => function() {
				$latlng = get_geolocation();
				$veggies_position = false;
				if ($latlng) {
					$data = nearest_locations(['latlng' => $latlng]);
					// debug($data, 1);
					if ($data) {
						$veggies_position = [];
						foreach ($data as $key => $loc) {
							$products = $this->db->join('product_location', 'product_location.product_id = product.id', 'left')
								->join('product_photo', 'product_photo.product_id = product.id AND product_photo.is_main = 1', 'left')
								->select('product.*, "'.$loc['distance'].'" AS distance, "'.$loc['unit'].'" AS unit, product_photo.path AS photo')
								->get_where('product', ['product_location.location_id'=>$loc['id']]);
							if ($products->num_rows()) {
								// debug($products->result_array(), 1);
								foreach ($products->result_array() as $key => $product) {
									$veggies_position[$product['id']] = $product;
								}
							}
						}
						// debug($veggies_position, 1);
					}
				}
				// debug($veggies_position, 1);
				return [
					// 'profile' => $this->accounts->profile,
					'veggies_position' => $veggies_position,
				];
			}
		);
		$this->load->view('templates/dashboard/landing', $data);
	}

}
