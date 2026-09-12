<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\EInvoice;
use App\Library\EInvoice\Fatura;
use App\Library\EInvoice\Client;
use App\Library\EInvoice\Satir;
use App\Library\EInvoice\Vergi;
use App\Library\EInvoice\Cari;
use App\Library\EInvoice\Urun;
use App\Library\EInvoice\Util;
use App\Models\Invoice;

class OrderController extends Controller
{
    public function sendInvoice(Request $request)
    {
        $token = 'A88AB43704A51808862A849C053D4C88533FFD23B291D01FA2400F8A2B9CB5C4';
        //dd($request->get('company_name'));

        $client = new Client();

        //$companyIds = $request->get('company_id',[]);

        /*foreach($request->all() as $value)
        {*/

            //$order = Invoice::find($);

            //Fatura Oluşturuluyor
            $invoice = new Fatura();

            $gbmail = "";
            $company_name = $request->company_name;
            dd($company_name);
            /*$vergi_no = $siparis['vergi_no'];
            $tc = $siparis['tc'];
            $vergi_dairesi = "";
            $firma_adi = $siparis['fatura_adi'];

            if ($tc == '') $tc = "11111111111";*/

            //echo $siparis['fatura_turu'];exit;
            //if ($request->type == 'business'){ // kurumsal fatura mı?

                $check_user = EInvoice::checkUser('https://api.nes.com.tr/einvoice/v1/users/'.$request->tax_number.'/pk',$token);
                //$vergi_dairesi = $siparis['vergi_dairesi'];

                if ($check_user){
                    foreach ($check_user->aliases as $user){
                        $gbmail = $user->alias;
                        $company_name = $check_user->title;
                    }

                    $invoice->setProfileId("TICARIFATURA");
                    $client->setURL("https://api.nes.com.tr/einvoice/v1/uploads/document");
                    $invoice_type = 'TICARIFATURA';
                }else{
                    $invoice->setProfileId("EARSIVFATURA");
                    $client->setURL("https://api.nes.com.tr/earchive/v1/uploads/document");
                }
            /*}else {
                $invoice->setProfileId("EARSIVFATURA");
                $client->setURL("https://api.nes.com.tr/earchive/v1/uploads/document");
            }*/

            //$fatura->setProfileId("TICARIFATURA");

            //$fatura->setProfileId("EARSIVFATURA");
            //$gbmail = "urn:mail:defaultpk@nes.com.tr";

            if ($invoice->getProfileId() == 'TICARIFATURA'){
                $invoice->setId("SKR");
            }else{
                $invoice->setId("TAK");
            }
            $invoice->setUuid(Util::GUID());
            //$invoice->setIssueDate(Util::issueDate());
            $invoice->setIssueDate('2024-10-31');
            $invoice->setIssueTime('16:50:00');
            //$invoice->setIssueTime(Util::issueTime());
            $invoice->setDocumentCurrencyCode("TRY");

            //EFatura Gönderici Bilgileri Set Edildi.
            $sender = new Cari();
            $sender->setTip("GERCEKKISI"); // TUZELKISI - GERCEKKISI
            $sender->setAdres("ATAKÖY 7-8-9-10. KISIM MAH. ÇOBANÇEŞME E-5 YAN YOL CAD. NO: 12 /2 İÇ KAPI NO: 59");
            $sender->setIl("İSTANBUL");
            $sender->setIlce("BAKIRKÖY");
            $sender->setUlkeAd("TÜRKİYE");
            $sender->setVergiDaire("BAKIRKÖY VERGİ DAİRESİ");
            $sender->setTckn("50152472804");
            $sender->setAd("HASAN");
            $sender->setSoyad("AKGÜN");
            //$duzenleyen->setVkn("1234567801"); //TEST
            //$sender->setTelefon("0212 558 5840");
            $sender->setEposta("info@sakurataki.com.tr");
            $sender->setWebsite("www.sakurataki.com.tr");
            $sender->setGibUrn("urn:mail:defaultgb@sakurataki.com.tr");
            //$duzenleyen->setGibUrn("urn:mail:defaultgb@nes.com.tr"); //TEST
            $invoice->setDuzenleyen($sender);

            //EFatura Alıcı Carisi Oluşturulup Faturaya Eklendi
            $buyer  =  new Cari();
            $buyer->setUnvan($company_name);

            $buyer->setAdres(clear_special_characters($request->address));
            $buyer->setIl($request->invoice->city);
            $buyer->setIlce($request->district);
            $buyer->setUlkeKod("TR");
            $buyer->setUlkeAd("TÜRKİYE");

            $cn = explode(' ',$company_name);
            $last_name = end($cn);
            $first_name = str_replace($last_name,'',$company_name);

            $buyer->setVergiDaire($request->tax_office);
            
            if (strlen($request->tax_number) == 10){
                $buyer->setVkn($request->tax_number);
            }else if (strlen($request->tax_number) == 11){
                $buyer->setTckn($request->tax_number);
                $buyer->setTip('GERCEKKISI');
                $buyer->setAd($first_name);
                $buyer->setSoyad($last_name);
            }
            //$alici->setVkn('1234567802');
            $buyer->setTelefon($request->phone);
            $buyer->setEposta($request->email);
            $buyer->setGibUrn($gbmail);
            //$alici->setGibUrn('urn:mail:defaultpk@edmbilisim.com.tr');
            $invoice->setAlici($buyer);

            //Fatura Satırları Oluşturuluyor
            /*1.SATIR*/
            $count = 0;
            $vat_0_base = 0;
            $vat_1_base = 0;
            $vat_10_base = 0;
            $vat_20_base = 0;
            $vat_0 = 0;
            $vat_1 = 0;
            $vat_10 = 0;
            $vat_20 = 0;
            $tax_line_total = 0;   
            
            $invoice->setLineCountNumeric(count($order->products));

            foreach ($order->products as $p){
                $count++;
                $qty = $p->pivot->quantity;
                $product_name = $p->name;
                $price = $p->pivot->price;
                 

                if ($p->tax_rate == 0 || $order->is_micro == 1){
                    $tax_amount = 0;
                    $tax_base = $p->pivot->price * $p->pivot->quantity;
                    $tax_line_total += $tax_base * $p->pivot->quantity;

                    $vat_0_base += $tax_base;
                    $vat_0 += $tax_amount;
                }else{
                    $tax_base = round($p->pivot->price/((100+$p->tax_rate)/100),2);
                    $tax_amount = round($p->pivot->price - $tax_base,2);
                    $tax_line_total += $tax_base * $p->pivot->quantity;

                    if ($p->tax_rate == 1){
                        $vat_1_base += $tax_base * $p->pivot->quantity;
                        $vat_1 += $tax_amount * $p->pivot->quantity;
                    }else if ($p->tax_rate == 8){
                        $vat_10_base += $tax_base * $p->pivot->quantity;
                        $vat_10 += $tax_amount * $p->pivot->quantity;
                    }else if ($p->tax_rate == 20){
                        $vat_20_base += $tax_base * $p->pivot->quantity;
                        $vat_20 += $tax_amount * $p->pivot->quantity;
                    }
                }

                $line = new Satir();
                $line->setSiraNo($count);
                $line->setBirim("C62");
                $line->setMiktar($p->pivot->quantity);
                $line->setBirimFiyat($tax_base);
                $line->setSatirToplam($tax_base * $p->pivot->quantity);

                $tax_line = new Vergi();
                $tax_line->setSiraNo(1);
                $tax_line->setVergiHaricTutar($tax_base * $p->pivot->quantity);
                $tax_line->setVergiTutar($tax_amount * $p->pivot->quantity);
                $tax_line->setParaBirimKod("TRY");
                $tax_line->setVergiOran($p->tax_rate);
                $tax_line->setVergiKod("0015");
                $tax_line->setVergiAd("KDV");
                $line->setVergi($tax_line);

                $service = new Urun();
                $service->setAd(clear_special_characters($p->name));
                $line->setUrun($service);
                $invoice->addSatir($line);
            }

            if ($vat_0_base > 0){
                $invoice->setInvoiceTypeCode("ISTISNA"); //SATIS - IADE - ISTISNA
            }else{
                $invoice->setInvoiceTypeCode("SATIS"); //SATIS - IADE - ISTISNA
            }

            if ($order->shipping_fee > 0){
                $count++;
                $base_amount = round($order->shipping_fee/1.20,2);
                $vat_amount = round($order->shipping_fee - $base_amount,2);
                $tax_line_total += $base_amount;
                $vat_20 += $vat_amount;
                $vat_20_base += $base_amount;

                $line = new Satir();
                $line->setSiraNo($count);
                $line->setBirim("C62");
                $line->setMiktar(1);
                $line->setBirimFiyat($base_amount);
                $line->setSatirToplam($base_amount);

                $tax_line = new Vergi();
                $tax_line->setSiraNo(1);
                $tax_line->setVergiHaricTutar($base_amount);
                $tax_line->setVergiTutar($vat_amount);
                $tax_line->setParaBirimKod("TRY");
                $tax_line->setVergiOran(20);
                $tax_line->setVergiKod("0015");
                $tax_line->setVergiAd("KDV");
                $line->setVergi($tax_line);

                $service = new Urun();
                $service->setSerbestAciklama('');
                $service->setAd('Kargo Taşıma Ücreti');
                $line->setUrun($service);
                $invoice->addSatir($line);
            }

            if ($order->maturity > 0){
                $base_amount = round($order->maturity/1.20,2);
                $vat_amount = round($order->maturity - $base_amount,2);
                $tax_line_total += $base_amount;
                $vat_20 += $vat_amount;
                $vat_20_base += $base_amount;

                $line = new Satir();
                $line->setSiraNo($count);
                $line->setBirim("C62");
                $line->setMiktar(1);
                $line->setBirimFiyat($base_amount);
                $line->setSatirToplam($base_amount);

                $tax_line = new Vergi();
                $tax_line->setSiraNo(1);
                $tax_line->setVergiHaricTutar($base_amount);
                $tax_line->setVergiTutar($vat_amount);
                $tax_line->setParaBirimKod("TRY");
                $tax_line->setVergiOran(20);
                $tax_line->setVergiKod("0015");
                $tax_line->setVergiAd("KDV");
                $line->setVergi($tax_line);

                $service = new Urun();
                $service->setSerbestAciklama('');
                $service->setAd('Vade Farkı');
                $line->setUrun($service);
                $invoice->addSatir($line);
            }

            $vat_rates = [
                [
                    "base" => $vat_0_base,
                    "vat" => $vat_0,
                    "rate" => "0"
                ],[
                    "base" => $vat_1_base,
                    "vat" => $vat_1,
                    "rate" => "1"
                ],[
                    "base" => $vat_10_base,
                    "vat" => $vat_10,
                    "rate" => "10"
                ],[
                    "base" => $vat_20_base,
                    "vat" => $vat_20,
                    "rate" => "20"
                ]
            ];

            $total = round($order->total_amount + $order->shipping_fee + $order->maturity,2);

            //Fatura Altı KDV ekleniyor
            $count = 0;
            foreach ($vat_rates as $k) {
                if ($k['base'] > 0) {
                    $count++;
                    $invoice_tax = new Vergi();
                    $invoice_tax->setSiraNo($count);
                    $invoice_tax->setVergiHaricTutar($k['base']);
                    $invoice_tax->setVergiTutar($k['vat']);
                    $invoice_tax->setParaBirimKod("TRY");
                    $invoice_tax->setVergiOran($k['rate']);
                    $invoice_tax->setVergiKod("0015");
                    $invoice_tax->setVergiAd("KDV");
                    $invoice->setVergi($invoice_tax);
                }
            }

            //Faturaya Dip Toplamlar Ekleniyor
            $invoice->setSatirToplam($tax_line_total);
            $invoice->setVergiDahilToplam($total);
            $invoice->setToplamIskonto(0);
            $invoice->setYuvarlamaTutar(0);
            $invoice->setOdenecekTutar($total);

            if ($order->point > 0){
                $invoice->setNote( "Not: Bu faturanın ".$order->point." kısmı para puan olarak ödenmiştir.");
            }

            $invoice->setNote("Pazaryeri: ".$order->mp->name." - Sipariş Kodu: ". $order->id);

            //dd($invoice);
            $req = $client->sendInvoice($invoice, $token);
            
            // sonuç

            /*
            stdClass Object
            (
                [uuid] => 52a9c586-f118-41fe-bb18-9a7a45ad4472
                [documentNumber] => VLT2024000000744
                [preview] => 
            )*/

            if (isset($req->uuid)){
                Invoice::where('id', $order->id)->update(['uuid' => $req->uuid,'invoice_no' => $req->documentNumber]);

                $uuids[] = $req->uuid;
            }else{
                echo json_encode($req)." - ".$order->id."<br>";
            }
            /*echo "<pre>";
            print_r($sonuc);*/
        //}

        return redirect()->back()->with(['status' => 'success', 'message' => 'Faturalar başarıyla gönderildi.']); 
    }
}
