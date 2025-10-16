<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Shared\Traits\AuditableWithIp;

class InventoryEntry extends Model
{
    use SoftDeletes, AuditableWithIp;

    protected $fillable = [
        'product_id',
        'type', // 'IN' o 'OUT'
        'quantity',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
