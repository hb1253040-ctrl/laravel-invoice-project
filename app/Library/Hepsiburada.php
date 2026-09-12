<?php

namespace App\Library;

use Illuminate\Support\Facades\Http;

class Hepsiburada
{

    //private $username = 'voltronx1_dev';
    //private $password = 'kiDsfSHgLmAruy!';

    private $username = '20db7780-9289-4ce9-995a-839c095f1a38';
    private $password = 'BqJWJeMm6mb5';

    public function getProductList()
    {
        return Http::withBasicAuth($this->username, $this->password)->withHeaders(['user-agent' => 'voltronx1_dev'])->get('https://listing-external.hepsiburada.com/listings/merchantid/20db7780-9289-4ce9-995a-839c095f1a38?offset=0&limit=5000')->object();
    }

    public function getOrders($offset, $limit)
    {
        return Http::withBasicAuth($this->username, $this->password)->withHeaders(['user-agent' => 'voltronx1_dev'])->get('https://oms-external.hepsiburada.com/packages/merchantid/20db7780-9289-4ce9-995a-839c095f1a38?offset='.$offset.'&limit='.$limit)->object();
    }

    public function updatePrice($data)
    {
        return Http::withBasicAuth($this->username, $this->password)->withHeaders(['user-agent' => 'voltronx1_dev'])->post('https://listing-external.hepsiburada.com/listings/merchantid/20db7780-9289-4ce9-995a-839c095f1a38/price-uploads',$data)->object();
    }

    public function updateStock($data)
    {
        return Http::withBasicAuth($this->username, $this->password)->withHeaders(['user-agent' => 'voltronx1_dev'])->post('https://listing-external.hepsiburada.com/listings/merchantid/20db7780-9289-4ce9-995a-839c095f1a38/stock-uploads',$data)->object();
    }

    public function checkBatchStatus($data)
    {
        return Http::withBasicAuth($this->username, $this->password)->withHeaders(['user-agent' => 'voltronx1_dev'])->get('https://listing-external.hepsiburada.com/listings/merchantid/20db7780-9289-4ce9-995a-839c095f1a38/inventory-uploads/id', $data)->object();
    }

    public function getBuybox($data)
    {
        return Http::withBasicAuth($this->username, $this->password)->withHeaders(['user-agent' => 'voltronx1_dev'])->get('https://listing-external.hepsiburada.com/buybox-orders/merchantid/20db7780-9289-4ce9-995a-839c095f1a38?skuList='.$data)->object();
    }
}