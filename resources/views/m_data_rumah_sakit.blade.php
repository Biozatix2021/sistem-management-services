@extends('layouts.main')

@section('content-header')
    <section class="content-header">
        <h1>
            Master Data Rumah Sakit

        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Data Rumah Sakit</a></li>
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

            <div class="modal fade" id="tambah-data-rumah-sakit" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form-tambah-rumah-sakit" name="form-tambah-rumah-sakit" class="form-horizontal">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputNamaRumahSakit" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputNamaRumahSakit">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputTipeAlat" class="col-sm-2 col-form-label">Latitude</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="latitude">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputTipeAlat" class="col-sm-2 col-form-label">Longitude</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="longitude">
                                    </div>
                                </div>
                                <div id="map"></div>
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
                <table id="tabelRumahSakit" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Nama</th>
                            <th>Lokasi</th>
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

        table = $('#tabelRumahSakit').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                text: '<ion-icon name="add-outline"></ion-icon> Tambah Data',
                className: 'btn btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    $('#form-tambah-rumah-sakit')[0].reset();
                    showMap();
                }
            }],
            ajax: "{{ route('rumah-sakit.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'lokasi',
                    name: 'lokasi'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // function save_data() {
        //     $.ajax({
        //         data: $('#form-tambah-alat').serialize(),
        //         url: "{{ route('rumah-sakit.store') }}",
        //         type: "POST",
        //         dataType: 'json',
        //         success: function(data) {
        //             $('#form-tambah-alat').trigger("reset");
        //             $('#tambah-data-rumah-sakit').modal('hide');
        //             // reset map 
        //             // Clear all layers
        //             table.draw();
        //         },
        //         error: function(data) {
        //             console.log('Error:', data);
        //         }
        //     });
        // }

        function deleteData(id) {
            var popup = confirm("Apakah anda yakin ingin menghapus data ini?");
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            if (popup == true) {
                $.ajax({
                    url: "rumah-sakit/destroy/" + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token,
                    },
                    success: function(data) {
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }
        }

        function editData(id) {
            $.get('rumah-sakit/edit/' + id, function(data) {
                $('#tambah-data-rumah-sakit').modal('show');
                $('#staticBackdropLabel').html("Edit Data Rumah Sakit");
                $('#tombol-tambah-form').html("Update");
                $('#form-tambah-alat').attr('action', 'rumah-sakit/update/' + data.id);
                $('#inputNamaRumahSakit').val(data.nama);
                $('#inputTipeAlat').val(data.lokasi);
            })
        }

        function showMap() {
            $('#tambah-data-rumah-sakit').modal('show');

            // load maps
            setTimeout(() => {
                const providerOSM = new GeoSearch.OpenStreetMapProvider();

                //leaflet map
                var leafletMap = L.map('map', {
                    fullscreenControl: true,
                    // OR
                    fullscreenControl: {
                        pseudoFullscreen: false // if true, fullscreen to page width and height
                    },
                    minZoom: 6,
                }).setView(['-6.171918908161', '106.95295035839'], 5);

                L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(leafletMap);

                let theMarker = {};

                leafletMap.on('click', function(e) {
                    // clear search 
                    $('#search').val('');

                    // get lat and lng from click event
                    let lat = e.latlng.lat;
                    let lng = e.latlng.lng;

                    // if the marker is there, remove it
                    leafletMap.removeLayer(theMarker);

                    // add a marker to the map
                    theMarker = L.marker([lat, lng]).addTo(leafletMap);

                    // set the value of the input field
                    $('#latitude').val(lat);
                    $('#longitude').val(lng);

                    // get center of map
                    leafletMap.panTo(new L.LatLng(lat, lng));

                    // set view of map
                    leafletMap.setView([lat, lng], 18);
                });

                const search = new GeoSearch.GeoSearchControl({
                    provider: providerOSM,
                    style: 'bar',
                    searchLabel: 'search',
                });

                leafletMap.addControl(search);

            }, 500);
        }

        function resetMap() {
            // Clear all layers
            map.eachLayer(function(layer) {
                if (layer instanceof L.TileLayer) {
                    // Keep the tile layer
                    return;
                }
                map.removeLayer(layer);
            });

            // Reset the map view to the initial position
            map.setView([37.8, -96], 4); // Replace with your initial coordinates and zoom level
            window.alert('Map has been reset');
        }

        function save_data() {
            var id = $('#id').val();
            var nama = $('#inputNamaRumahSakit').val();
            var latitude = $('#latitude').val();
            var longitude = $('#longitude').val();

            $.ajax({
                url: "{{ route('rumah-sakit.store') }}",
                type: "POST",
                data: {
                    id: id,
                    nama: nama,
                    latitude: latitude,
                    longitude: longitude
                },
                success: function(data) {
                    $('#form-tambah-rumah-sakit').trigger("reset");
                    $('#tambah-data-rumah-sakit').modal('hide');
                    table.draw();
                    toastr.success('Data berhasil disimpan');
                    resetMap();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }
    </script>
@endsection
