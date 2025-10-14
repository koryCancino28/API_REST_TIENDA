<?php

namespace Src\Inventory\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InventoryEntry;
use App\Models\Product;
use Src\Inventory\Requests\InventoryStoreRequest;
use Src\Inventory\Resources\InventoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $req)
    {
        $q = InventoryEntry::with('product');
        if ($pid = $req->query('product_id')) $q->where('product_id', $pid);
        if ($type = $req->query('type')) $q->where('type', $type);

        return InventoryResource::collection($q->orderByDesc('id')->paginate(15));
    }

    public function store(InventoryStoreRequest $req)
    {
        return DB::transaction(function () use ($req) {
            $data  = $req->validated();

            // Crear registro de inventario
            $entry = InventoryEntry::create($data);

            // Ajustar stock del producto de forma segura
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);
            $delta   = $data['type'] === 'IN' ? $data['quantity'] : -$data['quantity'];
            $new     = max(0, $product->stock + $delta);
            $product->update(['stock' => $new]);

            return (new InventoryResource($entry->load('product')))->response()->setStatusCode(201);
        });
    }
}
