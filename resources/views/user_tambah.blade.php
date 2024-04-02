@extends('layout.app')

{{-- Customize layout sections --}}
@section('subtitle', 'User')
@section('content_header_title', 'User')
@section('content_header_subtitle', 'Add Data')

@section('content')
  <!-- form start -->
  <div class="card card-primary)">
    <div class="card-header">
        <h3 class="card-title">Form Tambah data User</h3>
    </div>
    <!-- / card-header -->
    <div class="card-body">
        
        <form method="post" action="/user/tambah_simpan">

            {{ csrf_field() }}
            <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username" placeholder="Masukan Username">
            </div>
            <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama" placeholder="Masukan nama">
            </div>
            <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="Masukan Password">
            </div>
            <div class="form-group">
            <label>Level ID</label>
            <input type="number" class="form-control" name="level_id" placeholder="Masukan ID Level">
            </div>
            <div class="card-footer">
                <a href="../user" class="btn btn-secondary">Kembali</a>
            <input type="submit" class="btn btn-primary" value="Simpan">
            </div>
        </form>
    </div>
  </div>
@endsection