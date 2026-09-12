<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\InvoiceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Products;
use App\Models\Company;
use Carbon\Carbon;
use App\Library\EInvoice;
use App\Library\EInvoice\Fatura;
use App\Library\EInvoice\Client;
use App\Library\EInvoice\Satir;
use App\Library\EInvoice\Vergi;
use App\Library\EInvoice\Cari;
use App\Library\EInvoice\Urun;
use App\Library\EInvoice\Util;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        //-- Firma arama Ajax --//
        if ($request->ajax()) {
            $company = Company::where('name', $request->input('company_name'))->first();
            
            if ($company) {
                return response()->json($company);
            }
        }
        //-- Firma arama Ajax --//

        $company = Company::all(); // Tüm firmaları getiriyoruz
        $invoiceNo = $this->generateInvoiceNumber(); // Fatura numarasını oluşturuyoruz
        
        return view('customer.invoice.create', compact('company', 'invoiceNo'))->with('info', 'Bu bir bilgi mesajıdır.');;
    }

    public function create(InvoiceRequest $request)
    {
        $data = $request->validated();
        // Tarihleri formatla
        $invoiceDate = Carbon::createFromFormat('d, M Y', $data['invoice_date'])->format('Y-m-d');
        $invoiceDueDate = Carbon::createFromFormat('d, M Y', $data['invoice_due_date'])->format('Y-m-d');

        $quantities_invoce = $data['quantity'] ?? [];
        $prices_invoce = $data['price'] ?? [];
        $taxs_rates = $data['tax_rate'] ?? [];

        $invoiceTotal = 0;
        $subTotal = 0;
        $totalTaxAmount = 0; // KDV toplamını başlat

        // Ürün Hesaplama
        for ($i = 0; $i < count($quantities_invoce); $i++) {
            $invoiceTotal += $quantities_invoce[$i] * $prices_invoce[$i]; 
            $subTotal += $prices_invoce[$i];
            
            // KDV oranını düzelt ve KDV hesapla
            $taxRate = (float) $taxs_rates[$i] / 100;
            $totalTaxAmount += $quantities_invoce[$i] * $prices_invoce[$i] * $taxRate;
        }
        
        // Son toplam
        $invoiceTotalTaxRate = $invoiceTotal + $totalTaxAmount;
        
        
        
        // Şirketi al veya oluştur
        if ($data['invoice_type'] !== 'individual') {
            $company = Company::where('name', $data['company_name'])->first();
        }
       

        if ($data['invoice_type'] == 'business' && !$company) {
            $company = Company::create([
                'name' => $data['company_name'],
                'address' => $data['address'],
                'user_name' => $data['user_name'],
                'user_surname' => $data['user_surname'],
                'tc_id' => $data['tc_id'],
                'city' => $data['city'],
                'district' => $data['district'],
                'country' => $data['country'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'tax_office' => $data['tax_office'],
                'tax_number' => $data['tax_number']
            ]);
        } else {
            $company = Company::create([
                'address' => $data['address'],
                'user_name' => $data['user_name'],
                'tc_id' => $data['tc_id'],
                'user_surname' => $data['user_surname'],
                'city' => $data['city'],
                'district' => $data['district'],
                'country' => $data['country'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'tax_office' => $data['tax_office'],
                'tax_number' => $data['tax_number']
            ]);
        }

        // Fatura oluştur
        $invoice = Invoice::create([
            'company_id' => $company->id, // company_id'yi burada ekliyoruz
            'invoice_no' => $data['invoice_no'],
            'type' => $data['invoice_type'],
            'total' => $invoiceTotalTaxRate, // Düzeltilmiş total değeri
            'sub_total' => $subTotal,
            'invoice_date' => $invoiceDate,
            'invoice_due_date' => $invoiceDueDate
        ]);

        // Ürünleri al
        $names = $data['name'] ?? [];
        $quantities = $data['quantity'] ?? [];
        $prices = $data['price'] ?? [];
        $tax_rates = $data['tax_rate'] ?? [];

        // Geçerli verileri eşleştir
        $items = array_filter(array_map(null, $names, $quantities, $prices,$tax_rates), function($item) {
            return !in_array(null, $item, true);
        });

        foreach ($items as $item) {
            list($name, $quantity, $price, $tax_rate) = $item;

            // Ürün adı ile `products` tablosundan ürün bilgilerini al
            $product = Products::where('name', $name)->first();
            
            // Fiyatı işleme al
            if (!$product) {
                // Ürün bulunamadı, ekle
                $product = Products::create([
                    'name' => $name,
                    'price' => $price, // Düzeltilmiş fiyat değeri
                ]);
            }


            if ($product) {
                // Toplamı hesapla
                $total = $quantity * $price; // Düzeltilmiş fiyat değeri kullanılarak toplam hesaplanır

                // KDV miktarını hesapla (total * KDV oranı)
                $taxAmount = ($total * $tax_rate) / 100 ; 

                // KDV dahil toplamı hesapla
                $totalWithTax = $total + $taxAmount; 

                // InvoiceItem tablosuna kayıt ekle
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id, // Ürün ID'si burada kullanılır
                    'product_name' => $name, // Ürün adını kaydet
                    'quantity' => $quantity,
                    'tax_rate' => $tax_rate, // KDV oranını kaydet
                    'tax_amount' => $taxAmount, // KDV tutarını kaydet
                    'unit_price' => $price, // Düzeltilmiş fiyat değeri
                    'total' => $totalWithTax, // Hesaplanan toplam
                ]);
            }
        }

        return redirect()->route('invoice.create')->with('success', 'Fatura başarıyla eklendi.')
                                                ->with('error','Fatura Eklenemedi');
                                                
    }

    public function get_invoice(Request $request, $user_id) 
    {
        return response()->json([
            'status' => true,
            'message' => "Bilgiler Getirildi",
            'data' => InvoiceItem::find(3)
        ]);
    }

    private function generateInvoiceNumber()
    {
        return str_pad(rand(1, 9999999), 7, '0', STR_PAD_LEFT);
    }

}