<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    // Show the form for creating a new product
    public function create()
    {
        // Return data for creating a new product
    }

    // Store a newly created product in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products',
            'quantity' => 'required|integer',
            'unit' => 'required|string',
            'reorder_level' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'reorder_level' => $request->reorder_level,
            'category_id' => $request->category_id,
        ]);

        return response()->json($product, 201);
    }

    // Display the specified product
    public function show($id)
    {
        $product = Product::with('category', 'stockMovements')->findOrFail($id);
        return response()->json($product);
    }

    // Show the form for editing the specified product
    public function edit($id)
    {
        // Return data for editing the product
    }

    // Update the specified product in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'quantity' => 'required|integer',
            'unit' => 'required|string',
            'reorder_level' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'reorder_level' => $request->reorder_level,
            'category_id' => $request->category_id,
        ]);

        return response()->json($product);
    }

    // Remove the specified product from the database
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(null, 204);
    }
}
