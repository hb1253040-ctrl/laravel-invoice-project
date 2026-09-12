<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class InvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Kullanıcıların bu isteği yapmalarına izin ver
    }

    public function rules()
    {
        return [
            'company_name' => 'required_if:invoice_type,business|string|max:255', // Firma Adı zorunlu
            'invoice_type' => 'required|string|max:255', // Fatura türü kontrolü
            'address' => 'required|string|max:255', // Adres zorunlu
            'city' => 'required|string|max:255', // Şehir zorunlu
            'country' => 'required|string|max:255', // Ülke zorunlu
            'district' => 'required|string|max:255', // İlçe zorunlu
            'email' => 'required|email|max:255', // Email zorunlu
            'tc_id' => 'required|digits:11', // Hem bireysel hem kurumsal için TC Kimlik Numarası zorunlu ve 11 haneli
            'user_name' => 'required|string|max:255', // İsim zorunlu
            'user_surname' => 'required|string|max:255', // Soyisim zorunlu
            'phone_number' => 'required|string|max:20', // Telefon Numarası zorunlu
            'tax_rate.*' => 'nullable|numeric|in:1,10,20', // Kabul edilen KDV oranları
            'tax_office' => 'required|string|max:255', // Vergi Dairesi zorunlu
            'tax_number' => 'required|string|max:255', // Vergi Numarası zorunlu
            'invoice_no' => 'required|string|size:7', // Fatura Numarası zorunlu
            'name' => 'required|array|min:1', // Ürün Adı zorunlu
            'name.*' => 'required|string|max:255',
            'quantity' => 'required|array|min:1', // Ürün Adeti zorunlu
            'quantity.*' => 'required|integer|min:1',
            'price' => 'required|array|min:1', // Ürün Fiyatı zorunlu
            'price.*' => ['required',
                function ($attribute, $value, $fail) {
                    // Virgülleri noktaya çevir
                    $value = str_replace(',', '.', $value);

                    // Fazla noktaları kaldır (binlik ayırıcıları)
                    $value = preg_replace('/(?<=\d)\.(?=\d{3})/', '', $value);

                    // Sayı olup olmadığını kontrol et
                    if (!is_numeric($value)) {
                        $fail($attribute.' geçerli bir sayı olmalıdır.');
                    }

                    // Sayının sıfırdan küçük olup olmadığını kontrol et
                    if ($value < 0) {
                        $fail($attribute.' sıfırdan küçük olamaz.');
                    }
                },
            ],
            'invoice_date' => ['required', function($attribute, $value, $fail) {
                try {
                    Carbon::createFromFormat('d, M Y', $value);
                } catch (\Exception $e) {
                    $fail('Fatura tarihi geçerli bir tarih formatında olmalıdır.');
                }
            }],
            'invoice_due_date' => ['required', function($attribute, $value, $fail) {
                try {
                    Carbon::createFromFormat('d, M Y', $value);
                } catch (\Exception $e) {
                    $fail('Vade tarihi geçerli bir tarih formatında olmalıdır.');
                }
            }],
        ];
    }

    public function messages()
    {
        return [
            'invoice_type.required' => 'Lütfen fatura türünü seçiniz.',
            'invoice_type.in' => 'Fatura türü yalnızca bireysel veya kurumsal olabilir.',
            'company_name.required_if' => 'Kurumsal faturalar için firma adı zorunludur.',
            'address.required' => 'Adres alanı gereklidir.',
            'address.string' => 'Adres geçerli bir metin olmalıdır.',
            'address.max' => 'Adres en fazla 255 karakter uzunluğunda olabilir.',
            'city.required' => 'Şehir alanı gereklidir.',
            'city.string' => 'Şehir geçerli bir metin olmalıdır.',
            'city.max' => 'Şehir en fazla 255 karakter uzunluğunda olabilir.',
            'country.required' => 'Ülke alanı gereklidir.',
            'country.string' => 'Ülke geçerli bir metin olmalıdır.',
            'country.max' => 'Ülke en fazla 255 karakter uzunluğunda olabilir.',
            'tc_id.required' => 'TC kimlik numarası zorunludur.',
            'tc_id.digits' => 'TC kimlik numarası 11 haneli olmalıdır.',
            'district.required' => 'İlçe alanı gereklidir.',
            'district.string' => 'İlçe geçerli bir metin olmalıdır.',
            'district.max' => 'İlçe en fazla 255 karakter uzunluğunda olabilir.',
            'email.required' => 'E-posta alanı gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi girilmelidir.',
            'email.max' => 'E-posta en fazla 255 karakter uzunluğunda olabilir.',
            'phone_number.required' => 'Telefon numarası alanı gereklidir.',
            'phone_number.string' => 'Telefon numarası geçerli bir metin olmalıdır.',
            'phone_number.max' => 'Telefon numarası en fazla 20 karakter uzunluğunda olabilir.',
            'tax_office.required' => 'Vergi dairesi alanı gereklidir.',
            'tax_office.string' => 'Vergi dairesi geçerli bir metin olmalıdır.',
            'tax_office.max' => 'Vergi dairesi en fazla 255 karakter uzunluğunda olabilir.',
            'tax_number.required' => 'Vergi numarası alanı gereklidir.',
            'tax_number.string' => 'Vergi numarası geçerli bir metin olmalıdır.',
            'tax_number.max' => 'Vergi numarası en fazla 255 karakter uzunluğunda olabilir.',
            'invoice_no.required' => 'Fatura numarası alanı gereklidir.',
            'invoice_no.size' => 'Fatura numarası 7 karakter uzunluğunda olmalıdır.',
            'name.*.required' => 'Ürün adı gereklidir.',
            'name.*.string' => 'Ürün adı geçerli bir metin olmalıdır.',
            'name.*.max' => 'Ürün adı en fazla 255 karakter uzunluğunda olabilir.',
            'quantity.*.required' => 'Ürün miktarı gereklidir.',
            'quantity.*.integer' => 'Ürün miktarı geçerli bir tam sayı olmalıdır.',
            'quantity.*.min' => 'Ürün miktarı en az 1 olmalıdır.',
            'price.*.required' => 'Ürün fiyatı gereklidir.',
            'price.*.numeric' => 'Ürün fiyatı geçerli bir sayı olmalıdır.',
            'price.*.min' => 'Ürün fiyatı en az 0 olmalıdır.',
            'invoice_date.required' => 'Fatura tarihi alanı gereklidir.',
            'invoice_date.date' => 'Geçerli bir tarih formatı girilmelidir.',
            'invoice_due_date.required' => 'Vade tarihi alanı gereklidir.',
            'invoice_due_date.date' => 'Geçerli bir tarih formatı girilmelidir.',
        ];
    }

    protected function prepareForValidation()
    {
        // 'price' alanının bir dizi olup olmadığını kontrol edin, değilse boş bir dizi kullanın
        $prices = is_array($this->input('price')) ? $this->input('price') : [];

        $this->merge([
            'price' => array_map(function ($price) {
                // Virgülleri noktaya çevir
                $price = str_replace(',', '.', $price);

                // Binlik ayırıcı noktaları kaldır
                $price = preg_replace('/(?<=\d)\.(?=\d{3})/', '', $price);

                return $price;
            }, $prices),

            'invoice_total' => str_replace(',', '.', $this->input('invoice_total'))
        ]);

        $this->merge([
            'name' => is_array($this->input('name')) ? array_filter($this->input('name')) : [],
            'quantity' => is_array($this->input('quantity')) ? array_filter($this->input('quantity')) : [],
            'price' => is_array($this->input('price')) ? array_filter($this->input('price')) : [],
        ]);
        
    }


}
