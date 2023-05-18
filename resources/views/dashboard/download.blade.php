@extends('layouts.app')

@section('title', 'Download')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-multiselect/css/bootstrap-multiselect.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Laporan</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenCommon">
                            <div class="card-header">
                                <h4>Download Laporan Keuangan</h4>
                            </div>
                            <div class="card-body">
                                <form method="get" name="download-form" id="download-form">
                                    <!-- Name start -->
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama File</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control" name="name" id="name" value="laporan-keuangan" autofocus required>
                                        </div>
                                    </div>
                                    <!-- Name End -->
                                    <!-- Jenis Start -->
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis File</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="jenis" id="jenis" required>
                                                <option value="excel" selected>Excel</option>
                                                <option value="pdf">PDF</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Jenis End -->
                                    <!-- Format Start -->
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bentuk Laporan</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="format-laporan" id="format-laporan" required>
                                                <option value="semua" selected>Semua Transaksi</option>
                                                <option value="tmasuk">Transaksi Masuk</option>
                                                <option value="tkeluar">Transaksi Keluar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Format End -->
                                    <!-- Label start -->
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Label Transaksi</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control mx-1" name="multiselect[]" multiple="multiple" id="label">
                                                @foreach ($labels as $label)
                                                <option value="{{ $label->id }}">{{ $label->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Label End -->
                                    <!-- Date Start -->
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rentang Tanggal</label>
                                        <div class="input-group col-sm-12 col-md-7">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control daterange-cus" name="tanggal" id="tanggal" required>
                                        </div>
                                    </div>
                                    <!-- Date End -->
                                    <!-- Button Start -->
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button type="submit" id="btn-download" class="btn btn-success">Download Excel</button>
                                        </div>
                                    </div>
                                    <!-- Button End -->
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/bootstrap-multiselect/js/bootstrap-multiselect.min.js') }}"></script>    
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <!-- Option Label with get JSON from controller -->
    <script>
        $('#format-laporan').on('change', function() {
        var formatLaporan = $(this).val();
        var labels = {!! json_encode($labels) !!};
        var labelsMsk = {!! json_encode($labelsMsk) !!};
        var labelsKlr = {!! json_encode($labelsKlr) !!};
        var selectLabel = $('#label');
        
        // Hapus semua option pada select #label
        selectLabel.empty();
        
        // Tambahkan option pada select #label sesuai dengan pilihan select #format-laporan
        if (formatLaporan == 'semua') {
            $.each(labels, function(i, label) {
                selectLabel.append('<option value="' + label.id + '">' + label.name + '</option>');
            });
        } else if (formatLaporan == 'tmasuk') {
            $.each(labelsMsk, function(i, label) {
                selectLabel.append('<option value="' + label.id + '">' + label.name + '</option>');
            });
        } else if (formatLaporan == 'tkeluar') {
            $.each(labelsKlr, function(i, label) {
                selectLabel.append('<option value="' + label.id + '">' + label.name + '</option>');
            });
        }
        
        // Refresh select #label dengan plugin multiselect
        selectLabel.multiselect('rebuild');

        // Auto Select All Option        
        $("#label").multiselect("selectAll", false);
        $("#label").multiselect("updateButtonText");
    });
    </script>

    <!-- Page Specific JS File -->
    <script src="{{ 'js/dashboard/download.js' }}"></script>
@endpush
