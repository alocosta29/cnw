<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
#App::uses('NameModel', 'PluginName.Model');
class CryptComponent extends Component{
    

 
    
 public function run($string, $action = true) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'CNWSuccess';
    $secret_iv = '2017';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if($action and !empty($string)) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    elseif(!$action and !empty($string)){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
    
    
}