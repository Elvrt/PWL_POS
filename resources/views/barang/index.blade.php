@extends('layout.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div classs="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <lebel class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select class="form-control" id="kategori_id" name="kategroi_id" required>
                                        <option value="">-  Semua -</option>
                                        @foreach($kategori as $item)
                                            <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Kategori barang</small>
                                </div>
                            </div>
                        </div>
                    </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>Id barang</th>
                        <th>Kode barang</th>
                        <th>Nama barang</th>
                        <th>Kategori barang</th>
                        <th>Harga beli</th>
                        <th>Harga jual</th>
                        <th>Gambar Barang<th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    $(document).ready(function() {
        var dataBarang = $('#table_barang').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('barang/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                        d.kategori_id = $('#kategori_id').val();
                    }
            },
            columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "barang_kode",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "barang_nama",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "kategori.kategori_nama",
                    className: "",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "harga_beli",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "harga_jual",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                        data: "image",
                        className: "",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<img src="' + data + '" alt="Image" class="img-thumbnail" width="100">';
                        }
                },
                {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }
            ]
        });
        
        $('#kategori_id').on('change', function() {
                dataBarang.ajax.reload();
            });

    });
</script>
@endpush