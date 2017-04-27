<?php
class CPWrapper {

	public $auth_user;
	public $auth_pass;
	public $site_url;

	private $auth_header;

	

	public function sendRequest($uri,$data){

			$ch = curl_init();//."?".urldecode($data_string));

	        curl_setopt($ch, CURLOPT_URL, $this->site_url.$uri);
	        curl_setopt($ch, CURLOPT_USERPWD, $this->auth_name . ":" . $this->auth_pass);  
	        //if data exsist then send POST else send GET
	        if(!empty($data)){
	            $data_string = http_build_query($data);
	            curl_setopt($ch, CURLOPT_POST, true);
	            curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode($data_string));
	        }

	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        //loging errors TODO: FOR ALPHA only 
	       	$fp = fopen(dirname(__FILE__).'/errorlog.txt', 'w');

	       	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	        curl_setopt($ch, CURLOPT_STDERR, $fp);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	        //      $this->getAuthHeader(),
	        // ));
	        $result = curl_exec($ch);
	        return json_decode($result);
	    }
	

	public function createOrder($body){
		$uri = '/api/orders';
		$data = [
			'body' => $body,
		];
		return $this->sendRequest($uri,$data);
	}	
}
