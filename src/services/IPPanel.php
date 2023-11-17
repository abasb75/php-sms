<?php

class IPPanel {
    private $connect;
    private $apiKey;
    private $phoneNumber;

    function __construct($config){
        $this->connect = $config[""];
        $this->apiKey = $config["apiKey"];
        $this->apiKey = $config["phoneNumber"];
    }
    
    public function send($userPhone,$text){

        if(preg_match('#^0#',$userPhone)){
            $userPhone = preg_replace('#^0#','98',$userPhone);
        }
        $client = new \IPPanel\Client($this->apiKey);
        $messageId = $client->send(
              $this->phoneNumber,          
              [$userPhone],    
              $text,
              "smsFunction"        
        );
        return $messageId;

    }

    public function getBalance(){
        $client = new \IPPanel\Client($this->apiKey);
        $credit = $client->getCredit();
        return $credit;
    }
}