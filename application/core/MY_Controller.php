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

}