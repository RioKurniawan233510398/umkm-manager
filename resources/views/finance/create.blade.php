@extends('layouts.app')

@section('title','Tambah Keuangan')

@section('content')

<div class="card shadow border-0 rounded-4">

    <div class="card-body">

        <h3 class="mb-4">

            Tambah Data Keuangan

        </h3>

        <form action="/finance"
              method="POST">

            @csrf

            <div class="mb-3">

                <label>Jenis</label>

                <select
                    name="jenis"
                    class="form-control">

                    <option value="Pemasukan">
                        Pemasukan
                    </option>

                    <option value="Pengeluaran">
                        Pengeluaran
                    </option>

                </select>

            </div>

            <div class="mb-3">

                <label>Keterangan</label>

                <input type="text"
                       name="keterangan"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Jumlah</label>

                <input type="number"
                       name="jumlah"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Tanggal</label>

                <input type="date"
                       name="tanggal"
                       class="form-control">

            </div>

            <button class="btn btn-success">

                Simpan

            </button>

        </form>

    </div>

</div>

@endsection
