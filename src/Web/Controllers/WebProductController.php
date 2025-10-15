<?php

namespace Src\Web\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebProductController extends Controller
{
    public function index(Request $request)
    {
        return view('products.index');
    }
    public function create(Request $request)
    {
        return view('products.create');
    }
    public function edit(Request $request, $id)
    {
        return view('products.edit', compact('id'));
    }
}
