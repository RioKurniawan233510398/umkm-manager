@extends('layouts.app')

@section('title', 'Edit Aktivitas')

@section('content')

<div class="card border-0 shadow rounded-4">
    <div class="card-body">
        <h3 class="mb-4">Edit Aktivitas</h3>

        <form action="/activities/{{ $activity->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Judul Aktivitas</label>
                <input type="text" name="title" class="form-control" value="{{ $activity->title }}" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ $activity->description }}</textarea>
            </div>

            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="activity_date" class="form-control" value="{{ $activity->activity_date }}" required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="pending" {{ $activity->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $activity->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <button class="btn btn-success">Update</button>
            <a href="/activities" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection
