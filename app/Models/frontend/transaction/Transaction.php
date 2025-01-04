<?php

namespace App\Models\frontend\transaction;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\frontend\currency\Currency;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'currency_id',
        'from_currency',
        'to_currency',
        'amount_from',
        'amount_to',
        'conversion_rate',
        'transaction_date',
    ];

    /**
     * علاقة مع المستخدم.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة مع العملة.
     */
    public function currency()
    {
        return $this->belongsTo( Currency::class);
    }
}