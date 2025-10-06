<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'status',
        'show_on_home',
        'sort_order',
        'meta_data'
    ];

    protected $casts = [
        'status' => 'string',
        'show_on_home' => 'boolean',
        'meta_data' => 'array',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
