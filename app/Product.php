<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ["name", "price", "expire_time"];

    protected $casts = [
        'expire_time' => 'datetime',
        'produced_at' => 'datetime'
    ];

}
