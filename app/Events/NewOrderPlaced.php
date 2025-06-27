<?php

namespace App\Events;

use App\Models\OrdersBatch;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $orderBatch;
    public $broadcastData;

    public function __construct(OrdersBatch $orderBatch, array $broadcastData = null)
    {
        $this->orderBatch = $orderBatch;
        
        // Jika broadcastData tidak disediakan, buat dari orderBatch
        $this->broadcastData = $broadcastData ?: $this->formatBroadcastData($orderBatch);
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
            'batch_id' => $this->batch->id,
            'customer_name' => $this->batch->user->name ?? 'Guest',
            'total' => $this->batch->total_price,
            'items_count' => $this->batch->orders->count(),
            'status' => $this->batch->status,
            'created_at' => $this->batch->created_at->format('H:i:s'),
            'message' => 'Pesanan baru masuk!',
            // Add items for display
            'items' => $this->batch->orders->map(function ($order) {
                return [
                    'product_name' => $order->product->nama ?? 'Unknown Product',
                    'quantity' => $order->quantity,
                    'price' => $order->total_price
                ];
            })
        ];
    }
}
