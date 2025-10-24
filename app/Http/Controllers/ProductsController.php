<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(){
        return Product::with('categories:id,name')->get();
    }
    public function categories(){
        return response()->json([
            "success"=>true,
            "data"=>Category::all()
        ]);
    }
}
