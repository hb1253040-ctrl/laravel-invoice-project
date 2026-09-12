<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';

    protected $fillable = [
        'name',
        'user_name',
        'user_surname',
        'address',
        'tc_id',
        'city',
        'district',
        'country',
        'email',
        'phone_number',
        'tax_office',
        'tax_number',
    ];    

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
}


