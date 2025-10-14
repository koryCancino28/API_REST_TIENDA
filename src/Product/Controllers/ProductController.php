<?php

namespace Src\Product\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Src\Product\Requests\ProductStoreRequest;
use Src\Product\Requests\ProductUpdateRequest;
use Src\Product\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $req)
    {
        $q = Product::query();
        if ($s = $req->query('search')) {
            $q->where(fn($w) => $w->where('name', 'like', "%$s%")->orWhere('sku', 'like', "%$s%"));
        }
        return ProductResource::collection($q->orderByDesc('id')->paginate(15));
    }

    public function store(ProductStoreRequest $req)
    {
        $product = Product::create($req->validated());
        return (new ProductResource($product))->response()->setStatusCode(201);
    }

    public function show($id)
    {
        return new ProductResource(Product::findOrFail($id));
    }
    public function update(ProductUpdateRequest $req, $id)
    {
        $p = Product::findOrFail($id);
        $p->update($req->validated());
        return new ProductResource($p);
    }
    public function destroy($id)
    {
        $p = Product::findOrFail($id);
        $p->delete();
        return response()->json(['message' => 'Eliminado']);
    }
}
