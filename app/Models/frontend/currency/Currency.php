<?php

namespace App\Models\frontend\currency;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\frontend\category\Category;
use App\Models\frontend\transaction\Transaction;

class Currency extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'currency',
        'amount',
        'MRU',
        'recipient_amount',
        'recipient_currency',
        'bank_recipient_amount',
        'bank_amount',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function transactions()
{
    return $this->hasMany(Transaction::class);
}

}