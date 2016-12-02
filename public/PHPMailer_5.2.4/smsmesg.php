<?php 
	function sentSms($mobile_num,$message){			
		$user="lifeflo"; //your username 
		$password="Life_89-flo"; //your password
		$mobilenumbers="$mobile_num"; //enter Mobile numbers comma seperated
		$message = "$message"; //enter Your Message
		$senderid="BIKSEV"; //Your senderid
		$messagetype="N"; //Type Of Your Message
		$DReports="Y"; //Delivery Reports
		$message = urlencode($message);
		$url = "http://119.81.202.40/trans/api/http_sms_api.php";	
		
		//GET METHODE
		$ch = curl_init();
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
		);
		curl_setopt($ch, CURLOPT_URL, $url.'?username='.$user.'&password='.$password.'&to='.$mobilenumbers.'&message='.$message.'&sender_id='.$senderid);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$resp = curl_exec($ch);
		return $resp;
	}
?>