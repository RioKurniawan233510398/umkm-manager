@extends('layouts.app')

@section('title','Products')

@section('content')

<div class="card border-0 shadow rounded-4">

    <div class="card-body">

        <div class="d-flex
                    justify-content-between
                    mb-4">

            <h3>Daftar Produk</h3>

            <a href="/products/create"
               class="btn btn-success">

                + Tambah Produk

            </a>

        </div>

        <form action="/products" method="GET" class="mb-4">

    <div class="input-group">

        <input type="text"
               name="search"
               class="form-control"
               placeholder="Cari produk...">

        <button class="btn btn-primary">

            Cari

        </button>

    </div>

</form>

        <table class="table">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach($products as $product)

                <tr>

                    <td>{{ $loop->iteration }}</td>

 <td>

@if($product->gambar)

    <img
        src="{{ asset('storage/'.$product->gambar) }}"
        width="80"
        height="80"
        style="object-fit:cover; border-radius:10px;">

@else

    Tidak ada gambar

@endif

</td>

                    <td>
                        {{ $product->nama_produk }}
                    </td>

                    <td>
                        {{ $product->kategori }}
                    </td>

                    <td>
                        {{ $product->stok }}
                    </td>

                    <td>

                        Rp {{ number_format($product->harga) }}

                    </td>

                    <td>

                        <a href="/products/{{ $product->id }}/edit"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form action="/products/{{ $product->id }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

        <div class="mt-4">
    {{ $products->links() }}
</div>

    </div>

</div>

@endsection
