<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductImages;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillables = ['name', 'description', 'price'];
    protected $table = 'products';

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}
