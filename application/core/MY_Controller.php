<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $class_name = FALSE;
	public $device_id = FALSE;
	public $latlng = FALSE;
	public $shall_not_pass = FALSE;
	public $ajax_shall_not_pass = TRUE;
	public $profile = FALSE;
	public $products_sessions = FALSE;
	public $farm_cart = FALSE;

	public function __construct()
	{
		parent::__construct();
		$this->class_name = trim(strtolower(get_called_class()));
		// debug($this->class_name, 1);
		$this->load->library('accounts');
		// debug($this->accounts->has_session, 1);
		// debug($this->accounts->profile, 1);
		// debug($this->accounts->geolocation, 1);
		device_id($this->accounts->geolocation['ip']); /*set device id*/
		$this->latlng = ['lat' => $this->accounts->geolocation['lat'], 'lng' => $this->accounts->geolocation['lng']];
		// debug($this->latlng);

		/*check/set for cookies*/
		// debug(cookies('device_id'), 1);
		/*if (cookies('device_id') == FALSE) {
			cookies('device_id', 'set', $this->device_id);
		}*/
		$segments = $this->uri->segment_array();
		$intersected = array_intersect($segments, ['cart', 'place-order']);
		// debug(array_intersect($segments, ['cart','place-order']), 1);
		/*make sure cart is not overriden in cart/place-order*/
		if ($this->accounts->has_session AND count($intersected) != 2) {
			$this->farm_cart = getsave_prev_cart();
		} else {
			$this->farm_cart = $this->cart->contents();
		}
		/*CHECK ACCOUNT LOGINS HERE*/
		if ($this->accounts->has_session) {
			/*FOR NOW ALLOW ALL PAGES WITH SESSION*/
			// $this->profile = $this->accounts->refetch();
			$user = $this->accounts->profile['user'];
			if (!empty($user['lat']) AND !empty($user['lng'])) {
				$this->latlng = ['lat' => $user['lat'], 'lng' => $user['lng']];
			}
			// debug($this->latlng, 1);
			$this->products_sessions = get_update_marketplace($this->latlng);
		} else {
			$this->products_sessions = get_update_marketplace($this->latlng);
			/*now if ajax and ajax_shall_not_pass is TRUE redirect*/
			if ($this->input->is_ajax_request() AND $this->ajax_shall_not_pass) {
				// redirect(base_url());
				echo "<script>window.location.reload();</script>"; exit();
			}
			/*now if not ajax and shall_not_pass is TRUE redirect*/
			if (!$this->input->is_ajax_request() AND $this->shall_not_pass) {
				redirect(base_url());
			}
		}
		// debug($this->uri->segment_array());
		// debug($this->session, 1);
	}

	public function defaults($ext=false, $additional=[])
	{
		$default = [];
		if ($ext) {
			switch (strtolower($ext)) {
				case 'head_js':
					$default = array();
					break;

				case 'footer_js':
					$default = array(
						base_url('assets/js/jquery.min.js'),
						base_url('assets/js/bootstrap.min.js'),
						base_url('assets/js/slider.js'),
						base_url('assets/js/fitext.js')
					);
					break;
				
				case 'head_css': /*head_css*/
					$default = array(
						base_url('assets/css/bootstrap.min.css'),
						base_url('assets/css/font-awesome.min.css'),
						base_url('assets/css/slider.css'),
						base_url('assets/css/slick-theme.css'),
						base_url('assets/css/category-slider.css'),
						base_url('assets/css/featured-slider.css'),
						base_url('assets/css/home.css'),
						base_url('assets/css/responsive.css')
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
						base_url('assets/admin/template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'),
						base_url('assets/admin/template/dist/js/adminlte.js'),
						base_url('assets/admin/js/custom-js.js'),
					);
					break;
				
				case 'head_css': /*head_css*/
					$default = array(
						base_url('assets/admin/template/plugins/fontawesome-free/css/all.min.css'),
						base_url('assets/admin/css/ionicons.min.css'),
						base_url('assets/admin/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css'),
						base_url('assets/admin/template/dist/css/adminlte.min.css'),
						base_url('assets/admin/template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'),
						base_url('assets/admin/css/sourcesanspro.css'),
						base_url('assets/admin/css/custom-admin.css'),
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