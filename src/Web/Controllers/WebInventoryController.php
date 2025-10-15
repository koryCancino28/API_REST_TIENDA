<?php

namespace Src\Web\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebInventoryController extends Controller
{
    public function index(Request $request)
    {
        return view('inventory.index');
    }
}
