<?php

use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Exception\PayPalConnectionException;

class AgreementPlan /*implements PayPalMethodFunctions*/ {
	
	public $response = FALSE;
	public $approval_url = '';
	public $request = FALSE;
	public $errors = array('success'=>0, 'code'=>404, 'message'=>'Invalid Parameters!');
	public $plan = FALSE;
	public $agreement = FALSE;
	protected $payer = FALSE;
	protected $payer_info = FALSE;
	protected $shipping = FALSE;
	protected $patch = FALSE;
	protected $patch_request = FALSE;
	private $ci = FALSE;

	public function __construct()
	{
		$this->plan = new Plan();
		$this->agreement = new Agreement();
		$this->payer = new Payer();
		$this->payer_info = new PayerInfo();
		$this->shipping = new ShippingAddress();
		$this->patch = new Patch();
		$this->patch_request = new PatchRequest();
		$this->ci =& get_instance();
	}

	public function set_data($data=FALSE)
	{
		if ($data) {
			$data = (array)$data;
			// debug(date('c', strtotime($data['date']))); exit();
			$this->agreement->setName($data['name'])
				->setDescription($data['description'])
				->setStartDate(date('c', strtotime($data['date']))); /*2019-06-17T9:45:04Z*/ /* format "Y-d-mTG:i:sz"*/
			
			$this->plan->setId($data['plan']->getId());
			$this->agreement->setPlan($this->plan);

			/*set payer here*/
			// $this->payer_info->
			$this->payer->setPaymentMethod($data['payment_method']);
			$this->agreement->setPayer($this->payer);

			if (isset($data['is_shipping']) AND $data['is_shipping'] == TRUE AND isset($data['shipping'])) {
				$this->shipping->setLine1($data['shipping']['line_1'])
					->setCity($data['shipping']['city'])
					->setState($data['shipping']['state'])
					->setPostalCode($data['shipping']['postal'])
					->setCountryCode($data['shipping']['country']);
				$this->agreement->setShippingAddress($this->shipping);
			}

			$this->request = $data;
		}

		return $this;
	}

	public function create($context=FALSE)
	{
		if ($context AND $this->agreement) {
			try {
				$agreement = $this->agreement->create($context);
				$this->approval_url = $agreement->getApprovalLink();
				$this->errors = array('success'=>1, 'code'=>200, 'message'=>'Agreement Plan created!');
			} catch (PayPalConnectionException $ex) {
				$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>json_decode($ex->getData(), TRUE));
			}
		}
		// debug($agreement); exit();
		return $this;
	}

	public function get_data($context=FALSE, $is_json=FALSE)
	{
		if ($this->agreement == FALSE AND $this->request) {
			$this->clear()
				->set_data($this->request)
				->create($context)
				->get_data($context, $is_json);
		} else {
			if ($context) {
				try {
					$Agreement = new Agreement;
					if ($is_json) {
						$this->response = $Agreement::get($this->agreement->getId(), $context)->toJSON();
					} else {
						$this->response = $Agreement::get($this->agreement->getId(), $context)->toArray();
					}
					$this->errors = array('success'=>1, 'code'=>200, 'message'=>'Agreement Plan fetched!');
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
				$this->patch->setOp('replace')->setPath('/')->setValue($data);
				
				$this->patch_request->addPatch($this->patch);
				$this->agreement->update($this->patch_request, $context);
				$Agreement = new Agreement;
				$this->agreement = $Agreement::get($this->agreement->getId(), $context);
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

	public function clear()
	{
		$this->response = FALSE;
		$this->errors = array('success'=>0, 'code'=>404, 'message'=>'Agreement Object Cleared!');
		$this->plan = new Plan();
		$this->agreement = new Agreement();
		$this->payer = new Payer();
		$this->shipping = new ShippingAddress();
		return $this;
	}

}