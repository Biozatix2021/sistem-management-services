@extends('layouts.main')

@section('content-header')
    <section class="content-header">
        <h1>
            Master Data Perusahaan
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Data Sop Alat</a></li>
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
                <table id="tabel-data-perusahaan" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Nama</th>
                            <th>Logo</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th width="20px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Modal Tambah Data Perusahaan -->
            <div class="modal fade" id="tambah-data-perusahaan" tabindex="-1" role="dialog" aria-labelledby="tambah-data-perusahaan" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="tambah-data-perusahaan">Tambah Data Perusahaan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="form-tambah-data-perusahaan" name="form-tambah-data-perusahaan" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama">Nama Perusahaan</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo Perusahaan</label>
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*" onchange="previewImage(event)">
                                    <img id="preview" src="#" alt="Preview Image" style="display: none; max-width: 100px; margin-top: 10px;">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="telp">Telepon</label>
                                    <input type="text" class="form-control" id="telp" name="telp" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="text" class="form-control" id="website" name="website" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        table = $('#tabel-data-perusahaan').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    // $('#form-tambah-alat')[0].reset();
                    $('#tambah-data-perusahaan').modal('show');
                }
            }],
            ajax: "{{ route('perusahaan') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'logo',
                    name: 'logo'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'telp',
                    name: 'telp'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'website',
                    name: 'website'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        function save_data() {
            var form = $('#form-tambah-data-perusahaan')[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: "{{ route('perusahaan.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    toastr.success('Data berhasil disimpan');
                    $('#tambah-data-perusahaan').modal('hide');
                    table.ajax.reload();
                    $('#form-tambah-data-perusahaan')[0].reset();
                },
                error: function(data) {
                    toastr.error(data.responseJSON.text);
                    console.log('Error:', data);
                }
            });
        }

        function delete_data(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ url('perusahaan/delete') }}" + '/' + id,
                    success: function(data) {
                        table.ajax.reload();
                        toastr.success('Data berhasil dihapus');
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        toastr.error('Data gagal dihapus');
                    }
                });
            }
        }
    </script>
@endsection
