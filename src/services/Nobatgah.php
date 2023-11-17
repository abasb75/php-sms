<?php 

/**
 * document link : http://sms.nobatgah.ir/documentation
*/

class Nobatgah {
    private $connect;
    private $apiKey;
    private $phoneNumber;

    private $baseLink = "http://smsapi.nobatgah.ir/v1/";

    function __construct($config){
        $this->apiKey = $config["apiKey"];
        $this->phoneNumber = $config["phoneNumber"];;
    }

    public function send($userPhone,$text){
        $link = $this->baseLink . $this->apiKey . '/sms/send.json';
        $data = array(
            "gateway"=>$this->phoneNumber,
            "to"=>$userPhone,
            "text"=>$text,
        );
        $data_string = json_encode($data);
        $ch = curl_init($link);
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
        try{
            $json_data = json_decode($result,true);
            return $json_data['batch_id'];
        }catch(Exception $e){
            return null;
        }

    }

    public function getBalance(){
        $link = $this->baseLink . $this->apiKey . '/account/balance.json';
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;exit;
        try{
            $json_data = json_decode($result,true);
            return $json_data['entry']['balance'];
        }catch(Exception $e) {
            return 0;
        }
        
    }


}