@extends('layouts.app')

@section('title','Business Profile')

@section('content')

<div class="card shadow border-0 rounded-4">

<div class="card-body">

<h3 class="mb-4">

Tambah Profil Usaha

</h3>

<form
action="/business-profile"
method="POST"
enctype="multipart/form-data">

@csrf

<div class="mb-3">

<label>Nama Usaha</label>

<input
type="text"
name="nama_usaha"
class="form-control">

</div>

<div class="mb-3">

<label>Nama Pemilik</label>

<input
type="text"
name="pemilik"
class="form-control">

</div>

<div class="mb-3">

<label>Nomor Telepon</label>

<input
type="text"
name="telepon"
class="form-control">

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control">

</div>

<div class="mb-3">

<label>Alamat</label>

<textarea
name="alamat"
class="form-control">
</textarea>

</div>

<div class="mb-3">

<label>Deskripsi Usaha</label>

<textarea
name="deskripsi"
class="form-control">
</textarea>

</div>

<div class="mb-3">

<label>Logo Usaha</label>

<input
type="file"
name="logo"
class="form-control">

</div>

<button
class="btn btn-success">

Simpan

</button>

</form>

</div>
</div>

@endsection
