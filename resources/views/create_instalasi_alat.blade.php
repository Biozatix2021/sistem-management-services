@extends('layouts.main')

@section('title', 'Instalasi Alat')

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
            <form id="instalasiAlat">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6 mb-5">
                        <label for="nama_alat">Nama Alat</label>
                        <input type="text" class="form-control" id="nama_alat" name="nama_alat" placeholder="Nama Alat">
                    </div>
                    <div class="col-md-6">
                        <label for="sn">SN</label>
                        <input type="text" class="form-control" id="sn" name="sn" placeholder="SN">
                    </div>
                </div>
                <div class="form-group">
                    <label for="status_instalasi">Status Instalasi</label>
                    <input type="text" class="form-control" id="status_instalasi" name="status_instalasi" placeholder="Status Instalasi">
                </div>
                <div class="form-group">
                    <label for="teknisi">Teknisi</label>
                    <input type="text" class="form-control" id="teknisi" name="teknisi" placeholder="Teknisi">
                </div>
                <div class="form-group">
                    <label for="lokasi">Lokasi Instalasi</label>
                    <select name="lokasiInstalasi" id="lokasiInstalasi" class="form-control" style="border-top-left-radius: 7px; border-bottom-left-radius: 7px;">
                        <option value="">Pilih Lokasi Instalasi</option>
                        @foreach ($rumah_sakits as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="perusahaan">Instansi</label>
                    <select name="perusahaan" id="perusahaan" class="form-control">
                        <option value="">Pilih Instansi</option>
                        @foreach ($perusahaans as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>
@endsection
