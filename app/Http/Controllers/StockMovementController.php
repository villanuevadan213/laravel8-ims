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
        $stockMovements = StockMovement::with('product')->get();
        return response()->json($stockMovements);
    }

    // Show the form for creating a new stock movement
    public function create()
    {
        // Return data for creating a new stock movement
    }

    // Store a newly created stock movement in the database
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer',
            'reference_note' => 'nullable|string|max:255',
        ]);

        $stockMovement = StockMovement::create([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'reference_note' => $request->reference_note,
        ]);

        // Update product quantity based on stock movement type
        $product = Product::findOrFail($request->product_id);
        if ($request->type === 'in') {
            $product->increment('quantity', $request->quantity);
        } else {
            $product->decrement('quantity', $request->quantity);
        }

        return response()->json($stockMovement, 201);
    }

    // Display the specified stock movement
    public function show($id)
    {
        $stockMovement = StockMovement::with('product')->findOrFail($id);
        return response()->json($stockMovement);
    }

    // Show the form for editing the specified stock movement
    public function edit($id)
    {
        // Return data for editing the stock movement
    }

    // Update the specified stock movement in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer',
            'reference_note' => 'nullable|string|max:255',
        ]);

        $stockMovement = StockMovement::findOrFail($id);
        $stockMovement->update([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'reference_note' => $request->reference_note,
        ]);

        return response()->json($stockMovement);
    }

    // Remove the specified stock movement from the database
    public function destroy($id)
    {
        $stockMovement = StockMovement::findOrFail($id);
        $stockMovement->delete();

        return response()->json(null, 204);
    }
}
