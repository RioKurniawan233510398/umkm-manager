@extends('layouts.app')

@section('title','Business Profile')

@section('content')

@if(!$profile)

<a href="/business-profile/create"
class="btn btn-success">

Tambah Profil Usaha

</a>

@else

<div class="card shadow border-0 rounded-4">

<div class="card-body text-center">

@if($profile->logo)

<img
src="{{ asset('storage/'.$profile->logo) }}"
width="150"
class="rounded-circle mb-3">

@endif

<h2>

{{ $profile->nama_usaha }}

</h2>

<p>

Pemilik:
{{ $profile->pemilik }}

</p>

<p>

{{ $profile->telepon }}

</p>

<p>

{{ $profile->email }}

</p>

<p>

{{ $profile->alamat }}

</p>

<hr>

<p>

{{ $profile->deskripsi }}

</p>

</div>

</div>

@endif

@endsection
