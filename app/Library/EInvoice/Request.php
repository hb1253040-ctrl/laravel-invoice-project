<?php
/**
 * Created by PhpStorm.
 * User: malic
 * Date: 10.07.2018
 * Time: 17:51
 */

 namespace App\Library\EInvoice;


class Request
{
    public $hataMesaj;
    public $hataKod;
    public function send($param, $url, $token){
        
        try{
            $ch = curl_init($url);
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data', 'Accept: application/json' ,$authorization)); // Inject the token into the header
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

            $result = curl_exec($ch);

            curl_close($ch);
            return $result;
        }catch (\SoapFault $hata){
            $this->hataKod = $hata->faultcode;
            $this->hataMesaj = $hata->faultstring;
            throw new \Exception("Soap Hata : ".$hata->faultstring);
        }
    }
}