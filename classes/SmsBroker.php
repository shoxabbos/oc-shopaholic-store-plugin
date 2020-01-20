<?php namespace Shohabbos\Stores\Classes;

use Http;

class SmsBroker
{
	// auth
	private $username = "primusmall";
	private $password = "wKv2tRa4M";


	// provider data
	private $url = "http://91.204.239.42:8083/broker-api/send";
	private $port = "8083";
	private $data = [
		"messages" => [

		]
	];

	public function add($phone, $message) {
		$phone = preg_replace("/[^0-9]/", "", $phone);

		$message = [
			"recipient" => $phone,
			"message-id" => "pri".time().rand(),
			"sms" => [
				"originator" => "3700",
				"content" => [
					"text" => $message
				]
			]
		];

		$this->data['messages'][] = $message;

		return $this;
	}

	public function getData() {
		return $this->data;
	}


	public function send() {
		try {
			$hash = base64_encode($this->username.":".$this->password);
			$options = array(
			  'http' => array(
			    'method'  => 'POST',
			    'content' => json_encode($this->getData()),
			    'header'=>  "Content-Type: application/json\r\n" .
			                "Authorization: Basic {$hash}\r\n"
			    )
			);

			$context  = stream_context_create( $options );
			$result = file_get_contents($this->url, false, $context );
			return json_decode($result);
			
		} catch (\Exception $e) {
			\Flash::error('Error sms');
		}
	}


}