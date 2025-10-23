<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Str;


class OrdersObserver
{
    public function creating(Order $order): void
    {
        $order->order_num = 'ORD-' . strtoupper(Str::random(6));
    }
}
