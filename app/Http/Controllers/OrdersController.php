<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrdersResource;
use App\Models\Order;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('products')->where('user_id', auth()->user()->id)->get();
        return response()->json(OrdersResource::collection($orders)) ;
    }
    public function show($id)
    {
        $order = Order::with('products')->where('user_id', auth()->user()->id)->where('order_num',$id)->first();
        return response()->json(new OrdersResource($order));

    }
}
