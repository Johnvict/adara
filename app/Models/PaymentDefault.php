<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDefault extends Model
{
    protected $fillable = [
        "payment_id",
        "defaulted_num",
    ];
}
