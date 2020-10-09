<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ["name", "price", "expire_date", 'category_id'];

    protected $casts = [
        'expire_date' => 'datetime',
        'produced_at' => 'datetime'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
