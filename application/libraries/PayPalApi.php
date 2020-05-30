<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require dirname(dirname(__DIR__)) . '/vendor/autoload.php';
require dirname(dirname(__DIR__)) . '/application/libraries/paypal/autoload.php';

use PayPal\Rest\ApiContext;

class PayPalApi /*implements PayPalFunctions*/ {

	public $output = FALSE;
	public $errors = array('success'=>0, 'code'=>404, 'message'=>'PayPal Api not initialized!');
	public $context = FALSE;
	protected $credits = FALSE;
	private $ci = FALSE;

	public function __construct($credits=FALSE)
	{
		if ($credits) {
			$this->ci =& get_instance();
			$this->credits = (array)$credits;
			$this->initialize();
		}
	}

	public function initialize($credits=FALSE)
	{
		if ($credits AND $this->credits == FALSE) {
			$this->credits = $this->credentials($credits);
		} elseif ($this->credits == FALSE) {
			$this->errors = array('success'=>0, 'code'=>404, 'message'=>'PayPal Api credentials not set!');
			return $this;
		}

		try {
			$root_dir = (isset($_SERVER['CONTEXT_DOCUMENT_ROOT']) ? $_SERVER['CONTEXT_DOCUMENT_ROOT'] : dirname(dirname(__DIR__)));
			$this->context = new \PayPal\Rest\ApiContext(
				new \PayPal\Auth\OAuthTokenCredential($this->credits['key'], $this->credits['secret'])
			);
			$this->context->setConfig([
				'mode' => (((bool)strstr($_SERVER['SERVER_NAME'], 'local')==TRUE) ? 'sandbox' : 'live'),
				'log.LogEnabled' => TRUE,
				'log.FileName' => $root_dir.'/PayPal.log',
				'log.LogLevel' => 'DEBUG', /*PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS*/
				'cache.enabled' => TRUE,
				/*'cache.FileName' => '/PaypalCache'*/ /*for determining paypal cache directory*/
				'http.CURLOPT_CONNECTTIMEOUT' => 720
				/*'http.headers.PayPal-Partner-Attribution-Id' => '123123123'*/
				/*'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory'*/ /*Factory class implementing \PayPal\Log\PayPalLogFactory*/
			]);
			$this->errors = array('success'=>1, 'code'=>200, 'message'=>'PayPal Api initialized!');
		} catch (Exception $ex) {
			$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>$ex->getMessage());
		}
		// debug($this); exit();
	}

	public function credentials($credits=FALSE)
	{
		if ($credits) {
			$this->credits = (array)$credits;
		}
		return $this;
	}

	public function fetch()
	{
		// debug(get_class($this->output)); exit();
		if ($this->context) {
			switch (get_class($this->output)) {
				case 'BillingPlan':
					$this->output->get_data($this->context);
				break;

				case 'AgreementPlan':
					$this->output->get_data($this->context);
				break;

				case 'SinglePayment':
					$this->output->get_data($this->context);
				break;
				
				default:
					/*no defaults yet*/
				break;
			}
		}

		// debug($this); exit();
		return $this;
	}

	public function instanciate($class='')
	{
		if ($this->context) {
			switch ($class) {
				case 'BillingPlan':
					$this->output = new BillingPlan;
				break;

				case 'AgreementPlan':
					$this->output = new AgreementPlan;
				break;

				case 'SinglePayment':
					$this->output = new SinglePayment;
				break;
				
				default:
					/*no defaults yet*/
				break;
			}
		}

		// debug($this); exit();
		return $this;
	}

	public function approve($data=FALSE)
	{
		if ($data) {
			if ($this->context) {
				switch (get_class($this->output)) {
					case 'AgreementPlan':
						$this->output->agreement->execute($data, $this->context);
					break;
					
					case 'SinglePayment':
						$this->output->execute($this->context, $data);
					break;
					
					default:
						/*no defaults yet*/
					break;
				}
			}
			// debug($this); exit();
		}
		return $this;
	}

	public function submit($args=FALSE)
	{
		if ($args) {
			$args = (array)$args;
			switch ($args['method']) {
				case 'Billing':
					$billing = new BillingPlan;
					$billing->set_data($args['data'])->create($this->context);
					// debug($billing); exit();
					$this->output = $billing;
				break;
				case 'Agreement':
					$billing = new BillingPlan;
					$billing->set_data($args['data'])->create($this->context);
					$billing->change_data($this->context, '{"state":"ACTIVE"}');
					// debug($billing); exit();
					$args['data']['plan'] = $billing->plan;
					$agreement = new AgreementPlan;
					$agreement->set_data($args['data'])->create($this->context);
					// debug($agreement); exit();
					$this->output = $agreement;
				break;

				case 'SinglePayment':
					$single_payment = new SinglePayment;
					$single_payment->set_data($args['data'])->create($this->context);
					// debug($single_payment); exit();
					$this->output = $single_payment;
				break;
				
				default:
					/*no defaults yet*/
				break;
			}
		}
		return $this;
	}

	public function override($data=FALSE)
	{
		if ($this->output AND $this->context AND $data) {
			try {
				switch (get_class($this->output)) {
					case 'BillingPlan':
						/*ex $data: ["state" => "ACTIVE"]*/
						$this->output->change_data($this->context, $data);
					break;
					
					case 'AgreementPlan':
						/*ex $data: [
						'description' => $description,
						'shipping_address' => [
							'line1' => $line_1,
							'city' => $city,
							'state' => $state,
							'postal_code' => $postal,
							'country_code' => $country
						]]*/
						$this->output->change_data($this->context, $data);
					break;

					case 'SinglePayment':
						/*ex $data: [
						'path' => [
							'shipping_address' => 
								['mode' => 'add', 'json' => '{"recipient_name": "Gruneberg, Anna","line1": "52 N Main St","city": "San Jose","state": "CA","postal_code": "95112","country_code": "US"}'],
							'amount' => 
								['mode' => 'replace', 'json' => '{"total": "25.00","currency": "USD","details": {"subtotal": "17.50","shipping": "6.20","tax":"1.30"}}']
						]]*/
						$this->output->change_data($this->context, $data);
					break;
					
					default:
						/*no defaults yet*/
					break;
				}
			} catch (Exception $ex) {
				$this->errors = array('success'=>0, 'code'=>$ex->getCode(), 'message'=>$ex->getMessage());
			}
		}

		return $this;
	}

	public function clear()
	{
		$this->output = FALSE;
		$this->initialize();
		$this->errors = array('success'=>1, 'code'=>200, 'message'=>'PayPal Api re-initialized!');
		return $this;
	}

}