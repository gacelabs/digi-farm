<?php

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

class BillingPlan /*implements PayPalMethodFunctions*/ {
	
	public $response = FALSE;
	public $errors = array('success'=>0, 'code'=>404, 'message'=>'Invalid Parameters!');
	public $request = FALSE;
	public $plan = FALSE;
	protected $payment_definition = FALSE;
	protected $charge = FALSE;
	protected $merchant = FALSE;
	protected $patch = FALSE;
	protected $patch_request = FALSE;
	private $ci = FALSE;

	public function __construct()
	{
		$this->plan = new Plan();
		$this->payment_definition = new PaymentDefinition();
		$this->charge = new ChargeModel();
		$this->merchant = new MerchantPreferences();
		$this->patch = new Patch();
		$this->patch_request = new PatchRequest();
		$this->ci =& get_instance();
	}

	public function set_data($data=FALSE)
	{
		if ($data) {
			$data = (array)$data;
			try {
				$this->plan->setName($data['name'])
					->setDescription($data['description']);
				if (isset($data['plan_type'])) {
					$this->plan->setType($data['plan_type']); // should be set in dpt helm settings
				}

				$this->payment_definition->setName($data['definition'])
					->setType('REGULAR') // for now its regular, should be set in dpt helm settings if trial enabled
					->setFrequency($data['frequency']) // should be set in dpt helm settings
					->setFrequencyInterval($data['interval']) // should be set in dpt helm settings
					->setAmount(new Currency(array('value' => $data['amount'], 'currency' => $data['currency']))); // should be set in dpt helm settings
				if (isset($data['cycle'])) {
					$this->payment_definition->setCycles($data['cycle']); // should be set in dpt helm settings
				}

				// should be set in dpt helm settings
				if (isset($data['is_shipping']) AND $data['is_shipping'] == TRUE AND isset($data['shipping'])) {
					$this->charge->setType('SHIPPING')
						->setAmount(new Currency(array('value' => $data['shipping']['amount'], 'currency' => $data['currency'])));
					$this->payment_definition->setChargeModels(array($this->charge));
				}

				$this->merchant->setReturnUrl($data['return_url'])
					->setCancelUrl($data['cancel_url'])
					->setAutoBillAmount(((isset($data['is_autobilling']) AND $data['is_autobilling'])?"yes":"no"))
					// ->setInitialFailAmountAction("CONTINUE")
					// ->setInitialFailAmountAction("CANCEL")
					->setMaxFailAttempts("3"); // should be set in dpt helm settings
				if (isset($data['is_feeable']) AND $data['is_feeable'] == TRUE AND isset($data['fee'])) {
					$this->merchant->setSetupFee(new Currency(array('value' => $data['fee']['amount'], 'currency' => $data['currency'])));
				}

				$this->plan->setPaymentDefinitions(array($this->payment_definition));
				$this->plan->setMerchantPreferences($this->merchant);

			} catch (Exception $ex) {
				$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>$ex->getMessage());
			}

			$this->request = $data;
		}
		return $this;
	}

	public function create($context=FALSE)
	{
		if ($context AND $this->plan) {
			try {
				$this->plan->create($context);
				$this->errors = array('success'=>1, 'code'=>200, 'message'=>'Billing Plan created!');
			} catch (Exception $ex) {
				$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>$ex->getMessage());
			}
		}
		return $this;
	}

	public function get_data($context=FALSE, $is_json=FALSE)
	{
		if ($this->plan == FALSE AND $this->request) {
			$this->clear()
				->set_data($this->request)
				->create($context)
				->get_data($context, $is_json);
		} else {
			if ($context) {
				try {
					$Plan = new Plan;
					if ($is_json) {
						$this->response = $Plan::get($this->plan->getId(), $context)->toJSON();
					} else {
						$this->response = $Plan::get($this->plan->getId(), $context)->toArray();
					}
					$this->errors = array('success'=>1, 'code'=>200, 'message'=>'Billing Plan fetched!');
				} catch (Exception $ex) {
					$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>$ex->getMessage());
				}
			}
		}
		return $this;
	}

	public function change_data($context=FALSE, $data=FALSE)
	{
		if ($context AND $data) {
			try {
				$value = new PayPalModel($data);

				$this->patch->setOp('replace')->setPath('/')->setValue($value);
				$this->patch_request->addPatch($this->patch);
				$this->plan->update($this->patch_request, $context);
				$Plan = new Plan;
				$this->plan = $Plan::get($this->plan->getId(), $context);
			} catch (Exception $ex) {
				$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>$ex->getMessage());
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
		$this->errors = array('success'=>1, 'code'=>301, 'message'=>'Billing Object Cleared!');
		$this->plan = new Plan();
		$this->payment_definition = new PaymentDefinition();
		$this->charge = new ChargeModel();
		$this->merchant = new MerchantPreferences();
		return $this;
	}

}