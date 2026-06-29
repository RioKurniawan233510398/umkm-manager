@extends('layouts.app')

@section('title','Edit Penjualan')

@section('content')

<div class="card shadow border-0 rounded-4">

    <div class="card-body">

        <h3>Edit Penjualan</h3>

        <form action="{{ route('sales.update', $sale) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Produk</label>
                <select name="product_id" class="form-control" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}"
                            {{ $sale->product_id == $product->id ? 'selected' : '' }}>
                            {{ $product->nama_produk }} (Stok: {{ $product->stok }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number"
                       name="jumlah"
                       class="form-control"
                       value="{{ $sale->jumlah }}"
                       min="1"
                       required>
                <small class="text-muted">
                    Stok tersedia: {{ $sale->product->stok + $sale->jumlah }}
                </small>
            </div>

            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date"
                       name="tanggal"
                       class="form-control"
                       value="{{ $sale->tanggal }}">
            </div>

            <div class="mb-3">
                <label>Total Harga</label>
                <input type="text"
                       class="form-control"
                       value="Rp {{ number_format($sale->total_harga) }}"
                       readonly>
                <small class="text-muted">Total akan dihitung otomatis berdasarkan harga produk</small>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Batal</a>

        </form>

    </div>

</div>

@endsection
