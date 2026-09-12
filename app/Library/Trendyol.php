<?php

namespace App\Library;


use Illuminate\Support\Facades\Http;

class Trendyol
{
    protected $username = 'TNobOnloXMPPZ3SIxr4m';
    protected $password = 'JQvYXclCNd55T8ysIJeu';
    protected $supplierId = 971133;
    
    public function getProductList($page)
    {
        return Http::withBasicAuth($this->username, $this->password)->get('https://api.trendyol.com/sapigw/suppliers/'.$this->supplierId.'/products?size=100&archived=false&page='.$page)->object();
    }

    public function getOrders($status, $size, $page, $order_code = null, $start_date = null, $end_date = null)
    {
        if ($start_date != null){
            $start_date = '&startDate='.$start_date;
        }

        if ($order_code != null){
            $order_code = '&orderNumber='.$order_code;
        }

        return Http::withBasicAuth($this->username, $this->password)->withHeaders([
            'Content-Type' => 'application/json',
            'User-Agent: '.$this->supplierId.' - SelfIntegration'
        ])->get('https://api.trendyol.com/sapigw/suppliers/'.$this->supplierId.'/orders?status='.$status.'&size='.$size.'&page='.$page.$start_date.$order_code)->object();
    }

    public function getArchivedProducList()
    {
        return Http::withBasicAuth($this->username, $this->password)->get('https://api.trendyol.com/sapigw/suppliers/'.$this->supplierId.'/products?archived=true')->object();
    }

    public function updatePriceAndStock($data)
    {
        return Http::withBasicAuth($this->username, $this->password)->post('https://api.trendyol.com/sapigw/suppliers/'.$this->supplierId.'/products/price-and-inventory',$data)->object();
    }
}