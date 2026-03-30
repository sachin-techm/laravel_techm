<?php

namespace App\Notifications;

class SmsNotification {

    private static $APIKey 		= "AAAAAAAAAAAAAAAAAAAAAAAAAAAA";
    private static $url 		= "http://2factor.in/API/V1/";
    private static $header 		= "AAAAAAAAAAAAAAAAAAAAAAAAAAAA";
    private static $template 	= "AAAAAAAAAAAAAAAAAAAAAAAAAAAA";

   
    public static function send_otp($otp, $mobile) {
    	
        return;
        $curl = curl_init();
        $postData 			= [];
        $postData['From'] 	= self::$header;
        $postData['To'] 	= $mobile;
        $postData['TemplateName'] = self::$template;
        $postData['VAR1'] 	= $otp;

        // http://2factor.in/API/V1/293832-67745-11e5-88de-5600000c6b13/ADDON_SERVICES/SEND/TSMS
        $url = self::$url.self::$APIKey."/ADDON_SERVICES/SEND/TSMS";
		        
		curl_setopt_array($curl, array(
		  	CURLOPT_URL => $url,
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_ENCODING => "",
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 30,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => "POST",
		  	CURLOPT_POSTFIELDS => json_encode($postData),
		  	CURLOPT_HTTPHEADER => array(
		    "content-type: application/x-www-form-urlencoded"
		  	),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		// dd($response);

		if ($err) {
		  	return "cURL Error #:" . $err;
		  	

		} else {
		  	return $response;
		}
    }
    
}