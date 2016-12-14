<?php
	function emailChecking($email){
		$emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
		$checkResult='';
		if(!preg_match($emailval, $email)){
			$checkResult = 'false';
			return $checkResult;
		}
	}
	function phoneChecking($phone){
		$mob="/^[1-9][0-9]*$/";
		$phoneVerify = '';
		if(!preg_match($mob, $phone)){
			$phoneVerify = 'false';
			return $phoneVerify;
		}		
	}
	function numbers_only($value)
	{
		return preg_match('/^([0-9]*)$/', $value);
	}
	function escape_str($str) {
		$str = htmlentities($str, ENT_QUOTES, 'UTF-8');
		return $str;
	}
	function escape_arr(&$arr) { 
		if(isset($arr) && $arr !='') {
			array_walk_recursive($arr, function (&$val) { 
				if(is_array($val) || is_object($val)) {
					escape_arr($val);
				} else {				
					$val = htmlentities($val, ENT_QUOTES, 'UTF-8');
				} 
			}); 
		}
	}
	
	
	function getUniqueCode($length = "")
	{
		$code = md5(uniqid(rand(), true));
		if ($length != "")
		return substr($code, 0, $length);
		else
		return $code;
	}
	function truncate($str, $width) {
	   return strtok(wordwrap($str, $width, "\n"), "\n");
	}
	function restClient($url, $method, $data ) {
		
		$cInit = curl_init();
		curl_setopt($cInit, CURLOPT_URL, $url);
		curl_setopt($cInit, CURLOPT_USERAGENT, 'SugarConnector/1.4');
		if($data != ""){
			curl_setopt($cInit, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
			'Content-Length: ' . strlen($data)
			));
		}else{
			curl_setopt($cInit, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
			//'Content-Length: ' . strlen($data)
			));
		}
		curl_setopt($cInit, CURLOPT_VERBOSE, 1);
		curl_setopt($cInit, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cInit, CURLOPT_CUSTOMREQUEST, $method);
		if($data != ""){
			curl_setopt($cInit, CURLOPT_POSTFIELDS,$data);
		}		
		curl_setopt($cInit, CURLOPT_SSL_VERIFYPEER, 0);
		$cLoginresult = curl_exec($cInit); 
		curl_close($cInit);
		return $cLoginresult;
	}
	function getImage($imgSrc){
		$img_src = $imgSrc.'?id='.date('Ymd') ."_". date("His");
		$imageExtentions 	=  	array('gif','png','jpg','jpeg','jpe');
		$videoExtentions 	=  	array('mp4');
		$extention 			= 	explode(".", $imgSrc);
		if(in_array(strtolower(end($extention)),$imageExtentions) ) {
			return $img_str   = 'data:image/'.strtolower(end($extention)).';base64,'.base64_encode(restClient($img_src, 'GET', '' ));
		}else if(in_array(strtolower(end($extention)),$videoExtentions) ) {
			return $img_str   = 'data:video/webm;base64,'.base64_encode(restClient($img_src, 'GET', '' ));
		}
	}
	function isMobile() {
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	}
	function autoVer($url){		
		$path = pathinfo($url); 
		$ver = '.15.'; 
		echo '/XDI/trunk/public/'.$path['dirname'].'/'.$path['filename'].$ver.$path['extension'];
	}
	function substring($name){
		$name = substr($name,0,18).'...';
		return $name;
	}
	function substringNon($nonStrName){
		$nonStrName = substr($nonStrName,0,15).'...';
		return $nonStrName;
	}
?>