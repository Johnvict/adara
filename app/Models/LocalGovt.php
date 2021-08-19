<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalGovt extends Model
{
    protected $fillable = [
        "lga",
        "lga_code",
        "state_id",
    ];
}
