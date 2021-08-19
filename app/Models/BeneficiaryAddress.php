<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeneficiaryAddress extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        "benefiaciary_id",
        "address",
        "local_government",
        "type",
        'local_govt_id',
        'state_id'
    ];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id', 'id');
    }
}
