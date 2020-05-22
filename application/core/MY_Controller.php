<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $class_name = FALSE;
	public $device_id = FALSE;
	public $shall_not_pass = FALSE;
	public $ajax_shall_not_pass = TRUE;
	public $profile = FALSE;

	public function __construct()
	{
		parent::__construct();
		device_id(); /*set device id*/
		$this->class_name = trim(strtolower(get_called_class()));
		// debug($this->class_name, 1);
		$this->load->library('accounts');
		// debug($this->accounts->has_session, 1);
		// debug($this->accounts->profile, 1);
		// debug($this, 1);

		/*check/set for cookies*/
		// debug(cookies('device_id'), 1);
		if (cookies('device_id') == FALSE) {
			cookies('device_id', 'set', $this->device_id);
		}
		
		/*CHECK ACCOUNT LOGINS HERE*/
		if ($this->accounts->has_session) {
			/*FOR NOW ALLOW ALL PAGES WITH SESSION*/
			// $this->profile = $this->accounts->refetch();
			// debug($this->accounts, 1);
		} else {
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

	public function default($ext=false, $additional=[])
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
						base_url('assets/js/fitext.js'),
						base_url('assets/js/main.js'),
					);
					break;
				
				case 'head_css': /*head_css*/
					$default = array(
						base_url('assets/css/bootstrap.min.css'),
						base_url('assets/css/font-awesome.min.css'),
						base_url('assets/css/slider.css'),
						base_url('assets/css/slick-theme.css'),
						base_url('assets/css/global.css'),
						base_url('assets/css/category-slider.css'),
						base_url('assets/css/featured-slider.css'),
						base_url('assets/css/home.css'),
						base_url('assets/css/responsive.css'),
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