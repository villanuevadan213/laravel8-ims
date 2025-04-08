<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    // Display a listing of the stock movements
    public function index()
    {
        // Get all stock movements and pass to the view
        $stockMovements = StockMovement::with('product')->get();
        return view('stock_movements.index', compact('stockMovements'));
    }

    // Show the form for creating a new stock movement
    public function create()
    {
        // Get all products to display in a dropdown or select input
        $products = Product::all();
        return view('stock_movements.create', compact('products'));
    }

    // Store a newly created stock movement in the database
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|string',
            'quantity' => 'required|integer',
            'reference' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        // Create the stock movement
        StockMovement::create([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'reference' => $request->reference,
            'price' => $request->price,
        ]);

        return redirect()->route('stock-movement.index')->with('success', 'Stock movement added successfully.');
    }

    // Display the specified stock movement
    public function show($id)
    {
        $stockMovement = StockMovement::with('product')->findOrFail($id);
        return view('stock_movements.show', compact('stockMovement'));
    }

    // Show the form for editing the specified stock movement
    public function edit($id)
    {
        $stockMovement = StockMovement::findOrFail($id);
        $products = Product::all();
        return view('stock_movements.edit', compact('stockMovement', 'products'));
    }

    // Update the specified stock movement in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|string',
            'quantity' => 'required|integer',
            'reference' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        $stockMovement = StockMovement::findOrFail($id);
        $stockMovement->update([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'reference' => $request->reference,
            'price' => $request->price,
        ]);

        return redirect()->route('stock-movement.index')->with('success', 'Stock movement updated successfully.');
    }

    // Remove the specified stock movement from the database
    public function destroy($id)
    {
        $stockMovement = StockMovement::findOrFail($id);
        $stockMovement->delete();

        return redirect()->route('stock-movement.index')->with('success', 'Stock movement deleted successfully.');
    }
}
