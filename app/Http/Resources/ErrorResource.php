<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
   public function toArray($request)
   {
       return [
         'error' => [
             'message' => $this->resource->message,
             'code' => $this->resource->code,
         ]
       ];
   }
}
