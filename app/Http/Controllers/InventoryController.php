<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InventoryController extends Controller
{
    public function dashboard()
    {
        // Get the total count of products
        $totalProducts = Product::count();

        // Get the low stock alert (products with quantity below reorder level)
        $lowStock = Product::where('quantity', '<', 'reorder_level')->simplePaginate(10);

        // Get the recent stock movements (for example, last 5 movements)
        $recentMovements = StockMovement::latest()->take(5)->get();

        // Pass the data to the view
        return view('dashboard', compact('totalProducts', 'lowStock', 'recentMovements'));
    }

    // Show the inventory (List of all products)
    public function index(Request $request)
    {
        // Get search input from the request
        $searchTerm = $request->input('search');

        // Fetch products with category, filter by search term if provided, and paginate
        $products = Product::with('category')
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('name', 'like', '%' . $searchTerm . '%')
                             ->orWhere('sku', 'like', '%' . $searchTerm . '%'); // Search by name or SKU
            })
            ->latest()
            ->simplePaginate(10);

        // Return the view with products and search term
        return view('inventory.index', compact('products', 'searchTerm'));
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
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products',
            'quantity' => 'required|integer',
            'unit' => 'required|string',
            'reorder_level' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Store the product
        $product = Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'reorder_level' => $request->reorder_level,
            'category_id' => $request->category_id,
        ]);

        // ✅ Manually create StockMovement for the initial stock setup
        StockMovement::create([
            'product_id' => $product->id,
            'type' => 'in',  // Type "in" for stock added
            'quantity' => $product->quantity,  // Set quantity as the initial stock
            'reference' => 'Initial stock setup',  // Reference for the first entry
            'price' => 0,  // Add price if needed (or keep 0 if not)
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
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'quantity' => 'required|integer',
            'unit' => 'required|string',
            'reorder_level' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Fetch product for update
        $product = Product::findOrFail($id);
        $originalQuantity = $product->quantity;

        // Update product details
        $product->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'reorder_level' => $request->reorder_level,
            'category_id' => $request->category_id,
        ]);

        // ✅ Add StockMovement only if quantity has changed
        if ($product->quantity != $originalQuantity) {
            $movementType = $product->quantity < $originalQuantity ? 'out' : 'in';
            StockMovement::create([
                'product_id' => $product->id,
                'type' => $movementType,
                'quantity' => abs($product->quantity - $originalQuantity),  // Quantity difference
                'reference' => 'Stock updated',  // Update reference
                'price' => 0,  // Add price if needed (or keep 0 if not)
            ]);
        }

        return redirect()->route('inventory.index')->with('success', 'Product updated successfully');
    }

    // Delete the product from the inventory
    public function destroy($id)
    {
        // Fetch product
        $product = Product::findOrFail($id);

        // Log a stock movement if the product is being deleted
        StockMovement::create([
            'product_id' => $product->id,
            'type' => 'out',  // Stock is removed when product is deleted
            'quantity' => $product->quantity,
            'reference' => 'Product deleted',
            'price' => 0,
        ]);

        // Delete the product
        $product->delete();

        return redirect()->route('inventory.index')->with('success', 'Product deleted successfully');
    }
}
