<?php

namespace App\Events;

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

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
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
            'order_id' => $this->order->id,
            'customer_name' => $this->order->user->name ?? 'Guest',
            'total' => $this->order->total,
            'items_count' => $this->order->items->count(),
            'created_at' => $this->order->created_at->format('H:i:s'),
            'message' => 'Pesanan baru masuk!'
        ];
    }
}