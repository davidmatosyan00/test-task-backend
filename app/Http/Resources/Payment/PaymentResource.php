<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'payment_id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'status' => $this->resource->status,
            'amount' => $this->resource->amount,
            'amount_paid' => $this->resource->amount_paid,
            'card_last_four_digit' => $this->resource->card_last_four_digit,
            'type' => $this->resource->type,
            'timestamp' => $this->resource->created_at,
        ];
    }
}
