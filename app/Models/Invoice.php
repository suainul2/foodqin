<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];
    const STATUS_SEARCH_DRIVER = 1;
    const STATUS_PROCESS = 2;
    const STATUS_DELIVERY = 3;
    const STATUS_FINISH = 4;
    const STATUS_CANCEL = 5;

    function details() {
        return $this->hasMany(InvoiceDetail::class,"invoice_id");
    }
}
