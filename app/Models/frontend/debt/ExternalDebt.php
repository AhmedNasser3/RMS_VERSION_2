<?php

namespace App\Models\frontend\debt;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ExternalDebt extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'recipient',
        'reason',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}