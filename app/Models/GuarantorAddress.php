<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GuarantorAddress extends Model
{
    protected $fillable = [
        'beneficiary_id',
        'name',
        'phone_number',
        'home_address',
        'work_address',
        'occupation',
        'file',
    ];
}
