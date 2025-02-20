@extends('layouts.main')

@section('content-header')
    <section class="content-header">
        <h1>
            Instalasi Alat

        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Instalasi Alat</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="box">
        {{-- Header start --}}
        <div class="box-header with-border">
            <h3 class="box-title"></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>

        {{-- Header end --}}

        <!-- /.Body start -->
        <div class="box-body">
            <div class="data-tables">
                <table id="tabelInstalasi" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>SN</th>
                            <th>Nama Alat</th>
                            <th>Status <br> Instalasi</th>
                            <th>Teknisi</th>
                            <th>Lokasi</th>
                            <th>Instansi</th>
                            <th width="20px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var table;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        table = $('#tabelInstalasi').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    // $('#form-tambah-alat')[0].reset();
                    window.location.href = "{{ route('instalasi-alat.create') }}";
                }
            }],
            ajax: "{{ route('perusahaan') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'sn',
                    name: 'sn'
                },
                {
                    data: 'nama_alat',
                    name: 'nama_alat'
                },
                {
                    data: 'status_instalasi',
                    name: 'status_instalasi'
                },
                {
                    data: 'teknisi',
                    name: 'teknisi'
                },
                {
                    data: 'lokasi',
                    name: 'lokasi'
                },
                {
                    data: 'instansi',
                    name: 'instansi'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    </script>
@endsection
