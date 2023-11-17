<?php

namespace Abasb75\PhpSms;

class SMS {
    
    private $webService;
    private $config;

    function __construct($webService,$config){
        require_once "services/$webService.php";
        $this->webService = new $webService($config);
    }

    private function readDataFromSMSFile($center=null){

        $filePrefix = '/var/sms-data/';
        $smsDataFile = $filePrefix;
        if(!$center){
          $smsDataFile .= 'SUMS';
        }elseif( file_exists( $filePrefix.strtoupper($center[0]) ) ) {
          $smsDataFile .= strtoupper($center[0]);
        }else{
          $smsDataFile .= 'SUMS';
        }

        $smsFile = fopen($smsDataFile, "r") or exit('{"status":false,"message":"can not open file"}');
        $smsData = fread($smsFile,filesize($smsDataFile));
        fclose($smsFile);

        $smsData = preg_split('/\r\n|\r|\n/',$smsData);
      
        if(count($smsData) < 5) exit('{"status":false,"message":"sms data lines is smaller than 5"}');
        
        $finalResult = [];
        foreach($smsData as $dt){
          $lineData = explode(':',$dt,2);
          if(count($smsData) < 2) exit('{"status":false,"message":"sms data not valid"}');
          $finalResult[trim($lineData[0])] = trim($lineData[1]);
        }
      
        if(
          !isset($finalResult['ph']) 
          or !isset($finalResult['url']) 
          or !isset($finalResult['org']) 
          or !isset($finalResult['user']) 
          or !isset($finalResult['pass']) 
        ){
          exit('{"status":false,"message":"final result not valid"}');
        }
        $this->userName = $finalResult['user'];
        $this->password = $finalResult['pass'];
        $this->organazation = $finalResult['org'];
        $this->senderNumber = $finalResult['ph'];
        $this->apiUrl = $finalResult['url'];
      
    }

    public function send($userPhone,$smsBody){
        return $this->webService->send($userPhone,$smsBody);
    }

    private function smsFunction($userPhone,$smsBody,$center='SUMS'){

        if(preg_match('#^0#',$userPhone)){
          $userPhone = preg_replace('#^0#','98',$userPhone);
        }
      
        $apiKey = "HiCv5RMtEoiDmaHpD_EVdx-grJ0bim_5xGPV3osyj-Y=";

        $client = new \IPPanel\Client($apiKey);

        $messageId = $client->send(
            "10004223",          
            [$userPhone],    
            $smsBody,
            "smsFunction"        
        );

        return $messageId;


        if(
            !$this->organazation 
            or !$this->userName
            or !$this->password
            or !$this->senderNumber
            or !$this->apiUrl
        ){
            $this->readDataFromSMSFile($center);
        }
        $url = $this->apiUrl;
        $data = array(
          "organization"=> $this->organazation,
              "username"=> $this->userName,
              "password"=> $this->password,
              "method"=> "send",
              "messages"=> [
                  array(
                      "sender"=> $this->senderNumber,
                      "recipient"=> $userPhone,
                      "body"=> $smsBody,
                      "customerId"=> 1
                  )
              ]
        );
      
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json',
                  'Content-Length: ' . strlen($data_string))
            );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
        
    }

    public function getBalance($center=null) {

        $apiKey = "HiCv5RMtEoiDmaHpD_EVdx-grJ0bim_5xGPV3osyj-Y=";

        $client = new \IPPanel\Client($apiKey);

        $credit = $client->getCredit();

        return $credit;
        
        if(
            !$this->organazation 
            or !$this->userName
            or !$this->password
            or !$this->senderNumber
            or !$this->apiUrl
        ){
            $this->readDataFromSMSFile($center);
        }
        $url = $this->apiUrl;
        $data = array(
            "organization"=> $this->organazation,
            "username"=> $this->userName,
            "password"=> $this->password,
            "method"=> "credit"
        );
      
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json',
                  'Content-Length: ' . strlen($data_string))
            );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;

    }

    
}
