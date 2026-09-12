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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->string('name');
            $table->string('authorized_person');
            $table->string('address');
            $table->string('city');
            $table->string('district');
            $table->string('tax_office');
            $table->string('tax_number');
            $table->string('mersis_number');
            $table->string('trade_registry_number');
            $table->string('email')->unique();
            $table->string('phone_number', 20)->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
