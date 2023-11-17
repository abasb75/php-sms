<?php

class Fake {

    

    function __construct($config){
        
    }

    public function send($userPhone,$text){
        return rand(123456,987654);
    }

    public function getBalance(){
        return 10000000;
    }

}