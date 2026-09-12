<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Customers\CustomersController;
use App\Http\Controllers\Customers\InvoiceItemController;

class Invoice extends Model
{
    use HasFactory;
    

    protected $table = 'invoice';

    protected $fillable = [
        'company_id',
        'invoice_no',
        'total',
        'sub_total',
        'type',
        'invoice_date',
        'invoice_due_date',
        'invoice_no',
        'total'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
