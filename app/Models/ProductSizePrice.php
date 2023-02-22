<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size_id',
        'price',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
}
