<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $fillable = ['name', 'full_name', 'symbol', 'price'];

}