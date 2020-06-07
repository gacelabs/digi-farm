<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FarmCart extends MY_Controller {

	public $user_id = 0;

	public function __construct()
	{
		parent::__construct();
		// $this->load->library('paypalapi', ['key'=>PAYPAL_CLIENTID, 'secret'=>PAYPAL_SECRET], 'paypal');
		$this->load->library('lalamoveapi', ['id'=>LALAMOVE_ID, 'key'=>LALAMOVE_KEY], 'lalamove');
		// debug($this->paypal);
		// debug($this->lalamove, 1);
		// debug($this->accounts->profile, 1);
		$this->user_id = $this->accounts->has_session ? $this->accounts->profile['user']['id'] : 0;
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
				// debug($this->farm_cart, 1);
				return $this->farm_cart;
			}
		);
		$this->load->view('templates/dashboard/landing', $data);
	}

	public function add()
	{
		$post = get_form_data();
		// debug($post, 1);
		// debug(http_build_query($post), 1);
		if ($post) {
			$parse_url = parse_url($this->agent->referrer());
			// debug($parse_url, 1);
			if (!$this->accounts->has_session AND !in_array($parse_url['path'], [null,'/'])) {
				$this->session->set_userdata('prev_url', base_url('cart/add?'.http_build_query($post)));
				redirect(base_url('login?page=sign-in'));
			}
			// debug($this->cart->contents(), 1);
			if (!isset($post['qty'])) $post['qty'] = 1;
			
			$product = $estimated = false;
			if ((isset($post['pos']) AND is_numeric($post['pos']))) {
				$pos = $post['pos'];
				$near_veggies = $this->session->userdata('near_veggies');
				// debug($this->latlng);
				if (isset($near_veggies[$pos])) {
					$product = $near_veggies[$pos];
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
				$insert['pos'] = $pos;
				$insert['user_id'] = $this->user_id;
				$insert['from_user_id'] = $product['user_id'];

				$photo = $this->custom->get('product_photo', ['product_id' => $post['id'], 'is_main' => 1], false, 'row');
				$insert['path'] = $photo['path'];
				// debug($insert, 1);
				$rowid = $this->cart->insert($insert);
				// debug($this->cart->contents(), 1);
				$item = $this->cart->get_item($rowid);
				$item['status_id'] = 0;
				$item['status'] = 'Added';
				$item['rowid'] = $rowid;

				$this->cart->update($item);
				$up = $this->update_cart($rowid, $item);

				if ($up) {
					redirect(base_url('cart?message=Product '.$insert['name'].' quantity added'));
				} else {
					redirect(base_url('cart?error=Product '.$insert['name'].' quantity failed to add'));
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
				$this->remove($rowid);
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
			$this->farm_cart = $this->custom->get('cart', 
				['user_id' => $this->user_id, 'rowid' => $rowid, 'device_id' => $this->device_id], false, 'row');
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
			$check_cart = $this->custom->get('cart', ['user_id' => $this->user_id, 'rowid' => $rowid, 'device_id' => $this->device_id], false, 'row');
			if ($check_cart) {
			/*update*/
				$this->custom->save('cart', ['data' => serialize($item), 'user_id' => $this->user_id], ['user_id' => $this->user_id, 'rowid' => $rowid, 'device_id' => $this->device_id]);
			} else {
				$this->custom->create('cart', ['data' => serialize($item), 'user_id' => $this->user_id, 'rowid' => $rowid, 'device_id' => $this->device_id]);
			}
			$this->farm_cart = $this->custom->get('cart', 
				['user_id' => $this->user_id, 'rowid' => $rowid, 'device_id' => $this->device_id], false, 'row');
			return true;
		}
		return false;
	}

	public function checkout()
	{
		if ($this->farm_cart) {
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
						'templates/dashboard/global/checkout'
					)
				),
				'footer_css' => $this->dash_defaults('footer_css'),
				'footer_js' => $this->dash_defaults('footer_js', [
					base_url('assets/admin/js/cart.js')
				]),
				'post_body' => array(
				),
				'db' => function() {
					// debug($this->farm_cart, 1);
					return $this->farm_cart;
				}
			);
			$this->load->view('templates/dashboard/landing', $data);
		} else {
			redirect(base_url());
		}
	}

	public function place_order()
	{
		$post = get_form_data();
		// debug($post);
		if ($post) {
			// debug($this->farm_cart, 1);
			if ($this->farm_cart) {
				$user = $this->accounts->profile['user'];
				$tracking_number = generate_invoice($user);
				// $tracking_number = 'LF-0B1F1-09';
				$tmp  = [
					'user_id' => $user['id'],
					'from_user_id' => 0,
					'code' => $tracking_number,
					'items' => [],
					'status' => 'Order Placed', /*order_placed in order_status table*/
					'status_id' => 5, /*order_placed in order_status table*/
					'delivery_fee' => 90.00, /*get lalamove delivery_fee*/
					'cash_handling' => 60.00, /*get cod cash_handling + transaction fee*/
					'subtotal' => 0.00,
					'total_amount' => 0.00,
				];
				$tmp = array_merge($tmp, $post);
				$items = [];
				foreach ($this->farm_cart as $rowid => $cart) {
					$cart['updated'] = date('Y-m-d H:i:s');
					$cart['rowid'] = $rowid;
					$cart['status'] = $tmp['status'];
					$cart['status_id'] = $tmp['status_id'];
					// debug($cart);
					$tmp['subtotal'] += (float)$cart['subtotal'];
					$tmp['from_user_id'] = $cart['from_user_id'];
					$tmp['address'] = $user['address'];
					
					$items[] = $cart;
					$this->cart->remove($rowid);
					$this->custom->remove('cart', ['user_id' => $user['id'], 'rowid' => $rowid, 'device_id' => $this->device_id]);
				}
				$tmp['total_amount'] += $tmp['subtotal'] + $tmp['delivery_fee'] + $tmp['cash_handling'];
				$tmp['items'] = serialize($items);
				// debug($tmp, 1);
				$id = $this->custom->create('order', $tmp);
				$order = $this->custom->get('order', ['id' => $id], false, 'row');
				redirect(base_url('order/'.$order['code']));
			}
		}
		redirect(base_url('orders'));
	}

}
