<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts {

	private $class = FALSE; 
	public $has_session = FALSE; 
	public $profile = FALSE;
	public $device_id = FALSE;

	public function __construct()
	{
		$this->class =& get_instance();
		$this->has_session = $this->class->session->userdata('profile') ? TRUE : FALSE;
		$this->profile = $this->class->session->userdata('profile');
	}

	public function check_credits($credits=FALSE, $table='users')
	{
		$allowed = FALSE; $user = FALSE; $msg = '';
		if ($credits) {
			if (isset($credits['email_address']) AND isset($credits['password'])) {
				$credits['password'] = md5($credits['password']);
				$email_address_query = $this->class->db->get_where($table, ['email_address' => $credits['email_address']]);
				if ($email_address_query->num_rows()) {
					$query = $this->class->db->get_where($table, $credits);
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

	public function register($post=FALSE, $redirect_url='', $table='users')
	{
		$allowed = FALSE; $user = FALSE;; $passed = TRUE; $msg = '';
		if ($post) {
			// debug($post, 1);
			if (isset($post['password']) AND isset($post['re_password'])) {
				if ($post['re_password'] !== $post['password']) {
					$passed = FALSE;
					$msg = 'Password mismatch!';
				}
			}
			if (isset($post['email_address']) AND isset($post['password'])) {
				$credits = ['email_address'=>$post['email_address'], 'password'=>$post['password']];
				$return = $this->check_credits($credits, $table);
				if ($passed) {
					if (isset($return['allowed']) AND $return['allowed'] == FALSE) {
						unset($post['re_password']);
						$post['password'] = md5($post['password']);
						$query = $this->class->db->insert($table, $post);
						$id = $this->class->db->insert_id();
						// debug($id);
						if ($id) {
							$msg = '';
							$allowed = TRUE;
							$qry = $this->class->db->get_where($table, ['id' => $id]);
							$user = $qry->row_array();
							// debug($user, 1);
							unset($user['password']);
							$this->class->session->set_userdata('profile', $user);
							$this->profile = $user;
						}
						if ($redirect_url != '') {
							redirect(base_url($redirect_url == 'home' ? '' : $redirect_url));
						}
					} else {
						$msg = 'Username and password existing!';
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

	public function login($credits=FALSE, $redirect_url='', $table='users')
	{
		// debug($credits, 1);
		if ($credits != FALSE AND is_array($credits) AND $this->has_session == FALSE) {
			/*user is logging in*/
			$return = $this->check_credits($credits, $table);
			// debug($return, 1);
			if (isset($return['allowed']) AND $return['allowed']) {
				unset($return['profile']['password']);
				$this->class->session->set_userdata('profile', $return['profile']);
				$this->profile = $return['profile'];
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
		$this->class->session->unset_userdata('profile');
		$this->class->session->sess_destroy();
		$this->profile = FALSE;
		$this->has_session = FALSE;
		// $this->class->pushthru->trigger('logout-profile', 'browser-'.$this->device_id.'-sessions-logout', $profile);
		redirect(base_url($redirect_url == 'home' ? '' : $redirect_url));
	}

	public function refetch()
	{
		$user = $this->class->db->get_where('users', ['id' => $this->profile['id']]);
		if ($user->num_rows()) {
			$request = $user->row_array();
			unset($request['password']);
			$this->class->session->set_userdata('profile', $request);
			$this->profile = $request;
			$this->device_id = format_ip();
			// debug($this, 1);
			return $this->profile;
		}
		return FALSE;
	}
}