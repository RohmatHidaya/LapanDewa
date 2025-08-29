<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('q');

        $products = Product::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('barcode', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('produk', compact('products'));
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

    /**
     * Autocomplete endpoint for product search.
     * Returns JSON array of products matching the query.
     */
    public function autocomplete(Request $request)
    {
        $q = trim($request->query('q', ''));
        if ($q === '' || mb_strlen($q) < 1) {
            return response()->json([]);
        }

        $products = Product::query()
            ->where(function ($query) use ($q) {
                $query->where('nama', 'like', '%' . $q . '%')
                      ->orWhere('barcode', 'like', '%' . $q . '%');
            })
            ->orderBy('nama')
            ->limit(8)
            ->get(['id', 'nama', 'barcode', 'harga']);

        $results = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'nama' => $p->nama,
                'barcode' => $p->barcode,
                'harga' => $p->harga,
                // Generic keys for reusable autocomplete components
                'label' => $p->nama,
                'value' => $p->nama,
                'meta' => '#' . $p->barcode,
                'description' => 'Rp' . number_format($p->harga, 0, ',', '.'),
            ];
        })->values();

        return response()->json($results);
    }
}
