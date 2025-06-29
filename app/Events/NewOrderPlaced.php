<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderPlaced implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public $orderBatch;

    public function __construct($orderBatch)
    {
        $this->orderBatch = $orderBatch;
    }

    public function broadcastOn()
    {
        return new Channel('admin-orders');
    }

    public function broadcastAs()
    {
        return 'new-order';
    }

    public function broadcastWith()
{
      return [
            'order_id' => $this->orderBatch->id,
            'customer_name' => $this->orderBatch->user->name ?? 'Guest',
            'total' => $this->orderBatch->total_price,
            'message' => 'Pesanan baru masuk!',
            'created_at' => $this->orderBatch->created_at->format('d M Y, H:i'),
            // TAMBAHAN: Data items untuk ditampilkan di frontend
            'items' => $this->orderBatch->orders->map(function($order) {
                return [
                    'product_nama' => $order->product->nama ?? 'Produk tidak ditemukan',
                    'product_gambar' => $order->product->gambar ?? null,
                    'quantity' => $order->quantity,
                    'total_price' => $order->total_price ?? 0
                ];
            })->toArray()
        ];
}
}