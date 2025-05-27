<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity', 'status', 'total_price'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Produk::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function orderItems(){
    return $this->hasMany(OrderItem::class);
    }

}
