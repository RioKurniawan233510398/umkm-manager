@extends('layouts.app')

@section('title','Sales')

@section('content')

<div class="card shadow border-0 rounded-4">

    <div class="card-body">

        <div class="d-flex
                    justify-content-between
                    mb-4">

            <h3>Data Penjualan</h3>

            <a href="/sales/create"
               class="btn btn-success">

                + Transaksi Baru

            </a>

        </div>

        <table class="table">

            <thead>

            <tr>

                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Tanggal</th>
                <th>Aksi</th>

            </tr>

            </thead>

            <tbody>

            @foreach($sales as $sale)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $sale->product->nama_produk }}
                </td>

                <td>
                    {{ $sale->jumlah }}
                </td>

                <td>
                    Rp {{ number_format($sale->total_harga) }}
                </td>

                <td>
                    {{ $sale->tanggal }}
                </td>

                <td>
                    <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus penjualan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>

            </tr>

            @endforeach

            </tbody>

        </table>

        {{ $sales->links() }}

    </div>

</div>

@endsection
