<?php

namespace App\Models;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id',
        'category',
        'name',
        'slug',
        'small_description',
        'description',
        'original_price',
        'selling_price',
        'image',
        'quantity',
        'status',
        'featured',
        'trending',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
}
