<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationTimeline extends Model
{
    protected $fillable = [
        'title',
        'date',
        'description',
        'sort_order',
    ];
}
