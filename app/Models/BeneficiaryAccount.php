<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeneficiaryAccount extends Model
{
    protected $fillable = [
        "beneficiary_id",
        "bank_name",
        "account_number",
        "account_name",
    ];
    public function beneficiary(){
        return $this->belongsTo(Beneficiary::class,'beneficiary_id');
    }
}
