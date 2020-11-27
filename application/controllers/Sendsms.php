<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendsms extends CI_Controller {
 
    function index()
    {
	// $this->load->library('setupfile');
	// $this->setupfile->send("919033129796", "Hello there this is message");
    	// / Account details
		$apiKey = urlencode('R+SE/qLHCkw-AN9EaE7pwUmg9yX6zyq5sZwNqEdCRJ');
		// Message details
		$numbers = array('918200648139');
		$sender = urlencode('TXTLCL');
		$message = rawurlencode('This is your message Amit');
		 
		$numbers = implode(',', $numbers);
		 
		// Prepare data for POST request
		$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
		// Send the POST request with cURL
		$ch = curl_init('https://api.textlocal.in/send/');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		// Process your response here
		echo $response;
    }
}

