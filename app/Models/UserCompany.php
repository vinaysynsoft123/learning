<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'email',
        'mobile',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'gst_number',
        'pan_number',
        'logo',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
