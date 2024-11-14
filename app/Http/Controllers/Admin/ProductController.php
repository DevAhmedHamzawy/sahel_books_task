<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct(){
        $this->middleware(['permission:add_product'])->only(['create', 'store']);
        $this->middleware(['permission:edit_product'])->only(['edit', 'update']);
        $this->middleware(['permission:view_product'])->only(['index']);
        $this->middleware(['permission:delete_product'])->only(['delete']);
    }

    public function index(){
        $Products = Product::all();
        return view('admin.products.index', ['products' => $Products]);
    }
}
