<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'user', 'images'])
            ->where('status', 'available') // ✅ Columna correcta: status
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::where('is_active', true)->get(); // ✅ Sin type

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'user', 'images'])
            ->findOrFail($id);

        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'product_type' => 'required|in:physical,digital,service,handicraft',
            'stock_quantity' => 'nullable|integer|min:0',
        ]);

        $product = Product::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock_quantity' => $validated['stock_quantity'] ?? 0,
            'product_type' => $validated['product_type'],
            'status' => 'available', // ✅ Status correcto
        ]);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Producto creado exitosamente.');
    }
}