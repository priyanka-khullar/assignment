<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillables = ['product_id', 'filename'];
    protected $table = 'product_images';

    public function images()
    {
        return $this->belongsTo(Product::class);
    }
}
