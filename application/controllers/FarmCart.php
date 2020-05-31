<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FarmCart extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->load->library('paypalapi', ['key'=>PAYPAL_CLIENTID, 'secret'=>PAYPAL_SECRET], 'paypal');
		$this->load->library('lalamoveapi', ['id'=>LALAMOVE_ID, 'key'=>LALAMOVE_KEY], 'lalamove');
		// debug($this->paypal);
		// debug($this->lalamove, 1);
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
				$cart = getsave_prev_cart();
				if ($cart) {
					redirect(base_url('cart'));
				}
				// debug($this->cart->contents(), 1);
				return $this->cart->contents();
			}
		);
		$this->load->view('templates/dashboard/landing', $data);
	}

	public function add()
	{
		$post = get_form_data();
		// debug($post, 1);
		if ($post) {
			// debug($this->cart->contents(), 1);
			if (!isset($post['qty'])) $post['qty'] = 1;
			
			$product = $estimated = false;
			if ((isset($post['pos']) AND is_numeric($post['pos']))) {
				$pos = $post['pos'];
				$near_veggies = $this->session->userdata('near_veggies');
				// debug($this->latlng);
				if (isset($near_veggies[$pos])) {
					$product = $near_veggies[$pos];
					$product['pos'] = $pos;
					$estimated = calculate_distance($product['distance']);
					$product['estimated'] = actual_estimate($estimated);
				}
			}

			// debug($product, 1);
			if ($product) {
				$insert = [
					'id' => $product['id'],
					'qty' => $post['qty'],
					'price' => $product['current_price'],
					'name' => $product['name'],
				];
				$insert['options'] = $product;
				$insert['options']['device_id'] = $this->device_id;
				$insert['added'] = date('Y-m-d H:i:s');
				$insert['pos'] = $product['pos'];

				$photo = $this->custom->get('product_photo', ['product_id' => $post['id'], 'is_main' => 1], false, 'row');
				$insert['path'] = $photo['path'];
				// debug($insert, 1);
				$rowid = $this->cart->insert($insert);
				// debug($this->cart->contents(), 1);

				$order = $this->custom->get('order', ['product_id' => $post['id'], 'rowid' => $rowid], false, 'row');
				// debug($order, 1);
				$status = 'Added';
				if ($order) {
					$statuses = $this->custom->get('order_status', ['id' => $order['status_id']], false, 'row');
					$status = $statuses['label'];
				}
				$item = $this->cart->get_item($rowid);
				$item['status'] = $status;
				$this->cart->update($item);
				$up = $this->update_cart($rowid, $item);

				$parse_url = parse_url($this->agent->referrer());
				if (!$this->accounts->has_session AND !in_array($parse_url['path'], [null,'/'])) {
					$this->session->set_userdata('prev_url', base_url('cart'));
					redirect(base_url('login?page=sign_up'));
				} else {
					if ($up) {
						redirect(base_url('cart?message=Product '.$insert['name'].' quantity added'));
					} else {
						redirect(base_url('cart?error=Product '.$insert['name'].' quantity failed to add'));
					}
				}
			} else {
				redirect(base_url('cart?error=Product maybe out of stocks or been removed!'));
			}
		}
		redirect(base_url('cart'));
	}

	public function less($rowid=false)
	{
		if ($rowid) {
			$item = $this->cart->get_item($rowid);
			$item['qty'] -= 1;
			$this->cart->update($item);
			
			if ($item['qty'] <= 0) {
				$this->custom->remove('cart', ['rowid' => $rowid, 'device_id' => $this->device_id]);
				redirect(base_url('cart?message=Product '.$item['name'].' quantity deducted'));
			} else {
				if ($this->update_cart($rowid, $item)) {
					redirect(base_url('cart?message=Product '.$item['name'].' quantity deducted'));
				} else {
					redirect(base_url('cart?error=Product '.$item['name'].' quantity failed to deduct'));
				}
			}
		} else {
			redirect(base_url('cart?error=Does nothing'));
		}
	}

	public function remove($rowid=false)
	{
		if ($rowid) {
			$item = $this->cart->get_item($rowid);
			$this->cart->remove($rowid);
			$this->custom->remove('cart', ['rowid' => $rowid, 'device_id' => $this->device_id]);
			redirect(base_url('cart?message=Product '.$item['name'].' removed'));
		} else {
			redirect(base_url('cart?error=Does nothing'));
		}
	}

	public function payment()
	{
		$post = get_form_data();
		if ($post) {
			$user = $this->accounts->profile['user'];
			switch ($post['type']) {
				case 'value':
					# code...
					break;
				
				default: /*paypal*/
					$invoice_number = generate_invoice($user);
					$paypal_data = array(
						'sku' => $post['sku'],
						'name' => $post['name'].' for Php '.number_format($post['price']),
						'price' => $post['price'],
						'quantity' => $post['qty'],
						'currency' => 'PHP',
						'invoice_number' => $invoice_number,
						'urls' => array(
							'return' => base_url('cart/recurring?success=1&id='.$user['id'].'&number='.$invoice_number.'&data='.base64_encode(json_encode($post))),
							'cancel' => base_url('cart/recurring?success=0&id='.$user['id'].'&number='.$invoice_number.'&data='.base64_encode(json_encode($post)))
						)
					);
					// debug($paypal_data); exit();
					$paypal_form = construct_paypal($paypal_data, $this->paypal, $user);
					// debug($paypal_form); exit();
					if ($paypal_form) {
						// debug($paypal_form->output->approval_url); exit();
						$paypal_url = $paypal_form->output->approval_url;
						echo "Please wait, loading payment gateway...";
						sleep(3);
						redirect($paypal_url, 'refresh');
					}
					break;
			}
		}
	}

	private function update_cart($rowid=false, $item=false)
	{
		if ($rowid AND $item) {
			$check_cart = $this->custom->get('cart', ['rowid' => $rowid, 'device_id' => $this->device_id], false, 'row');
			if ($check_cart) {
			/*update*/
				$this->custom->save('cart', ['data' => serialize($item)], ['rowid' => $rowid, 'device_id' => $this->device_id]);
			} else {
				$this->custom->create('cart', ['data' => serialize($item), 'rowid' => $rowid, 'device_id' => $this->device_id]);
			}
			return true;
		}
		return false;
	}

}
