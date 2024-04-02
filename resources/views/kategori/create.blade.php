@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Create')
{{-- Content body: main page content --}}
@section('content')
    <diV class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Buat kategori baru</h3>
            </div>
        <form method="post" action="../kategori">
            <div class="card-body">
                <div class="form-group">
                    <label for="kategori_kode">Kode Kategori</label>
                    <input type="text" class="form-control @error('kodeKategori') is-invalid
                    @enderror" id="kategori_kode" name="kategori_kode" placeholder="Kode Kategori">

                    @error('kategori_kode')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="kategori_nama">Nama Kategori</label>
                    <input type="text"  class="form-control @error('kategori_nama') is-invalid
                    @enderror" id="kategori_nama" name="kategori_nama" placeholder="Nama Kategori">
                    
                    @error('kategori_nama')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                </div>
            </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error )
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        
        </div>
    </div>

    @endsection