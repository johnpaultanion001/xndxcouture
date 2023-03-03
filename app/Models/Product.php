<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'name',
        'category_id',
        'size_id',
        'description',
        'unit_price',
        'retailed_price',
        'stock',
        'discount',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id' , 'id')->latest();
    }
    public function reviewsIsStar()
    {
        return $this->hasMany(Review::class, 'product_id' , 'id')->where('isStar', true)->count();
    }
}
