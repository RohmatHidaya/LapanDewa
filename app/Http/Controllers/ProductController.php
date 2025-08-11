<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('produk', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $product->create($request->validate([
            'nama' => 'required|string',
            'harga' => 'required|integer',
            'stok' => 'integer|required',
            'barcode' => 'string|required',
            'expired' => 'date|required',
        ]));

        return redirect()->route('produk')->with('status' , 'Product Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->validate([
            'nama' => 'string',
            'harga' => 'integer',
            'stok' => 'integer',
            'barcode' => 'string',
            'expired' => 'date',
            'is_active' => 'boolean',
        ]));

        return redirect()->route('produk')->with('status', 'product updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('produk')->with('destroy', 'Product Deleted');
    }
}
