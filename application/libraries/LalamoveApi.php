<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Lalamove\Client\Settings;
use Lalamove\Client\Client;
use Lalamove\Quotation;
use Lalamove\Order;
use Lalamove\Exceptions\PaymentRequiredException;
use Lalamove\Exceptions\LalamoveException;

class LalamoveApi {

	public $errors = array('success'=>1, 'code'=>200, 'message'=>'Lalamove Api initialized!');
	public $orders = [];
	public $order_responses = [];
	public $clients = [];
	public $quotations = [];
	public $quotation_responses = [];
	public $details = [];
	public $drivers = [];
	public $driver_locations = [];
	protected $settings = FALSE;
	protected $credits = FALSE;
	protected $host = FALSE;
	private $ci = FALSE;

	public function __construct($credits=FALSE)
	{
		if ($credits) {
			$this->ci =& get_instance();

			if (in_str($_SERVER['HTTP_HOST'], 'local.') OR in_str($_SERVER['HTTP_HOST'], 'localhost/localfarm')) {
				$this->host = 'https://sandbox-rest.lalamove.com';
			} else {
				$this->host = 'https://rest.lalamove.com';
			}

			$this->credits = $credits;
			$this->settings = new Settings(
				$this->host,
				$credits['id'], // customerId
				$credits['key'], // privateKey
				Settings::COUNTRY_PHILIPPINES // country
			);
			// debug($this->settings, 1);
		}
	}

	public function add_client($rowid=FALSE)
	{
		if ($this->check_client($rowid)) {
			try {
				$this->clients[$rowid] = new Client($this->settings);
				/*prepare quotation*/
				$this->quotations[$rowid] = new Quotation();
				$this->quotation_responses[$rowid] = $this->clients[$rowid]->quotations()->create($this->quotations[$rowid]);
			} catch (LalamoveException $ex) {
				$this->errors['success'] = 0;
				$this->errors['code'] = $ex->getStatusCode();
				$this->errors['message'] = $ex->getMessage();
			}
		}
		return $this;
	}

	public function create_order($rowid=FALSE)
	{
		if ($this->check_client($rowid)) {
			try {
				$this->orders[$rowid] = Order::makeFromQuote($this->quotations[$rowid], $this->quotation_responses[$rowid], $rowid, FALSE);
				$this->order_responses[$rowid] = $this->clients[$rowid]->orders()->create($this->orders[$rowid]);
			} catch (LalamoveException $ex) {
				$this->errors['success'] = 0;
				$this->errors['code'] = $ex->getStatusCode();
				$this->errors['message'] = $ex->getMessage();
			}
		}
		return $this;
	}

	public function order_details($rowid=FALSE)
	{
		if ($this->check_client($rowid)) {
			try {
				$this->details[$rowid] = $this->clients[$rowid]->orders()->details($this->order_responses[$rowid]->customerOrderId);
			} catch (LalamoveException $ex) {
				$this->errors['success'] = 0;
				$this->errors['code'] = $ex->getStatusCode();
				$this->errors['message'] = $ex->getMessage();
			}
		}
		return $this;
	}

	public function driver_status($rowid=FALSE)
	{
		if ($this->check_client($rowid)) {
			try {
				$this->drivers[$rowid] = $this->clients[$rowid]->drivers()->get($this->order_responses[$rowid]->customerOrderId, $this->details[$rowid]->driverId);
				$this->driver_locations[$rowid] = $this->clients[$rowid]->drivers()->getLocation($this->order_responses[$rowid]->customerOrderId, $this->details[$rowid]->driverId);
			} catch (LalamoveException $ex) {
				$this->errors['success'] = 0;
				$this->errors['code'] = $ex->getStatusCode();
				$this->errors['message'] = $ex->getMessage();
			}
		}
		return $this;
	}

	public function cancel_order($rowid=FALSE)
	{
		if ($this->check_client($rowid)) {
			try {
				$this->details[$rowid] = $this->clients[$rowid]->orders()->cancel($this->order_responses[$rowid]->customerOrderId);
			} catch (LalamoveException $ex) {
				$this->errors['success'] = 0;
				$this->errors['code'] = $ex->getStatusCode();
				$this->errors['message'] = $ex->getMessage();
			}
		}
		return $this;
	}

	public function reset($rowid=FALSE, $all=FALSE)
	{
		$this->errors = array('success'=>1, 'code'=>200, 'message'=>'Lalamove Api initialized!');
		if ($this->check_client($rowid)) {
			unset($this->orders[$rowid]);
			unset($this->order_responses[$rowid]);
			unset($this->clients[$rowid]);
			unset($this->quotations[$rowid]);
			unset($this->quotation_responses[$rowid]);
			unset($this->details[$rowid]);
			unset($this->drivers[$rowid]);
			unset($this->driver_locations[$rowid]);
		} elseif ($all) {
			$this->orders = [];
			$this->order_responses = [];
			$this->clients = [];
			$this->quotation = [];
			$this->quotation_responses = [];
			$this->details = [];
			$this->drivers = [];
			$this->driver_locations = [];
		}

		return $this;
	}

	private function check_client($rowid=FALSE)
	{
		return ($rowid AND isset($this->clients[$rowid]));
	}
}