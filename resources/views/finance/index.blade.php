@extends('layouts.app')

@section('title','Finance')

@section('content')

<div class="row mb-4">

    <div class="col-md-4">

        <div class="card bg-success text-white">

            <div class="card-body">

                <h5>Total Pemasukan</h5>

                <h2>
                    Rp
                    {{ number_format($totalPemasukan) }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card bg-danger text-white">

            <div class="card-body">

                <h5>Total Pengeluaran</h5>

                <h2>
                    Rp
                    {{ number_format($totalPengeluaran) }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card bg-primary text-white">

            <div class="card-body">

                <h5>Laba Bersih</h5>

                <h2>
                    Rp
                    {{ number_format($labaBersih) }}
                </h2>

            </div>

        </div>

    </div>

</div>

<a href="/finance/create"
   class="btn btn-success mb-3">

    + Tambah Data

</a>

<div class="card">

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

{{ $finances->links() }}

</div>
</div>

@endsection
