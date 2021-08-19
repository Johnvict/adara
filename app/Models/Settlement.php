<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $fillable = [
        "transaction_ref",
        "amount",
        "status",
        "api_payload",
    ];
}
