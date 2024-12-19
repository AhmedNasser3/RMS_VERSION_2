<?php

namespace App\Models\frontend\currency;

use App\Models\frontend\category\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'currency',
        'amount',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}