<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_title',
        'product_description',
        'product_quantity',
        'product_price',
        'product_category',
        'product_images'
    ];

    protected $casts = [
        'product_images' => 'array',
        'product_price' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'product_category');
    }

    // Helper method to get first image
    public function getFirstImageAttribute()
    {
        $images = $this->product_images;
        return !empty($images) ? $images[0] : null;
    }

    // Helper method to get all images as URLs
    public function getImageUrlsAttribute()
    {
        $images = $this->product_images;
        if (empty($images)) {
            return [];
        }

        return array_map(function($path) {
            return asset($path);
        }, $images);
    }
}
