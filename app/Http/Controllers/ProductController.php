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
        $search = $request->search;

        $products = Product::where(
                            'nama_produk',
                            'like',
                            "%$search%"
                        )
                        ->latest()
                        ->paginate(5);

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori' => 'required',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric'
        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request
                        ->file('gambar')
                        ->store('products', 'public');
        }

        Product::create([
            'nama_produk' => $request->nama_produk,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'production_cost' => $request->production_cost,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar
        ]);

        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori' => 'required',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);

        $gambar = $product->gambar;

        if ($request->hasFile('gambar')) {
            $gambar = $request
                        ->file('gambar')
                        ->store('products', 'public');
        }

        $product->update([
            'nama_produk' => $request->nama_produk,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'production_cost' => $request->production_cost,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar
        ]);

        return redirect('/products')
                ->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/products')
                ->with('success', 'Produk berhasil dihapus');
    }
}
