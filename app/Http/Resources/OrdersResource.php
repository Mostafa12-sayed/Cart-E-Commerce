<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'transaction_id'=>$this->transaction_id,
            'total'=>$this->total / 10000,
            'status'=>"pending",
            'order_num'=>$this->order_num,
            'products'=>$this->products,
            'created_at'     => $this->created_at->format('h:i A d-m-Y'),
            'updated_at'     => $this->updated_at->format('h:i A d-m-Y'),

        ];
    }
}
