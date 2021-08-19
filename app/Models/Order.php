<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "product_id",
        "date",
        "total_amount",
        "repayment_duration",
        "repayment_start_date",
        "payment_completed",
        "outstanding_amount",
        "payment_plan",
    ];
}
