<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Shared\Traits\AuditableWithIp;

class Product extends Model
{
    use SoftDeletes, AuditableWithIp;
    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock',
    ];
}
