<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_no',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'zip_code',
        'total_price',
        'payment_method',
        'payment_id',
        'status',
        'comments'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
