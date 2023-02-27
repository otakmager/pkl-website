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
                <h1>Download</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Download Laporan Keuangan</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama File</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="name" id="name" value="laporan-keuangan" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis File</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select class="form-control selectric" name="format-file" id="format-file">
                                            <option value="Excel">Excel</option>
                                            <option value="pdf">PDF</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bentuk Laporan</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select class="form-control selectric" name="format-laporan" id="format-laporan">
                                            <option value="semua">Semua Transaksi</option>
                                            <option value="tmasuk">Transaksi Masuk</option>
                                            <option value="tkeluar">Transaksi Keluar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Label Transaksi</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select class="form-control mx-1" name="multiselect[]" multiple="multiple" id="label">
                                            <option value="reparasi">Reparasi</option>
                                            <option value="jualan">Jualan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rentang Tanggal</label>
                                    <div class="input-group col-sm-12 col-md-7">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control daterange-cus" name="tanggal" id="tanggal">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button class="btn btn-primary">Download</button>
                                    </div>
                                </div>
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

    <!-- Page Specific JS File -->
    <script src="{{ 'js/dashboard/download.js' }}"></script>
@endpush
