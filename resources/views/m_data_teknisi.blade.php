@extends('layouts.main')

@section('content-header')
    <section class="content-header">
        <h1>
            Master Data Teknisi

        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Data Teknisi</a></li>
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
            <div class="modal fade" id="tambah-data-alat" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-tambah-alat" name="form-tambah-alat" class="form-horizontal">
                                @csrf
                                <div class="form-group row">
                                    <input type="hidden" class="form-control" id="id">
                                    <label for="inputNamaTeknisi" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputNamaTeknisi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputNoTelp" class="col-sm-2 col-form-label">No. Telepon</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputNoTelp">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" id="tombol-tambah-form" class="btn btn-primary btn-sm" onclick="save_data()">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="data-tables">
                <table id="tabelTeknisi" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Nama</th>
                            <th>No Telp</th>
                            <th width="20px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.end box-body -->
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

        table = $('#tabelTeknisi').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    // $('#form-tambah-alat')[0].reset();
                    $('#tambah-data-alat').modal('show');
                }
            }],
            LengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],

            ajax: {
                url: "{{ route('teknisi.index') }}",
                type: "GET",
                data: function(data) {}
            },
            columns: [{
                    "data": null,
                    "bDestroy": true,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                }, {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'no_hp',
                    name: 'no_hp'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function save_data() {
            var id = $('#id').val();
            var nama = $('#inputNamaTeknisi').val();
            var no_hp = $('#inputNoTelp').val();


            $.ajax({
                url: "{{ route('teknisi.store') }}",
                type: "POST",
                data: {
                    id: id,
                    nama: nama,
                    no_hp: no_hp
                },
                success: function(data) {
                    $('#tabelTeknisi').DataTable().ajax.reload();
                    $('#tambah-data-alat').modal('hide');
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }

        function edit_data(id) {
            $.ajax({
                url: "{{ url('teknisi') }}" + '/' + id + '/edit',
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#tambah-data-alat').modal('show');
                    $('#id').val(data.id);
                    $('#inputNamaTeknisi').val(data.nama);
                    $('#inputNoTelp').val(data.no_hp);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }

        function delete_data(id) {
            if (confirm('Apakah Anda yakin akan menghapus data ini?')) {
                $.ajax({
                    url: "{{ url('teknisi') }}" + '/' + id,
                    type: "DELETE",
                    success: function(data) {
                        $('#tabelTeknisi').DataTable().ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }
        }
    </script>
@endsection
