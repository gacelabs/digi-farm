<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts {

	private $class = FALSE; 
	public $has_session = FALSE; 
	public $profile = FALSE;
	public $device_id = FALSE;
	public $geolocation = FALSE;

	public function __construct()
	{
		$this->class =& get_instance();
		$this->has_session = $this->class->session->userdata('profile') ? TRUE : FALSE;
		$this->profile = $this->class->session->userdata('profile');
		$this->set_geolocation();
	}

	private function set_geolocation()
	{
		if ($this->class->session->userdata('geolocation') == FALSE) {
			$this->geolocation = get_geolocation(FALSE);
			$this->class->session->set_userdata('geolocation', $this->geolocation);
		} else {
			$this->geolocation = $this->class->session->userdata('geolocation');
			/*if 540 seconds passed reload geolocation*/
			if (time_diff($this->geolocation['date'], date('Y-m-d'), 'seconds', 540)) { /*9 minutes*/
				$this->geolocation = get_geolocation(FALSE);
				$this->class->session->set_userdata('geolocation', $this->geolocation);
			}
		}
		$this->device_id = device_id($this->geolocation['ip']);
	}

	public function check_credits($credits=FALSE)
	{
		$allowed = FALSE; $user = FALSE; $msg = 'Invalid entry';
		if ($credits) {
			// debug($credits, 1);
			if (isset($credits['email_address']) AND isset($credits['password'])) {
				$password = $credits['password'];
				unset($credits['password']);
				$email_address_query = $this->class->db->get_where('user', ['email_address' => $credits['email_address']]);
				if ($email_address_query->num_rows()) {
					$user = $email_address_query->row();
					$query = $this->class->db->get_where('user_app_settings', ['user_id' => $user->id, 'name' => 'password', 'value' => $password]);
					// debug($query->row_array(), 1);
					if ($query->num_rows()) {
						$allowed = TRUE;
						$user = $query->row_array();
					} else {
						$msg = 'Invalid password!';
					}
				} else {
					$msg = 'Username does not exist!';
				}
			}
		}

		return ['allowed' => $allowed, 'message' => $msg, 'profile' => $user];
	}

	public function register($post=FALSE, $redirect_url='')
	{
		$allowed = FALSE; $user = FALSE;; $passed = TRUE; $msg = 'Invalid entries!';
		if ($post) {
			if (isset($post['password']) AND isset($post['retype_password'])) {
				if ($post['retype_password'] !== $post['password']) {
					$passed = FALSE;
					$msg = 'Password mismatch!';
				}
			}
			// debug($post, 1);
			if (isset($post['email_address']) AND isset($post['password'])) {
				$credits = ['email_address'=>$post['email_address'], 'password'=>$post['password']];
				$return = $this->check_credits($credits);
				if (strlen(trim($credits['email_address'])) > 0 AND strlen(trim($credits['password'])) > 0) {
					if ($passed) {
						// debug($return, 1);
						if (isset($return['allowed']) AND $return['allowed'] == FALSE) {
							unset($post['retype_password']);
							$password = $post['password'];
							unset($post['password']);
							$post['farmer'] = (isset($post['farmer']) AND $post['farmer'] == 'on') ? 1 : 0;
							// debug($post, 1);
							$query = $this->class->db->insert('user', $post);
							$id = $this->class->db->insert_id();
							/*insert user location*/
							$this->class->db->insert('user_location', [
								'user_id' => $id,
								'farm_name' => $post['last_name']."'s".($post['farmer'] ? ' Farm' : ' Place'),
								'lat' => $this->geolocation['lat'],
								'lng' => $this->geolocation['lng']
							]);
							/*after insert copy all settings to this user*/
							$app_settings = $this->class->db->get('app_settings')->result_array();
							// debug($app_settings, 1);
							$user_app_settings = [];
							foreach ($app_settings as $key => $row) {
								unset($row['created']); unset($row['last_updated']);
								if (!isset($row['user_id'])) $row['user_id'] = 0;
								$row['user_id'] = $id;
								if ($row['name'] == 'password') {
									$row['value'] = $password;
								}
								$user_app_settings = $row;
								// debug($user_app_settings, 1);
								$this->class->db->insert('user_app_settings', $user_app_settings);
							}
							// debug($id);
							if ($id) {
								$msg = '';
								$allowed = TRUE;
								$data = $this->assemble_profile_data($id);
								// debug($data, 1);
								$this->class->session->set_userdata('profile', $data);
								$this->profile = $data;
							}
							redirect_prev_url();
							if ($redirect_url != '') {
								redirect(base_url($redirect_url == 'home' ? '' : $redirect_url));
							}
						} else {
							$msg = 'Username and password existing!';
						}
					}
				}
			} else {
				$msg = 'Username and password required!';
			}
		} else {
			$msg = 'Empty request found!';
		}

		return ['allowed' => $allowed, 'message' => $msg, 'profile' => $user];
	}

	public function login($credits=FALSE, $redirect_url='')
	{
		// debug($credits, 1);
		if ($credits != FALSE AND is_array($credits) AND $this->has_session == FALSE) {
			/*user is logging in*/
			$return = $this->check_credits($credits);
			if (isset($return['allowed']) AND $return['allowed']) {
				$data = $this->assemble_profile_data($return['profile']['user_id']);
				// debug($data, 1);
				$this->class->session->set_userdata('profile', $data);
				$this->profile = $data;
				redirect_prev_url();
				if ($redirect_url != '') {
					redirect(base_url($redirect_url == 'home' ? '' : $redirect_url));
				} else {
					return TRUE;
				}
			}
		}
		/*else the user is logged in or session active*/
		return FALSE;
	}

	public function logout($redirect_url='')
	{
		$profile = $this->class->session->userdata('profile');
		$near_veggies = $this->class->session->userdata('near_veggies');
		$near_farmers = $this->class->session->userdata('near_farmers');
		
		$this->class->session->unset_userdata('profile');
		$this->class->session->sess_destroy();
		$this->profile = FALSE;
		$this->has_session = FALSE;

		$this->class->session->set_userdata('near_veggies', $near_veggies);
		$this->class->session->set_userdata('near_farmers', $near_farmers);
		// $this->class->pushthru->trigger('logout-profile', 'browser-'.$this->device_id.'-sessions-logout', $profile);
		redirect(base_url($redirect_url));
	}

	public function refetch()
	{
		$user = $this->class->db->get_where('user', ['id' => $this->profile['id']]);
		if ($user->num_rows()) {
			$request = $user->row_array();
			unset($request['password']);
			$this->class->session->set_userdata('profile', $request);
			$this->profile = $request;
			$this->device_id = device_id($this->geolocation['ip']);
			// debug($this, 1);
			return $this->profile;
		}
		return FALSE;
	}

	public function assemble_profile_data($id=FALSE)
	{
		if ($id) {
			$user = $this->class->db->get_where('user', ['id' => $id]);
			$userdata = $user->row_array();
			unset($userdata['created']);
			unset($userdata['last_updated']);

			$user_app_settings = $this->class->db->get_where('user_app_settings', ['user_id' => $id]);
			$user_app_settings_data = $user_app_settings->result_array();
			// debug($user_app_settings_data, 1);
			foreach ($user_app_settings_data as $key => $row) {
				unset($user_app_settings_data[$key]['created']);
				unset($user_app_settings_data[$key]['last_updated']);
			}

			$user_location = $this->class->db->get_where('user_location', ['user_id' => $id]);
			$user_location_data = $user_location->result_array();
			foreach ($user_location_data as $key => $value) {
				unset($user_location_data[$key]['created']);
				unset($user_location_data[$key]['last_updated']);
			}

			return [
				'user' => $userdata,
				'user_app_settings' => $user_app_settings_data,
				'user_location' => $user_location_data
			];
		}
		return FALSE;
	}

	public function update($id=FALSE, $callback=FALSE)
	{
		if ($id) {
			$data = $this->assemble_profile_data($id);
			$this->class->session->set_userdata('profile', $data);
			$this->profile = $data;
			if ($callback) {
				$callback();
			}
			return TRUE;
		}
		return FALSE;
	}
}