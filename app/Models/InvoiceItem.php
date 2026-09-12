<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Customers\InvoiceController;
use App\Http\Controllers\Customers\ProductsController;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'product_name',
        'quantity',
        'tax_rate',
        'tax_amount',
        'unit_price',
        'total'

    ];

    public function invoice()
    {
        return $this->belongsTo(InvoiceController::class);
    }

    public function product()
    {
        return $this->belongsTo(ProductsController::class);
    }
}
