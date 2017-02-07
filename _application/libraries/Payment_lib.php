<?php

/**
 * Description of Payment_lib => libraries untuk memanggil api payment
 *
 * @author el-fatih
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Payment_lib {
    var $CI;

    function __construct() {
        $this->CI =& get_instance();
    }
    
    function payment_registration($params = array()){

        $url = "http://greentravellink.apiswitcher.com/api/registrasi";
        //$url = "http://greentravellink.apiswitcher.com/api/beta_registrasi";

        $params['api_key'] = 'g6td4nnbdk8n2vg3';

        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POST, 1);

        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($params));

        curl_setopt($curlHandle, CURLOPT_HEADER, 0);

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($curlHandle);

        curl_close($curlHandle);

        $sXML = simplexml_load_string($response);

        return $sXML;

    }

    function get_ip_addres(){
        $url = 'http://greentravellink.apiswitcher.com/api/ipaddress';        
        $params['request_ip_address'] = TRUE;

        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POST, 1);

        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($params));

        curl_setopt($curlHandle, CURLOPT_HEADER, 0);

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($curlHandle);
        
        curl_close($curlHandle);

        $sXML = simplexml_load_string($response);

        $ipaddress =  $sXML->res_data->ip_address;

        return 'IP ADDRESS ANDA : '.$ipaddress;        
    }

    function deposit_payment($params) {

        $url = 'http://greentravellink.apiswitcher.com/api/deposit';
        
        $params['api_key'] = 'g6td4nnbdk8n2vg3';        
        
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POST, 1);

        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($params));

        curl_setopt($curlHandle, CURLOPT_HEADER, 0);

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($curlHandle);
        curl_close($curlHandle);

        $sXML = simplexml_load_string($response);

        return $sXML;

    }
}
