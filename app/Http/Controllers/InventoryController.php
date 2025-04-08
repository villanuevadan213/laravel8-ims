<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // Show the inventory (List of all products)
    public function index()
    {
        $products = Product::with('category')->latest()->simplePaginate(10);
        return view('inventory.index', compact('products'));
    }

    // Show the form to create a new product
    public function create()
    {
        $categories = Category::all();
        return view('inventory.create', compact('categories'));
    }

    // Store a new product in the inventory
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

        Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'reorder_level' => $request->reorder_level,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('inventory.index')->with('success', 'Product added successfully');
    }

    // Show an individual product in the inventory
    public function show($id)
    {
        $product = Product::with('category', 'stockMovements')->findOrFail($id);
        return view('inventory.show', compact('product'));
    }

    // Show the form to edit a product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); // For selecting categories
        return view('inventory.edit', compact('product', 'categories'));
    }

    // Update the product in the inventory
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

        return redirect()->route('inventory.index')->with('success', 'Product updated successfully');
    }

    // Delete the product from the inventory
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('inventory.index')->with('success', 'Product deleted successfully');
    }
}
