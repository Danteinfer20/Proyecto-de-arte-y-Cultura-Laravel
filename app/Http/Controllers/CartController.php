<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add($productId)
    {
        // Lógica temporal para el carrito
        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function remove($itemId)
    {
        // Lógica temporal para eliminar del carrito
        return redirect()->back()->with('success', 'Producto eliminado del carrito');
    }
}