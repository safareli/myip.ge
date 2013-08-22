<?php

function view($filename,$params){
	// ob_start(function callback($buffer){
	// 	foreach ($params as $key => $value) {
	// 		$buffer = str_replace("{{$key}}", $value, $buffer)
	// 	}
	//   	// replace all the apples with oranges
	//    	return $buffer; 
	// });

	// include 'view/'.$filename.'.VIEW';
	
	// return ob_end_flush();
	ob_start();

	include 'view/'.$filename.'.VIEW';
	
	$buffer = ob_get_clean();
	
	foreach ($params as $key => $value) {
		$buffer = str_replace('{{'.$key.'}}', $value, $buffer);
	}

   	return $buffer; 
}

function getIpAddress(){
	$keyArray = array(
		'HTTP_CLIENT_IP', 
		'HTTP_X_FORWARDED_FOR', 
		'HTTP_X_FORWARDED', 
		'HTTP_X_CLUSTER_CLIENT_IP', 
		'HTTP_FORWARDED_FOR', 
		'HTTP_FORWARDED', 
		'REMOTE_ADDR'
	);
	$needtochangeTODO = '';
    foreach ($keyArray as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){ 
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }else{
                	$needtochangeTODO = $ip;
                }
            }
        }
    }
    return $needtochangeTODO;
}

$ip = getIpAddress();
if (!$ip) {
	$qrurl =  "rame poto sadac inkognitos ikonia";
	$ip =  "UNKNOWN";
}else{
	$qrurl ='http://qrfree.kaywa.com/?l=1&s=8&d=http%3A%2F%2F'.$ip;
}

$params = array(
	'ip' =>$ip,
	'qrurl' => $qrurl
);

die( view('index', $params ) );