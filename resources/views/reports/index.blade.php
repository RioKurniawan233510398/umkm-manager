@extends('layouts.app')

@section('title','Reports')

@section('content')

<div class="container-fluid">

<div class="d-flex
            justify-content-between
            mb-4">

    <h2>Laporan Usaha</h2>

    <div>

        <a href="/reports/pdf"
           class="btn btn-danger">

            Export PDF

        </a>

    </div>

</div>

<div class="card mb-4">

<div class="card-header">

Laporan Penjualan

</div>

<div class="card-body">

<table class="table">

<thead>

<tr>

<th>No</th>
<th>Produk</th>
<th>Jumlah</th>
<th>Total</th>
<th>Tanggal</th>

</tr>

</thead>

<tbody>

@foreach($sales as $sale)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $sale->product->nama_produk }}</td>

<td>{{ $sale->jumlah }}</td>

<td>
Rp {{ number_format($sale->total_harga) }}
</td>

<td>{{ $sale->tanggal }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>
</div>

<div class="card">

<div class="card-header">

Laporan Keuangan

</div>

<div class="card-body">

<table class="table">

<thead>

<tr>

<th>No</th>
<th>Jenis</th>
<th>Keterangan</th>
<th>Jumlah</th>
<th>Tanggal</th>

</tr>

</thead>

<tbody>

@foreach($finances as $finance)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $finance->jenis }}</td>

<td>{{ $finance->keterangan }}</td>

<td>
Rp {{ number_format($finance->jumlah) }}
</td>

<td>{{ $finance->tanggal }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

@endsection
