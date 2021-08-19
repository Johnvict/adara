<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        "beneficiary_id",
        "date",
        "status",
        "invoice_no",
        "receipt_no",
        "defaulted",
        "date_paid",
    ];
}
