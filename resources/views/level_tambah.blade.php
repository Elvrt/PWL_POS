@extends('layout.app')

{{-- Customize layout sections --}}
@section('subtitle', 'User')
@section('content_header_title', 'User')
@section('content_header_subtitle', 'Add Data')

@section('content')
  <!-- form start -->
  <div class="card card-primary)">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Data Level</h3>
    </div>
    <!-- / card-header -->
    <div class="card-body">
        
        <form method="post" action="/level/tambah_simpan">

            {{ csrf_field() }}
            <div class="form-group">
            <label>Level Kode</label>
            <input type="text" class="form-control" name="level_kode" placeholder="Masukan Level Kode">
            </div>
            <div class="form-group">
            <label>Level Nama</label>
            <input type="text" class="form-control" name="level_nama" placeholder="Masukan Level Nama">
            </div>
            <div class="card-footer">
                <a href="../user" class="btn btn-secondary">Kembali</a>
            <input type="submit" class="btn btn-primary" value="Simpan">
            </div>
        </form>
    </div>
  </div>
@endsection