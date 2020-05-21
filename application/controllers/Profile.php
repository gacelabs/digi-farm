<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function index()
	{
	}

	public function sign_in()
	{
		// $post = ['username'=>'bong', 'password'=>2];
		$post = $this->input->post();
		// debug($post, 1);
		$is_ok = $this->accounts->login($post);
		// debug($is_ok, 1);
		redirect(base_url());
		// if ($is_ok) {
		// 	/*direct to the home when login success*/
		// 	redirect(base_url());
		// } else {
		// 	$this->load->view('welcome_message');
		// }
	}

	public function sign_out()
	{
		return $this->accounts->logout('home'); /*this will redirect to default page */
	}

	public function sign_up()
	{
		// $post = ['username'=>'leng2', 'password'=>23, 're_password'=>23];
		$post = $this->input->post();
		$return = $this->accounts->register($post, 'settings'); /*this will redirect to settings page */
		// debug($this->session);
		// debug($return, 1);
	}
}
