<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $fillable = [
        'user_id',
        'referral_code',
        'commission_type',
        'commission_rate',
        'total_clicks',
        'bank_name',
        'account_number',
        'account_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
}
