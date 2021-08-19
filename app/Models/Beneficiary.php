<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Beneficiary extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        "name",
        "email",
        "gender",
        "phone_number",
        "dob",
        "profile_pic",
        "onboarding_date",
    ];

    public function getProfilePicAttribute($value)
    {
        return ($value) ? URL::to('/images/' . $value) : $value;
    }

    public function guarantors()
    {
        return $this->hasMany(Guarantor::class, 'beneficiary_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany(BeneficiaryAddress::class, 'beneficiary_id', 'id');
    }

    public function account()
    {
        return $this->hasOne(BeneficiaryAccount::class);
    }
}
