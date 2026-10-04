# Laravel Fatura Yönetim Sistemi

Laravel ile geliştirdiğim müşteri paneli ve fatura yönetim uygulaması.

## Özellikler
- Kullanıcı girişi ve çıkışı
- Dashboard
- Fatura oluşturma
- Fatura listeleme (billing sayfası)
- Ayarlar sayfası

## Kullanılan Teknolojiler
- PHP / Laravel
- MySQL *(kullandığını yaz)*
- Docker
- Blade

## Kurulum
1. `git clone https://github.com/hb1253040-ctrl/laravel-invoice-project.git`
2. `cd laravel-invoice-project`
3. `composer install`
4. `.env.example` dosyasını `.env` olarak kopyala, veritabanı bilgilerini doldur
5. `php artisan key:generate`
6. `php artisan migrate`
7. `php artisan serve`

## Yapılacaklar
- Kayıt olma sayfası
- Parola sıfırlama
- Fatura PDF çıktısı

## Geliştirici
Hüseyin Bayrak, [GitHub](https://github.com/hb1253040-ctrl)
