@extends('layout.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('stok/create') }}">Tambah</a>
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
                                    <select class="form-control" id="barang_id" name="barang_id" required>
                                        <option value="">-  Semua -</option>
                                        @foreach($barang as $item)
                                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Kategori stok</small>
                                </div>
                            </div>
                        </div>
                    </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama barang</th>
                        <th>Nama user</th>
                        <th>Tanggal</th>
                        <th>Jumlah stok</th>
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
        var dataStok = $('#table_stok').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('stok/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                        d.barang_id = $('#barang_id').val();
                    }
            },
            columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "barang.barang_nama",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "user.nama",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "stok_tanggal",
                    className: "",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "stok_jumlah",
                    className: "",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }
            ]
        });
        
        $('#barang_id').on('change', function() {
                dataStok.ajax.reload();
            });

    });
</script>
@endpush