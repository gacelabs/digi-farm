<?php

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;

use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Exception\PayPalConnectionException;

class SinglePayment /*implements PayPalMethodFunctions*/ {
	
	public $response = FALSE;
	public $errors = array('success'=>0, 'code'=>404, 'message'=>'Invalid Parameters!');
	public $request = FALSE;
	public $payment = FALSE;
	public $approval_url = FALSE;
	protected $payer = FALSE;
	protected $item = FALSE;
	protected $item_list = FALSE;
	protected $details = FALSE;
	protected $amount = FALSE;
	protected $transaction = FALSE;
	protected $redirect_urls = FALSE;
	protected $payment_execution = FALSE;
	private $ci = FALSE;

	public function __construct()
	{
		$this->payment = new Payment();
		$this->payer = new Payer();
		$this->item = new Item();
		$this->item_list = new ItemList();
		$this->details = new Details();
		$this->amount = new Amount();
		$this->transaction = new Transaction();
		$this->redirect_urls = new RedirectUrls();
		$this->payment_execution = new PaymentExecution();
		$this->ci =& get_instance();
	}

	public function set_data($data=FALSE)
	{
		if ($data) {
			$this->clear();
			$data = (array)$data;
			try {
				$method = 'paypal';
				if (isset($data['payment_method'])) {
					$method = $data['payment_method'];
				}
				$this->payer->setPaymentMethod($method);
				$items = [];
				$subtotal = $total = 0;
				foreach ($data['items'] as $key => $item) {
					$items[] = $this->item->setName($item['name'])
						->setCurrency($data['currency'])
						->setQuantity($item['quantity'])
						->setSku($item['sku']) // Similar to `item_number` in Classic API
						->setPrice($item['price']);
					$subtotal += ((float)$item['quantity'] * (float)$item['price']);
				}
				$total = $subtotal;
				$this->item_list->setItems($items);

				if (isset($data['details'])) {
					if (isset($data['details']['subtotal'])) {
						$total = $subtotal = (float)$data['details']['subtotal'];
					}
					if (isset($data['details']['shipping_fee'])) {
						$this->details->setShipping($data['details']['shipping_fee']);
						$total += (float)$data['details']['shipping_fee'];
					}
					if (isset($data['details']['tax'])) {
						$this->details->setTax($data['details']['tax']);
						$total += (float)$data['details']['tax'];
					}
				}
				$this->details->setSubtotal($subtotal);

				$this->amount->setCurrency($data['currency'])
					->setTotal($total)
					->setDetails($this->details);
				
				$this->transaction->setAmount($this->amount)
					->setItemList($this->item_list)
					->setDescription($data['payment_description']);

				if (isset($data['invoice_number'])) {
					$this->transaction->setInvoiceNumber($data['invoice_number']);
				} else {
					$this->transaction->setInvoiceNumber($this->_invoice_number());
				}

				$this->redirect_urls->setReturnUrl($data['return_url'])
					->setCancelUrl($data['cancel_url']);

				$this->payment->setIntent("sale")
					->setPayer($this->payer)
					->setRedirectUrls($this->redirect_urls)
					->setTransactions(array($this->transaction));

				$this->errors = array('success'=>1, 'code'=>200, 'message'=>'Single payment was set!');
			} catch (PayPalConnectionException $ex) {
				$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>json_decode($ex->getData(), TRUE));
			}

			$this->request = $data;
		}
		return $this;
	}

	public function create($context=FALSE)
	{
		if ($context AND $this->payment) {
			try {
				$this->payment->create($context);
				sleep(3);
				$this->approval_url = $this->payment->getApprovalLink();
				$this->errors = array('success'=>1, 'code'=>200, 'message'=>'Single payment created!');
			} catch (PayPalConnectionException $ex) {
				$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>json_decode($ex->getData(), TRUE));
			}
		}
		return $this;
	}

	public function get_data($context=FALSE, $is_json=FALSE)
	{
		if ($this->payment == FALSE AND $this->request) {
			$this->clear()
				->set_data($this->request)
				->create($context)
				->get_data($context, $is_json);
		} else {
			if ($context) {
				try {
					$Payment = new Payment();
					$payment_id = $this->payment->getId();
					if ($is_json) {
						$this->response = $Payment::get($payment_id, $context)->toJSON();
					} else {
						$this->response = $Payment::get($payment_id, $context)->toArray();
					}
					$this->errors = array('success'=>1, 'code'=>200, 'message'=>'Single payment fetched!');
				} catch (PayPalConnectionException $ex) {
					$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>json_decode($ex->getData(), TRUE));
				}
			}
		}
		return $this;
	}

	public function change_data($context=FALSE, $data=FALSE)
	{
		if ($context AND $data) {
			try {
				$patches = [];
				foreach ($data['path'] as $path => $row) {
					$new_patch = new Patch();
					switch ($path) {
						case 'shipping_address':
							/*mode is either add or replace*/
							$new_patch->setOp($row['mode'])
								->setPath('/transactions/0/item_list/shipping_address')
								/*
								SAMPLE VALUE must be a json string
								'{"recipient_name": "Gruneberg, Anna","line1": "52 N Main St","city": "San Jose","state": "CA","postal_code": "95112","country_code": "US"}'
								*/
								->setValue(json_decode($row['json']));
						break;
						case 'amount':
							/*mode is either add or replace*/
							$new_patch->setOp($row['mode'])
								->setPath('/transactions/0/amount')
								/*
								SAMPLE VALUE must be a json string
								'{"total": "25.00","currency": "USD","details": {"subtotal": "17.50","shipping": "6.20","tax":"1.30"}}'
								*/
								->setValue(json_decode($row['json']));
						break;
					}
					$patches[] = $new_patch;
				}

				$patch_request = new PatchRequest();
				$patch_request->setPatches($patches);

				$result = $this->payment->update($patch_request, $context);
				sleep(3);
				if ($result == TRUE) {
					$Payment = new Payment();
					$payment_id = $this->payment->getId();
					$this->payment = $updated = $Payment::get($payment_id, $context);
					foreach ($updated->getLinks() as $link) {
						if ($link->getRel() == 'approval_url') {
							$this->approval_url = $link->getHref();
							break;
						}
					}
					$this->errors = array('success'=>1, 'code'=>200, 'message'=>'Single payment updated!');
				} else {
					$this->errors = array('success'=>0, 'code'=>404, 'message'=>'Single payment failed to update!');
				}
			} catch (PayPalConnectionException $ex) {
				$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>json_decode($ex->getData(), TRUE));
			}
		}

		return $this;
	}

	public function update_request($data=FALSE)
	{
		if ($data) {
			$this->request = (array)$data;
		}
		return $this;
	}

	public function execute($context=FALSE, $data=FALSE)
	{
		if ($data AND $context) {
			if (isset($data['get'])) {
				$get = $data['get'];
				if (isset($get['success']) AND in_array(strtolower($get['success']), ['true', '1'])) {
					$this->clear();

					$payment_id = $get['paymentId'];
					
					$Payment = new Payment();
					$this->payment = $Payment::get($payment_id, $context);
					
					$payment_data = $this->payment->toArray();
					// debug($this->payment->toArray()); exit();
					
					$this->payment_execution->setPayerId($get['PayerID']);

					$transactions = $payment_data['transactions'];
					foreach ($transactions as $key => $trans) {
						$details = new Details();
						$amount = new Amount();
						$transaction = new Transaction();

						$amt = $trans['amount'];
						if (isset($amt['details']['shipping'])) {
							$details->setShipping($amt['details']['shipping']);
						}
						if (isset($amt['details']['tax'])) {
							$details->setTax($amt['details']['tax']);
						}
						$details->setSubtotal($amt['details']['subtotal']);
						
						$amount->setCurrency($amt['currency']);
						$amount->setTotal($amt['total']);
						$amount->setDetails($details);
						
						$transaction->setAmount($amount);
						$this->payment_execution->addTransaction($transaction);
					}

					try {
						$this->payment->execute($this->payment_execution, $context);
						$Payment = new Payment();
						$this->payment = $Payment::get($payment_id, $context);
						$this->response = $this->payment->toArray();
						$this->errors = array('success'=>1, 'code'=>200, 'message'=>'Payment approved!');
					} catch (PayPalConnectionException $ex) {
						$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>json_decode($ex->getData(), TRUE));
					}
				} else {
					$this->errors = array('success'=>0, 'code'=>301, 'message'=>'User canceled the payment!');
				}
			} else {
				$this->errors = array('success'=>0, 'code'=>404, 'message'=>'One of Redirect Urls is empty!');
			}
		} else {
			$this->errors = array('success'=>0, 'code'=>404, 'message'=>'Single payment object not yet initialized!');
		}
		return $this;
	}

	private function _invoice_number()
	{
		$random = date('dmy').'-'.str_pad(rand(0,10000), 5, "0", STR_PAD_LEFT).'-'.substr(rand(0,time()), 0, 2);
		return $random;
	}

	public function clear()
	{
		$this->response = FALSE;
		$this->errors = array('success'=>1, 'code'=>301, 'message'=>'Payment object cleared!');
		$this->payment = new Payment();
		$this->payer = new Payer();
		$this->item = new Item();
		$this->item_list = new ItemList();
		$this->details = new Details();
		$this->amount = new Amount();
		$this->transaction = new Transaction();
		$this->redirect_urls = new RedirectUrls();
		$this->payment_execution = new PaymentExecution();
		return $this;
	}

}