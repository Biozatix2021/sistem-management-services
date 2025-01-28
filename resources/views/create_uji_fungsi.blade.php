@extends('layouts.main')

@section('title', 'Uji Fungsi')

@section('content-header')
    <section class="content-header">
        <h1>
            Master Data Uji Fungsi
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">QC Internal</a></li>
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

        <div class="box-body">
            <div class="text-center">
                <div class="input-group" style="width: 50%; margin: 0 auto;">
                    {{-- make select option --}}
                    <select id="alat_id" class="form-control" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                        <option value="" selected>Pilih Alat</option>
                        @foreach ($alats as $alat)
                            <option value="{{ $alat->id }}">{{ $alat->nama }} {{ $alat->type }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-secondary" style="background-color: #3c8dbc; color:white" onclick="filter()">Terapkan</button>
                    </div>
                    <!-- /btn-group -->
                </div>
            </div>
            <hr>
        </div>
    </div>
    <div class="row">
        <form id="form-tambah-uji-fungsi" name="form-tambah-uji-fungsi" method="POST" action="{{ route('data-uji-fungsi.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body" style="min-height: 300px">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th width="20px">Qty</th>
                                    <th width="15px">Check</th>
                                    <th width="35%">Dokumentasi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <tr>
                                    <td colspan="4" class="text-center">Pilih alat terlebih dahulu</td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="loader" style="display: none; text-align: center;">
                            <img src="{{ asset('img/spinner.gif') }}" style="width: 90px" alt="Loading..." />
                        </div>
                        <div class="form-group text-center">
                            <button type="button" class="btn btn-block btn-primary" id="btn-lanjut" style="display: none; margin-top: 10px;"
                                onclick="document.getElementById('data-uji-fungsi').scrollIntoView();">Lanjut</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body" id="data-uji-fungsi">
                        <div class="form-group">
                            <label for="nama">Nomor Seri</label>
                            <input type="text" class="form-control" id="inputNoSeri" name="no_seri" placeholder="Masukkan No Seri Alat">
                        </div>
                        <div class="form-group">
                            <label for="nama">No Order</label>
                            <input type="text" class="form-control" id="inputLokasi" name="lokasi" placeholder="Masukkan Lokasi Alat">
                        </div>
                        <div class="form-group">
                            <label for="nama">No Faktur</label>
                            <input type="text" class="form-control" id="inputKondisi" name="kondisi" placeholder="Masukkan Kondisi Alat">
                        </div>
                        <div class="form-group">
                            <label for="nama">Tgl Faktur</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker" name="tgl_faktur">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Tgl Terima</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker" name="tgl_terima">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Tgl Selesai</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker" name="tgl_selesai">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama">Teknisi</label>
                            <select name="teknisi" id="teknisi" class="form-control">
                                <option value="" selected>Pilih Teknisi</option>
                                @foreach ($teknisis as $teknisi)
                                    <option value="{{ $teknisi->id }}">{{ $teknisi->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" id="btn-simpan" class="btn btn-block btn-primary mt-10">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        // Show button id btn-lanjut if open in ratio mobile
        if ($(window).width() <= 768) {
            $('#btn-lanjut').css('display', 'block');
        }
        // Initialize datepickers
        $('#datepicker').datepicker({
            autoclose: true,
        });

        // Initialize datepickers for all date input fields
        $('input[name="tgl_faktur"], input[name="tgl_terima"], input[name="tgl_selesai"]').datepicker({
            autoclose: true,
        });

        function filter() {
            var alatId = $('#alat_id').val();
            console.log(alatId);
            $('#loader').show();
            $('#tbody').empty();
            $.ajax({
                url: "{{ route('form-qc') }}",
                type: 'GET',
                data: {
                    alat_id: alatId
                },
                success: function(response) {
                    console.log(response);
                    $('#loader').hide();
                    $.each(response.templates, function(index, item) {
                        $('#tbody').append(`
                            <tr>
                                <td>
                                    <input type="hidden" class="form-control" name="item_check[]" value="${item.item}">
                                    <label for="item" class="col-sm-2 col-form-label">${item.item}</label>
                                </td>
                                <td>
                                    <label for="qty" class="col-sm-2 col-form-label">${item.qty + item.satuan}</label>
                                    <input type="hidden" class="form-control" name="qty_item[]" value="${item.qty}">
                                </td>
                                <td>
                                    <input class="form-check-input" type="checkbox" value="" name="checkbox" id="defaultCheck1">
                                </td>
                                <td id="foto[${item.id}]">
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    $('#loader').hide();
                }
            });
        }

        $(document).on('change', '.form-check-input', function() {
            var row = $(this).closest('tr');
            var isChecked = $(this).is(':checked');
            var itemId = row.find('input[name="item_check[]"]').val();

            if (isChecked) {
                console.log('itemId', itemId);
                row.find('td:last').append(`
                <input type="file" name="foto[${itemId}]" accept="image/*" onchange="previewImage(event, '${itemId}')">
                <img id="preview-${itemId}" src="#" alt="Preview" style="display:none; width: 100px; height: auto; margin-top: 10px;">
            `);
            } else {
                row.find('td:last').empty();
            }
        });

        function previewImage(event, itemId) {
            var element = 'preview-' + itemId;
            var reader = new FileReader();
            console.log(itemId);
            reader.onload = function() {
                var output = document.getElementById(element);
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }


        $('#btn-simpan').click(function() {
            var isValid = true;
            var tbodyContent = $('#tbody').html().trim();

            if (tbodyContent === '') {
                alert('Anda belum memilih item uji fungsi.');
                return false; // Prevent form submission
            }

            $('.form-check-input').each(function() {
                if (!$(this).is(':checked')) {
                    isValid = false;
                    return false; // Exit the loop
                }
            });

            if (!isValid) {
                alert('Please check all items before saving.');
                return false; // Prevent form submission
            }

            // If all checkboxes are checked and tbody is not empty, proceed with form submission
            $('#form-tambah-uji-fungsi').submit();
        });
    </script>
@endsection
