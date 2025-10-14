<?php

namespace Src\Inventory\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    public function toArray($req): array
    {
        return [
            'id'       => $this->id,
            'type'     => $this->type,
            'quantity' => (int) $this->quantity,
            'reason'   => $this->reason,
            'note'     => $this->note,
            'product'  => [
                'id'  => $this->product->id,
                'sku' => $this->product->sku,
                'name' => $this->product->name,
            ],
            'audit' => [
                'created_by' => $this->created_by,
                'updated_by' => $this->updated_by,
                'deleted_by' => $this->deleted_by,
                'created_ip' => $this->created_ip,
                'updated_ip' => $this->updated_ip,
                'deleted_ip' => $this->deleted_ip,
            ],
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
