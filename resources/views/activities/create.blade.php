@extends('layouts.app')

@section('title', 'Tambah Aktivitas')

@section('content')

<div class="card border-0 shadow rounded-4">
    <div class="card-body">
        <h3 class="mb-4">Tambah Aktivitas Baru</h3>

        <form action="/activities" method="POST">
            @csrf

            <div class="mb-3">
                <label>Judul Aktivitas</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="activity_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="pending">Pending</option>
                    <option value="completed">Selesai</option>
                </select>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="/activities" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection
