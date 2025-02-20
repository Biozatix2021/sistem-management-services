@extends('layouts.main')

@section('title', 'Data Garansi')

@section('content-header')
    <section class="content-header">
        <h1>
            Master Data Garansi

        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Data Garansi</a></li>
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
                <table id="tabelGaransi" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>ID Garansi</th>
                            <th>Nama <br> Garansi</th>
                            <th>Durasi <br> Aktif</th>
                            <th>Penyedia</th>
                            <th width="20px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Modal Tambah Data Perusahaan -->
            <div class="modal fade" id="modal-tambah-data" tabindex="-1" role="dialog" aria-labelledby="tambah-data-perusahaan" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4>Tambah Data</h4>
                        </div>
                        <form id="form-tambah-data" name="form-tambah-data" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="IDGaransi">ID garansi</label>
                                        <input type="text" class="form-control" id="IDGaransi" name="IDGaransi" required readonly>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="nama_garansi">Nama Garansi</label>
                                        <input type="text" class="form-control" id="nama_garansi" name="nama_garansi" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="durasi">Durasi Aktif</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control text-center" id="durasi" name="durasi" required value="0">
                                            <span class="input-group-addon">Tahun</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="durasi">Penyedia</label>
                                        <div class="input-group" style="width: 100%">
                                            <select class="form-control" id="penyedia" name="penyedia" required>
                                                <option value="">-- Pilih Penyedia --</option>
                                                <option value="PT Biozatix Indonesia">PT Biozatix Indonesia</option>
                                                <option value="PT Vantagebio Scientific Solution">PT Vantagebio Scientific Solution</option>
                                                <option value="PT Flexylabs Instrument Indonesia">PT Flexylabs Instrument Indonesia</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="catatan_tambahan">Catatan Tambahan</label>
                                    <textarea class="textarea2" placeholder="Catatan Tambahan"
                                        style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" id="btn-simpan" onclick="save_data()"> <span class="spinner-border spinner-border-sm"
                                        role="status" aria-hidden="true"></span>Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.Modal Tambah Data Perusahaan end -->


            <!-- /.Body end -->
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

        $('#nama_garansi').on('input', function() {
            var namaGaransi = $(this).val();
            var idGaransi = namaGaransi.toLowerCase().replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, '-').substring(0, 20);
            $('#IDGaransi').val(idGaransi);
        });

        $(function() {
            //bootstrap WYSIHTML5 - text editor
            $('.textarea1').wysihtml5()
            $('.textarea2').wysihtml5()
        })

        $('#biaya').on('input', function() {
            var value = $(this).val().replace(/,/g, '');
            if (!isNaN(value) && value !== '') {
                $(this).val(parseFloat(value).toLocaleString('en'));
            } else {
                $(this).val(0);
            }
        });

        $('#durasi').on('input', function() {
            var value = $(this).val();
            if (value < 0) {
                $(this).val(0);
            }
        });

        function save_data() {
            var data = new FormData($('#form-tambah-data')[0]);
            data.append('syaratKetentuan', $('.textarea1').val());
            data.append('catatan_tambahan', $('.textarea2').val());
            $.ajax({
                type: 'POST',
                url: "{{ route('data-garansi.store') }}",
                data: data,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btn-simpan').attr('disabled', 'disabled');
                    $('#btn-simpan').html('<i class="fa fa-circle-o-notch fa-spin"></i> Menyimpan...');
                },
                success: function(data) {
                    $('#form-tambah-data')[0].reset();
                    $('#modal-tambah-data').modal('hide');
                    $('#tabelGaransi').DataTable().ajax.reload();
                    toastr.success('Data berhasil disimpan');
                },
                error: function(data) {
                    console.log(data);
                    $('#btn-simpan').removeAttr('disabled');
                    $('#btn-simpan').html('Simpan');
                    toastr.error('Data gagal disimpan');
                }
            });
        }

        function edit_data(id) {
            $.ajax({
                url: "{{ url('data-garansi') }}" + '/' + id + '/edit',
                type: 'GET',
                success: function(data) {
                    $('#modal-tambah-data').modal('show');
                    $('#IDGaransi').val(data.ID_garansi);
                    $('#nama_garansi').val(data.nama_garansi);
                    $('#jenis_produk').val(data.jenis_produk);
                    $('#durasi').val(data.durasi);
                    $('#cakupan_garansi').val(data.cakupan_garansi);
                    $('#penyedia').val(data.penyedia);
                    $('#biaya').val(data.biaya);
                    $('#detail_biaya').val(data.detail_biaya);
                    $('#metode_klaim').val(data.metode_klaim);
                    editorDescrizioneBreve.data('.textarea1').editor.setValue(data.syarat_ketentuan, true);
                },
                error: function(data) {
                    console.log(data);
                    toastr.error('Data gagal diambil');
                }
            });
        }

        $('#tabelGaransi').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    $('#form-tambah-data')[0].reset();
                    $('#modal-tambah-data').modal('show');
                }
            }],
            LengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],
            ajax: {
                url: "{{ route('data-garansi.index') }}",
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
                },
                {
                    data: 'ID_garansi',
                    name: 'ID_garansi',
                },
                {
                    data: 'nama_garansi',
                    name: 'nama_garansi'
                },
                {
                    data: 'durasi',
                    render: function(data, type, row) {
                        return data + ' Tahun';
                    },
                    name: 'durasi'
                },
                {
                    data: 'penyedia',
                    name: 'penyedia'
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
