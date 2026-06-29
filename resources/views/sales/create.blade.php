@extends('layouts.app')

@section('title','New Transaction')

@section('content')

<div class="card shadow border-0 rounded-4">

<div class="card-body">

<h3 class="mb-4">

Transaksi Penjualan

</h3>

<form action="/sales" method="POST">

@csrf

<div class="mb-3">

<label>Pilih Produk</label>

<select
name="product_id"
class="form-control">

@foreach($products as $product)

<option
value="{{ $product->id }}">

{{ $product->nama_produk }}
-
Stok:
{{ $product->stok }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Jumlah</label>

<input
type="number"
name="jumlah"
class="form-control">

</div>

<button class="btn btn-success">

Simpan Transaksi

</button>

</form>

</div>
</div>

@endsection
