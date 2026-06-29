<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\Product;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $sales = Sale::with('product')
                ->latest()
                ->paginate(10);

    return view(
        'sales.index',
        compact('sales')
    );
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $products = Product::all();

    return view(
        'sales.create',
        compact('products')
    );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([

        'product_id'=>'required',
        'jumlah'=>'required|numeric|min:1'

    ]);

    $product = Product::findOrFail(
        $request->product_id
    );

    if($request->jumlah > $product->stok){

        return back()
            ->with('error',
            'Stok tidak mencukupi');
    }

    $total =
        $product->harga *
        $request->jumlah;

    Sale::create([

        'product_id'=>$product->id,
        'jumlah'=>$request->jumlah,
        'total_harga'=>$total,
        'tanggal'=>now()

    ]);

    $product->update([

        'stok'=>
        $product->stok -
        $request->jumlah

    ]);

    return redirect('/sales')
            ->with('success',
            'Penjualan berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'product_id' => 'required',
            'jumlah' => 'required|numeric|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Calculate the old total to adjust stock
        $oldJumlah = $sale->jumlah;
        $newJumlah = $request->jumlah;
        $difference = $oldJumlah - $newJumlah;

        // Check if new quantity exceeds stock (accounting for the difference)
        if ($newJumlah > $product->stok + $difference) {
            return back()
                ->with('error', 'Stok tidak mencukupi');
        }

        $total = $product->harga * $newJumlah;

        $sale->update([
            'product_id' => $product->id,
            'jumlah' => $newJumlah,
            'total_harga' => $total,
            'tanggal' => $request->tanggal ?? $sale->tanggal
        ]);

        // Update product stock
        $product->update([
            'stok' => $product->stok + $difference
        ]);

        return redirect('/sales')
            ->with('success', 'Penjualan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        // Restore stock
        $product = $sale->product;
        if ($product) {
            $product->update([
                'stok' => $product->stok + $sale->jumlah
            ]);
        }

        $sale->delete();

        return redirect('/sales')
            ->with('success', 'Penjualan berhasil dihapus');
    }
}
