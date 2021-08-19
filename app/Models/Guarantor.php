<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Guarantor extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'beneficiary_id',
        'name',
        'phone_number',
        'home_address',
        'work_address',
        'occupation',
        'file',
    ];

    public function getProfilePicAttribute($value)
    {
        return ($value) ? URL::to('/images/profile_pics/' . $value) : $value;
    }

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficiary_id', 'id');
    }
    public function address()
    {
        return $this->hasMany(GuarantorsAddress::class);
    }
}
