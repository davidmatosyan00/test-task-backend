<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'email' => $this->resource->email,
            'name' => $this->resource->name,
            'api_key' => $this->resource->api_key,
        ];
    }
}
