<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersBatch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders_batch';

    protected $fillable = [
        'user_id',
        'status',
        'total_price',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class, 'order_batch_id');
    }
}
