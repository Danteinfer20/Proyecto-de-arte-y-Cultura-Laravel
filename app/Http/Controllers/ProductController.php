<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'user'])
            ->where('is_visible', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::where('type', 'product')
            ->where('is_active', true)
            ->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'user', 'productImages'])
            ->findOrFail($id);

        // Incrementar contador de vistas
        $product->increment('view_count');

        return view('products.show', compact('product'));
    }
}