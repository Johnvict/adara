<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        "state_name",
        "state_code",
        "region_id",
    ];
}
