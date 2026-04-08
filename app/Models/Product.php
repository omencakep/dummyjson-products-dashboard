<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'api_id',
        'title',
        'price',
        'category_id',
        'brand',
        'rating',
        'stock',
        'discount',
        'last_synced_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
