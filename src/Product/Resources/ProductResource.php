<?php

namespace Src\Product\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($req): array
    {
        return [
            'id'    => $this->id,
            'sku'   => $this->sku,
            'name'  => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'stock' => (int) $this->stock,
            'audit' => [
                'created_by' => $this->created_by,
                'updated_by' => $this->updated_by,
                'deleted_by' => $this->deleted_by,
                'created_ip' => $this->created_ip,
                'updated_ip' => $this->updated_ip,
                'deleted_ip' => $this->deleted_ip,
            ],
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'deleted_at' => $this->deleted_at?->toISOString(),
        ];
    }
}
