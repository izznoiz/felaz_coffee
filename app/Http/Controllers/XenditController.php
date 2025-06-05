<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\OrdersBatch;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class XenditController extends Controller
{
    public function handleWebhook(Request $request)
    {
        if ($request->status === 'PAID') {
            $externalId = $request->external_id;

            $checkout = DB::table('pending_checkouts')->where('external_id', $externalId)->first();
            if (!$checkout) return response()->json(['message' => 'Data tidak ditemukan'], 404);

            $cartItems = json_decode($checkout->cart_snapshot);

            $orderBatch = OrdersBatch::create([
                'user_id' => $checkout->user_id,
                'total_price' => $request->amount,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                Order::create([
                    'order_batch_id' => $orderBatch->id,
                    'user_id' => $checkout->user_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'total_price' => $item->product->harga * $item->quantity,
                    'status' => 'pending',
                ]);
            }

            CartItem::where('user_id', $checkout->user_id)->delete();
            DB::table('pending_checkouts')->where('external_id', $externalId)->delete();
        }

        return response()->json(['status' => 'success']);
    }
}
