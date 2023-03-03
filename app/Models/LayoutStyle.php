<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayoutStyle extends Model
{
    use HasFactory;

    protected $fillable = [
        'navbar_color',
        'navbar_text_color',
        'navbar_logo',

        'banner_color',
        'banner_text_color',
        'banner_logo',

        'slider_image1',
        'slider_image2',
        'slider_image3',
        'slider_image4',
        'slider_image5',

        'footer_color',
        'footer_text_color',
        'footer_logo',

    ];

}
