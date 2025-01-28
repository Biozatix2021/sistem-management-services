@extends('layouts.main')

@section('content-header')
    <section class="content-header">
        <h1>
            Uji Fungsi
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Uji Fungsi</a></li>
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
                <table id="tabel-uji-fungsi" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>SN</th>
                            <th>No Order</th>
                            <th>No Faktur</th>
                            <th>Tgl Faktur</th>
                            <th>Tgl Terima</th>
                            <th>Tgl Selesai</th>
                            <th>Status</th>
                            <th width="20px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="modal fade" id="tambah-data-qc" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Uji Fungsi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        </div>
                    </div>
                </div>
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

        table = $('#tabel-uji-fungsi').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    // $('#form-tambah-alat')[0].reset();
                    window.location.href = "{{ route('data-uji-fungsi.create') }}";
                }
            }],
            ajax: "{{ route('data-uji-fungsi.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'no_seri',
                    name: 'no_seri'
                },
                {
                    data: 'no_order',
                    name: 'no_order'
                },
                {
                    data: 'no_faktur',
                    name: 'no_faktur'
                },
                {
                    data: 'tgl_faktur',
                    name: 'tgl_faktur'
                },
                {
                    data: 'tgl_terima',
                    name: 'tgl_terima'
                },
                {
                    data: 'tgl_selesai',
                    name: 'tgl_selesai'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    </script>
@endsection
