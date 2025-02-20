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

            <div class="text-center">
                <div class="input-group" style="width: 100%; max-width: 50%; margin: 0 auto; margin-bottom: 10px;">
                    {{-- make select option --}}
                    <select id="filter" class="form-control" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                        <option value="">Pilih Alat</option>
                        @foreach ($alats as $alat)
                            <option value="{{ $alat->id }}">{{ $alat->merk }} {{ $alat->tipe }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-secondary" style="background-color: #3c8dbc; color:white" onclick="filter()">Terapkan</button>
                    </div>
                    <!-- /btn-group -->
                </div>
            </div>


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

            <div class="modal fade" id="detail-data-uji-fungsi" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="loader"
                                style="display: none; position: fixed; top: 30%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; text-align: center;">
                                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(37, 33, 33, 0.082);"></div>
                                <img src="{{ asset('img/spinner.gif') }}" style="width: 90px" alt="Loading..." />
                            </div>


                            {{-- Data will be displayed here --}}
                            <div class="row">
                                <div class="col-md-3">
                                    <!-- Profile Image -->
                                    <div class="box box-primary">
                                        <div class="box-body box-profile">
                                            <img class="profile-user-img img-responsive img-circle img-alat" src="" alt="User profile picture">

                                            <h3 class="profile-username text-center nama-alat"></h3>

                                            <p class="text-muted text-center"></p>

                                            <ul class="list-group list-group-unbordered">
                                                <li class="list-group-item">
                                                    <b>S/N</b> <a class="pull-right sn"></a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>No order</b> <a class="pull-right no-order"></a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>No Faktur</b> <a class="pull-right no-faktur"></a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Tgl Faktur</b> <a class="pull-right tgl-faktur"></a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Tgl Terima</b> <a class="pull-right tgl-terima"></a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Tgl Selesai</b> <a class="pull-right tgl-selesai" data-toggle="tooltip" data-placement="right"
                                                        title="Tanggal selesai dilakukan uji fungsi"></a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Status</b> <a class="pull-right status"><span class="label pull-center bg-green">Qualified</span></a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Teknisi</b> <a class="pull-right teknisi"></a>
                                                </li>
                                            </ul>
                                            <div class="box box-solid">
                                                <div class="box-header with-border">
                                                    <i class="fa fa-text-width"></i>

                                                    <h3 class="box-title">Keterangan</h3>
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body">
                                                    <blockquote class="keterangan">
                                                        {{-- berisi keterangan --}}
                                                    </blockquote>
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                            <button type="button" class="btn btn-default" onclick="downloadData()"><i class="fa fa-download" aria-hidden="true"></i>
                                                Download</button>
                                            <button type="button" class="btn btn-default" onclick="printData()"> <i class="fa fa-print" aria-hidden="true"></i>
                                                Print</button>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->
                                </div>
                                <div class="col-md-9">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Detail Data Uji Fungsi</h3>
                                        </div>
                                        <div class="box-body" style="overflow-x: auto;">
                                            <div class="data-tables">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Item Check</th>
                                                            <th>Qty</th>
                                                            <th>Check / Not</th>
                                                            <th>Dokumentasi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
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


        function showData(id) {
            $('#loader').show();
            $.ajax({
                url: "{{ url('data-uji-fungsi') }}" + '/' + id,
                type: "GET",
                success: function(data) {
                    $('#detail-data-uji-fungsi').modal('show');
                    $('.img-alat').attr('src', '/storage/alat/' + data.alat.gambar);
                    $('.nama-alat').text(data.alat.merk + ' ' + data.alat.tipe);
                    $('.text-muted.text-center').text(data.alat.nama);
                    $('.list-group-item').eq(0).find('.sn').text(data.no_seri);
                    $('.list-group-item').eq(1).find('.no-order').text(data.no_order);
                    $('.list-group-item').eq(2).find('.no-faktur').text(data.no_faktur);
                    $('.list-group-item').eq(3).find('.tgl-faktur').text(data.tgl_faktur);
                    $('.list-group-item').eq(4).find('.tgl-terima').text(data.tgl_terima);
                    $('.list-group-item').eq(5).find('.tgl-selesai').text(data.tgl_selesai);
                    $('.list-group-item').eq(6).find('.status').html(data.status == 1 ? '<span class="label pull-center bg-green">Qualified</span>' :
                        '<span class="badge badge-danger">Not Qualified</span>');
                    $('.list-group-item').eq(7).find('.teknisi').text(data.teknisi.nama);
                    $('.keterangan').text(data.keterangan);

                    var table = $('#detail-data-uji-fungsi').find('table tbody');
                    table.empty();
                    $.each(data.detail_uji_fungsi, function(index, value) {
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + value.item + '</td>' +
                            '<td>' + value.qty + '' + value.satuan + '</td>' +
                            '<td>' + (value.check == 1 ? 'Check' : 'Not') + '</td>' +
                            '<td><img src="/storage/foto_dokumentasiQC/' + value.foto +
                            '" alt="dokumentasi" class="img-thumbnail" style="width: 100px;"></td>' +
                            '</tr>';
                        table.append(row);
                    });
                    $('#loader').hide();

                },
                error: function() {
                    alert('Oops! Something error!');
                }
            });
        }

        function filter() {
            var filter = $('#filter').val();
            console.log(filter);
            table.draw();
        }

        table = $('#tabel-uji-fungsi').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    // $('#form-tambah-alat')[0].reset();
                    window.location.href = "{{ route('data-uji-fungsi.create') }}";
                }
            }],
            ajax: {
                url: "{{ route('data-uji-fungsi.index') }}",
                type: 'GET',
                data: function(data) {
                    data.filter = $('#filter').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
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
                    name: 'status',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return '<span class="label pull-center bg-green">Qualified</span>';
                        } else if (data == 0) {
                            return '<span class="badge badge-danger">Not Qualified</span>';
                        } else {
                            return data;
                        }
                    }
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
