<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ["name", "price", "expire_date"];

    protected $casts = [
        'expire_date' => 'datetime',
        'produced_at' => 'datetime'
    ];

}
