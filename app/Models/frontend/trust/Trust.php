<?php

namespace App\Models\frontend\trust;

use Illuminate\Database\Eloquent\Model;

class Trust extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'currency', 'buy_amount', 'desc', 'author'
    ];
}