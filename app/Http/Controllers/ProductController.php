<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function index()
    {
        try {
            $products = Product::all();
            return response()->json($products, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::find($id);
            if(!isset($product)) {
                return response()->json($product, 404);
            }
            return response()->json($product, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|max:255|unique:products',
                'description' => 'max:255',
                'price' => 'required|numeric',
                'category' => 'required|max:255',
            ]);
            $product = Product::create($validate);
            return response()->json($product, 201);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $product = Product::find($request->id);
            if(!isset($product)) {
                return response()->json($product, 404);
            }
            $validate = $request->validate([
                'id' => 'required|numeric',
                'name' => 'required|max:255',
                'description' => 'max:255',
                'price' => 'required|numeric',
                'category' => 'required|max:255',
            ]);
            $product->update($validate);
            return response()->json($product, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }


    public function destroy(Product $product)
    {
        try {
            $existing_product = Product::find($product->id);
            if(!$existing_product) {
                return response()->json($existing_product, 404);
            }
            $product->destroy('id', $product->id);
            return response()->json(null, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
}
