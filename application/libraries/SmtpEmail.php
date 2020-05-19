<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SmtpEmail /*implements EmailFunctions*/ {

	public $email = FALSE;
	public $db = FALSE;
	public $debug = FALSE;

	public function __construct()
	{
		$ci =& get_instance();
		$ci->load->library('email');
		$this->email = $ci->email;
		$this->db = $ci->db;
	}

	public function setup()
	{
		$this->email->clear();

		$config['protocol']		= 'smtp';
		$config['smtp_host']	= 'ssl://smtp.gmail.com';
		$config['smtp_port']	= '465';
		$config['smtp_timeout']	= '30';
		$config['smtp_user']	= 'gacelabs.inc@gmail.com';
		// $config['smtp_pass']	= 'mmlcr266242g!';
		$config['smtp_pass']	= 'xxrpcqoevoitdhfp';
		$config['charset']		= 'utf-8';
		$config['newline']		= "\r\n";
		$config['mailtype']		= 'html'; // or text
		$config['validate']		= FALSE; // bool whether to validate email or not      
		$config['_smtp_auth']	= TRUE;

		$this->email->initialize($config);
		
		return $this;
	}

	public function send($data=FALSE, $minutes=5, $bypass=FALSE)
	{
		if ($this->email AND $data) {
			// debug($bypass); exit();
			if ($bypass) {
				return $this->submit($data);
			} else {
				try {
					$session_id = session_id();
					$email = $this->db->get_where('email_session', ['session_id'=>$session_id]);
					// debug($email, 1);
					if ($email->num_rows() == 0) {
						$email = $this->db->insert('email_session', ['session_id'=>$session_id]);
					} else {
						$email = $email->row_array();
						/*check here now if the prev session id lapse 5 minutes*/
						$time_diff = time_diff($email['past'], date('Y-m-d H:i:s'), 'minutes', $minutes);
						// debug($time_diff, 1);
						if ($time_diff == FALSE) { /*not yet 5 minutes*/
							return FALSE;
						}
						$this->db->update('email_session', ['past' => date('Y-m-d H:i:s')], ['id'=>$email['id']]);
					}
					// debug($email, 1);
					return $this->submit($data);
				} catch (Exception $e) {
					return $e->getMessage();
				}
			}
		}
	}

	private function submit($data)
	{
		/*set from values*/
		if (!isset($data['email_from'])) {
			$this->email->from('gacelabs.inc@gmail.com', 'Gace Laboratories Inc.,');
		} else {
			$this->email->from($data['email_from'], (isset($data['email_from_name']) ? $data['email_from_name'] : ''), (isset($data['email_return']) ? $data['email_return'] : NULL));
		}
		
		/*set to values*/
		if (is_array($data['email_to'])) {
			$to = $data['email_to'];
		} else {
			$to = str_replace(';', ',', $data['email_to']);
		}
		$this->email->to($to);

		/*set cc and bcc values*/
		if (isset($data['email_cc'])) {
			$cc = str_replace(';', ',', $data['email_cc']);
			$this->email->cc($cc);
		}
		
		$this->email->bcc('gacelabs.inc@gmail.com');
		if (isset($data['email_bcc'])) {
			$bcc = str_replace(';', ',', $data['email_bcc']);
			$this->email->bcc($bcc);
		}
		
		/*set subject value*/
		$this->email->subject($data['email_subject']);
		
		/*set body message value*/
		$body = 'No message written.';
		if (isset($data['email_body_message']) OR isset($data['email_body_message_ext'])) {
			if (isset($data['email_body_message_ext'])) {
				$body = $data['email_body_message'].$data['email_body_message_ext'];
			} else {
				$body = $data['email_body_message'];
			}
		}
		$message = $body;

		/*default site footer*/
		$footer = '<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Served by: <a href="//send-data.co" title="'.APP_NAME.' APP v.'.APP_VERSION.'">'.APP_NAME.' APP v.'.APP_VERSION.'</a></p>';

		/*set email message*/
		$this->email->message($message.$footer);
		// debug($this->email); exit();

		/*send the message*/
		if ($this->debug) {
			$this->email->send();
			$debugger = $this->email->print_debugger();
			debug('==>'.$debugger); exit();
		} else {
			return $this->email->send();
		}
	}

	public function set_debug($value=FALSE)
	{
		$this->debug = $value;
		return $this;
	}
}