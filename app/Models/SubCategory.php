<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';

    protected $fillable = [
        'name',
        'category',
        'status'
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
