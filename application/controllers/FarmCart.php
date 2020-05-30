<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FarmCart extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array(
			'meta' => array(),
			'title' => ucfirst(__CLASS__).' | Farmapp',
			'head_css' => $this->dash_defaults('head_css'),
			'head_js' => $this->dash_defaults('head_js'),
			'body_id' => strtolower(__CLASS__),
			'body_class' => strtolower(__CLASS__),
			'wrapper_class' => 'dashboard',
			'view' => array( // html elements. these are declared within body tags. example: 'folder/filename'
				'nav_view' => array(
					'templates/dashboard/global/nav'
				),
				'sidebar_view' => array(
					'templates/dashboard/global/sidebar'
				),
				'contentdata_view' => array(
					'templates/dashboard/global/cart'
				)
			),
			'footer_css' => $this->dash_defaults('footer_css'),
			'footer_js' => $this->dash_defaults('footer_js'),
			'post_body' => array(
			),
			'db' => function() {
				// $this->cart->destroy();
				return $this->cart->contents();
			}
		);
		$this->load->view('templates/dashboard/landing', $data);
	}

	public function add()
	{
		$post = $this->input->post() ? $this->input->post() : $this->input->get(); 
		if ($post) {
			if (!isset($post['qty'])) $post['qty'] = 1;
			$product = $this->custom->get('product', ['id' => $post['id']], false, 'row');
			// debug($product, 1);
			if ($product) {
				$insert = [
					'id' => $product['id'],
					'qty' => $post['qty'],
					'price' => $product['current_price'],
					'name' => $product['name'].' - '.$product['description'],
				];
				$insert['options'] = $product;
				$insert['added'] = date('Y-m-d H:i:s.U');

				$photo = $this->custom->get('product_photo', ['product_id' => $post['id'], 'is_main' => 1], false, 'row');
				$insert['path'] = $photo['path'];

				$cart_rowid = array_keys($this->cart->contents(true))[0];
				$order = $this->custom->get('order', ['product_id' => $post['id'], 'rowid' => $cart_rowid], false, 'row');
				// debug($order, 1);
				$status = 'Added';
				if ($order) {
					$statuses = $this->custom->get('order_status', ['id' => $order['status_id']], false, 'row');
					$status = $statuses['label'];
				}
				$insert['status'] = $status;
				
				$this->cart->insert($insert);
				redirect(base_url('cart?message=Product '.$insert['name'].' quantity added'));
			} else {
				redirect(base_url('?error=Product maybe out of stocks or been removed!'));
			}
			if ($this->accounts->has_session == false) {
				redirect(base_url('login?page=sign_up'));
			}
		} else {
			redirect(base_url('cart'));
		}
	}

	public function less($rowid=false)
	{
		if ($rowid) {
			$item = $this->cart->get_item($rowid);
			$item['qty'] -= 1;
			$this->cart->update($item);
			redirect(base_url('cart?message=Product '.$item['name'].' quantity deducted'));
		} else {
			redirect(base_url('cart?error=Does nothing'));
		}
	}

	public function remove($rowid=false)
	{
		if ($rowid) {
			$item = $this->cart->get_item($rowid);
			$this->cart->remove($rowid);
			redirect(base_url('cart?message=Product '.$item['name'].' removed'));
		} else {
			redirect(base_url('cart?error=Does nothing'));
		}
	}

}
