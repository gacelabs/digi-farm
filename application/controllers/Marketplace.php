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
				base_url().'assets/css/home.css'
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
				base_url('assets/js/marketplace.js')
			]),
			'post_body' => array(
			),
			'db' => function() {
				$latlng = get_geolocation();
				$location_ids = []; $where_locations = ''; $veggies_position = false;
				if ($latlng) {
					$data = nearest_locations(['latlng' => $latlng]);
					debug($data, 1);
					if ($data) {
						foreach ($data as $key => $loc) $location_ids[] = $loc['id'];
						// debug($location_ids, 1);
						$where_locations = 'WHERE location_id IN ('.implode(',', $location_ids).')';
						// debug($where_locations, 1);
						$veggies_position = $this->custom->query("SELECT lat, lng
						FROM user_location
						WHERE id IN (SELECT location_id FROM product ".$where_locations.")");
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
