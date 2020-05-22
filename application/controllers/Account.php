<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MY_Controller {

	public function index() /*login page*/
	{
		// debug($this->accounts->has_session, 1);
		if ($this->accounts->has_session == FALSE) {
			$data = array(
				'meta' => array(
					''
				),
				'title' => 'Log in | Farmapp',
				'head_css' => array( // path to css files, appended with base_url(). these are declared within page <head> opening tag. example: base_url().'assets/css/bootstrap.min.css'
					base_url().'assets/css/bootstrap.min.css',
					base_url().'assets/css/font-awesome.min.css',
					base_url().'assets/css/global.css',
					base_url().'assets/css/login.css',
					base_url().'assets/css/responsive.css'
				),
				'head_js' => array( // path to js files, appended with base_url(). these are declared within page <head> opening tag. example: base_url().'assets/js/jquery.min.js'
					''
				),
				'body_id' => 'login',
				'body_class' => 'login',
				'wrapper_class' => '',
				'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
					'nav_view' => array(
						'global/nav'
					),
					'top_view' => array(
						'forms/login'
					),
					'middle_view' => array(

					),
					'bottom_view' => array(

					),
					'footer_view' => array(

					)
				),
				'footer_css' => array( // path to css files, appended with base_url(). these are declared before </body> closing tag. example: base_url().'assets/css/bootstrap.min.css'
					''
				),
				'footer_js' => array( // path to js files, appended with base_url(). these are declared before </body> closing tag. example: base_url().'assets/js/jquery.min.js'
					base_url().'assets/js/jquery.min.js',
					base_url().'assets/js/bootstrap.min.js',
					base_url().'assets/js/jquery.validation.min.js',
					base_url().'assets/js/login.js',
					base_url().'assets/js/validator.js'
				),
				'post_body' => array( // html elements. these are declared before </body> closing tag. use for modals, etc. example: 'folder/filename'
					''
				),
				'db' => array( // data to pass specifically to this page
					
				)
			);

			$this->load->view('templates/home', $data);
		} else {
			redirect(base_url());
		}
	}

	public function sign_up()
	{
		// $post = ['username'=>'leng2', 'password'=>23, 're_password'=>23];
		$post = $this->input->post();
		$return = $this->accounts->register($post, 'dashboard/profile'); /*this will redirect to dashboard/profile page */
		// debug($this->session);
		// debug($return, 1);
		if ($return['allowed'] == false) {
			redirect(base_url('login?page='.__FUNCTION__.'&error='.$return['message']));
		} else {
			redirect(base_url());
		}
	}

	public function sign_in()
	{
		// $post = ['username'=>'bong', 'password'=>2];
		$post = $this->input->post();
		// debug($post, 1);
		$is_ok = $this->accounts->login($post, 'dashboard');
		// debug($is_ok, 1);
		if ($is_ok) {
			redirect(base_url());
		} else {
			redirect(base_url('login?page='.__FUNCTION__.'&error=Invalid credentials'));
		}
	}

	public function sign_out()
	{
		return $this->accounts->logout(); /*this will redirect to default page */
	}
}
