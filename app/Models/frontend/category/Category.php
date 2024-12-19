<?php

namespace App\Models\frontend\category;

use App\Models\frontend\currency\Currency;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function currency(){
        return $this->hasMany(Currency::class);
    }
}