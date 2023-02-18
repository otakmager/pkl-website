@extends('layouts.app')

@section('title', 'Label Transaksi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-multiselect/css/bootstrap-multiselect.min.css') }}"/>
@endpush


@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Label Transaksi</h1>
            </div>
            <div class="section-body">
                <button class="btn btn-icon icon-left btn-success py-2" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> Tambah Label Transaksi</button>
                
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenCommon">
                            <div class="card-header">
                                <h4>Tabel Label Transaksi</h4>
                                <div class="card-header-form">
                                    <form>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Search" id="search" name="search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="custom-control selectgroup align-items-center">
                                    <label for="max_data" class="mt-2">Show: </label>
                                    <select class="form-control mx-1 " id="max_data" name="max_data" style="max-width: 75px" >
                                        <option value="5" selected>5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <label class="mt-2" for="p"> entries</label>
                                </div>
                            </div>
                            <div class="row px-3 mb-2">
                                <div class="custom-control selectgroup col-lg-5 col-md-8 col-12 mr-2">
                                    <label class="mt-2 mr-1" for="label">Jenis Transaksi: </label>
                                    <div class="example-optionClass-container">
                                        <select id="jenis" class="form-control mx-1" name="multiselect[]" multiple="multiple">
                                            <option value="0">Transaksi Masuk</option>
                                            <option value="1">Transaksi Keluar</option>
                                        </select>
                                    </div>        
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive mydata">
                                    <table class="table-striped table">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No.</th>
                                                <th class="label_sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">Nama</th>
                                                <th class="label_sorting" data-sorting_type="asc" data-column_name="jenis" style="cursor: pointer">Jenis</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>                                        
                                        <tbody id="table-data">@include('dashboard.fetch.label-data')</tbody>      
                                    </table>
                                </div>
                                <form>
                                    <input type="hidden" name="hiden_page" id="hidden_page" value="1">
                                    <input type="hidden" name="hiden_column_name" id="hidden_column_name" value="created_at">
                                    <input type="hidden" name="hiden_sort_type" id="hidden_sort_type" value="desc">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('dashboard.modal.add-label')
        @include('dashboard.modal.edit-label')
        @include('dashboard.modal.del-label')
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/bootstrap-multiselect/js/bootstrap-multiselect.min.js') }}"></script> 
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/dashboard/label.js') }}"></script>
@endpush
