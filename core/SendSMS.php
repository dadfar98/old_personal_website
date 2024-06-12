<?php
$key = '3ce88d1b0e760f31daa9bdd90435ddd7f857fdeb18a3f959c9a999c12a19c113d366d0aa36efede7ca8fd3f2275a654637d6796d333133f8c7f6f33aa38668dc';
$api_ipg = 'https://www.pishroara.ir/customers/php/sendsms_ad.php';

function SendSMS($sms_text, $sms_to) {
    $ValidationAndSendSMS = ValidationAndSendSMS($sms_text, $sms_to);
    $ValidationAndSendSMS = json_decode($ValidationAndSendSMS, true);
    if($ValidationAndSendSMS['status'] != 1){
        echo $ValidationAndSendSMS['response'];
        exit;
    }
}

function ValidationAndSendSMS($text = null, $phone = null) {

    global $key;
    global $api_ipg;

    if(!empty($key)){
        
        $ch = curl_init();
        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:62.0) Gecko/20100101 Firefox/62.0',
            'Content-Type: application/json',
            'Accept: */*',
            'Cache-Control: no-cache',
            'X-Requested-With: XMLHttpRequest'
        ];
        
        $vars = array(
            'action' => 'sendSMS',
            'text' => $text,
            'phone' => $phone,
            'key' => $key
        );
        
        curl_setopt($ch, CURLOPT_URL, $api_ipg);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        $res = json_decode($res, true);
        
        /*print_r($res);
        exit;*/
        
        if($res['status'] === 1){
            $message = $res['response'];
            $status = 1;
        }
        else{
            $message = $res['response'];
            $status = 0;
        }
    }
    else{
        $message = 'Key is empty!';
        $status = 0;
    }
    
    $response = array(
        "response" => $message,
        "status" => $status
    );
    if($status){
        return json_encode($response);
    }else{
        echo json_encode($response);
    }
}


echo SendSMS("hello", "09376408840");

