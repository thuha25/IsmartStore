<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'product_name',
        'product_price',
        'category_id',
        'brand_id',
        'describe',
        'product_content',
        'status',
        'thumbnail_path', 
        'slug'
    ];

    public function colors()
    {
        return $this->belongsToMany(ColorProduct::class, 'product_color', 'product_id', 'color_id');
    }
 
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function category()
    {
        return $this->belongsTo(CatProduct::class, 'category_id');
    }
    public function brands()
    {
        return $this->belongsTo(BrandProduct::class, 'brand_id');
    }

    public function scopeSearch($query)
    {
        if (request('key')) {
            $key = request('key');
            $query = $query->where('product_name','like','%'.$key.'%');

        }
        return $query;
    }
}
