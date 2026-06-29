@extends('layouts.app')

@section('title', 'Activities')

@section('content')

<div class="card border-0 shadow rounded-4">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-4">
            <h3>Kalender Aktivitas Bisnis</h3>
            <a href="/activities/create" class="btn btn-success">+ Tambah Aktivitas</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $activity)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $activity->title }}</td>
                            <td>{{ $activity->description ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($activity->activity_date)->format('d M Y') }}</td>
                            <td>
                                @if($activity->status == 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="/activities/{{ $activity->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                                @if($activity->status == 'pending')
                                <form action="/activities/{{ $activity->id }}/complete" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Selesai</button>
                                </form>
                                @endif
                                <form action="/activities/{{ $activity->id }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada aktivitas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $activities->links() }}</div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <h5 class="mb-3">Kalender</h5>
                    <div id="calendar">
                        @php
                            $now = \Carbon\Carbon::now();
                            $month = $now->month;
                            $year = $now->year;
                            $daysInMonth = $now->daysInMonth;
                            $firstDay = \Carbon\Carbon::create($year, $month, 1)->dayOfWeek;
                            $today = $now->day;
                            $activityDates = \App\Models\Activity::whereMonth('activity_date', $month)
                                ->whereYear('activity_date', $year)
                                ->pluck('activity_date')
                                ->map(function($d) { return \Carbon\Carbon::parse($d)->day; })
                                ->toArray();
                        @endphp
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Min</th><th>Sen</th><th>Sel</th><th>Rab</th><th>Kam</th><th>Jum</th><th>Sab</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $dayCount = 1;
                                    $weeks = ceil(($daysInMonth + $firstDay) / 7);
                                @endphp
                                @for($w = 0; $w < $weeks; $w++)
                                <tr>
                                    @for($d = 0; $d < 7; $d++)
                                        @if(($w == 0 && $d < $firstDay) || $dayCount > $daysInMonth)
                                            <td></td>
                                        @else
                                            <td class="{{ $dayCount == $today ? 'bg-primary text-white' : '' }} {{ in_array($dayCount, $activityDates) ? 'fw-bold' : '' }}">
                                                {{ $dayCount }}
                                                @if(in_array($dayCount, $activityDates))
                                                    <br><small class="text-success">●</small>
                                                @endif
                                            </td>
                                            @php $dayCount++; @endphp
                                        @endif
                                    @endfor
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        <small class="text-muted">● = Ada aktivitas</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
