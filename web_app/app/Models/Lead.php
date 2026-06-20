<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'affiliate_id',
        'name',
        'school_name',
        'phone_number',
        'status',
        'deal_value',
        'heard_from',
        'package',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
}
