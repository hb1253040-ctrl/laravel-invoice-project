<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default(''); // Firma adı
            $table->string('user_name'); // Fatura Sahibi İsmi
            $table->string('user_surname'); // Fatura Sahibi Soyisim
            $table->string('tc_id', 11); // TC Kimlik Numarası
            $table->text('address'); // Firma adresi
            $table->string('city'); // Şehir
            $table->string('district'); // İlçe
            $table->string('country'); // Ülke
            $table->string('email'); // Email
            $table->string('phone_number'); // Telefon numarası
            $table->string('tax_office'); // Vergi dairesi
            $table->string('tax_number'); // Vergi numarası
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
