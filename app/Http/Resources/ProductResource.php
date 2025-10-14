<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        /*return parent::toArray($request);*/
        return[
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'sku' => $this->sku,
            'stock' => $this->stock,
            'price' => $this->price,
            'is_active' => $this->is_active,
            'create_at'=> $this->created_at,
            'update_at'=> $this->updated_at,
        ];
    }
}
