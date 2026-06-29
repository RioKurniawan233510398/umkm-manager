@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')

<div class="card border-0 shadow rounded-4">
    <div class="card-body">
        <h3 class="mb-4">Edit Produk</h3>

        <form action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" value="{{ $product->nama_produk }}" required>
            </div>

            <div class="mb-3">
                <label>Kategori</label>
                <input type="text" name="kategori" class="form-control" value="{{ $product->kategori }}" required>
            </div>

            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ $product->stok }}" required>
            </div>

            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ $product->harga }}" required>
            </div>

            <div class="mb-3">
                <label>Biaya Produksi</label>
                <input type="number" name="production_cost" class="form-control" value="{{ $product->production_cost }}" step="0.01">
                <small class="text-muted">Opsional. Digunakan untuk saran harga jual.</small>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ $product->deskripsi }}</textarea>
            </div>

            <div class="mb-3">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control">
                @if($product->gambar)
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                @endif
            </div>

            <button class="btn btn-success">Update</button>
            <a href="/products" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection
