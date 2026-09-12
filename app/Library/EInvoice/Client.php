<?php
/**
 * Created by PhpStorm.
 * User: malic
 * Date: 10.07.2018
 * Time: 17:49
 */

 namespace App\Library\EInvoice;

use App\Library\EInvoice\Util;
use App\Library\EInvoice\Fatura;
use App\Library\EInvoice\Request;

class Client
{
    private $session_id = null;
    private $hata;

    /**
     * @return mixed
     */
    public function getHata()
    {
        return $this->hata;
    }

    /**
     * @param mixed $hata
     */
    public function setHata($hataKod, $hataMesaj)
    {
        $this->hata = array(
            "KOD" => $hataKod,
            "MESAJ" => $hataMesaj
        );
    }

    public function setURL($url)
    {
        Util::$service_url = $url;
    }

    public function getURL()
    {
        return Util::$service_url;
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return (is_null($this->session_id) ? $_SESSION["EFATURA_SESSION"] : $this->session_id);
    }

    /**
     * @param mixed $session_id
     */
    public function setSessionId($session_id)
    {
        $_SESSION["EFATURA_SESSION"] = $session_id;
        $this->session_id = $session_id;
    }

    public function sendInvoice(Fatura $fatura, $token)
    {
        $readFatura = $fatura->readXML();

        /*ECHO "<PRE>";
        print_r($readFatura);exit;*/
        
        file_put_contents(public_path('xml-files/invoice.xml'), $readFatura);

        $send_data["SenderAlias"] = $fatura->getDuzenleyen()->getGibUrn();
        $send_data["ReceiverAlias"] = $fatura->getAlici()->getGibUrn();
        $send_data['File'] = curl_file_create('xml-files/invoice.xml', 'application/xml', 'fatura.xml');
        $send_data['IsDirectSend'] = 'true';
        $send_data['PreviewType'] = 'None';
        $send_data['SourceApp'] = 'voltron';
        $send_data['SourceAppRecordId'] = 'voltronx';

        /*echo "<pre>";
        print_r($send_data);exit;*/

        $req = new Request();
        $sonuc = $req->send($send_data,$this->getURL(),$token);
        //$this->setHata($req->hataKod, $req->hataMesaj);
        return json_decode($sonuc);
    }

}