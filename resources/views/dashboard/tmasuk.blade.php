@extends('layouts.app')

@section('title', 'Transaksi Masuk')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-multiselect/css/bootstrap-multiselect.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush


@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Transaksi Masuk</h1>
            </div>
            <div class="section-body">
                <button class="btn btn-icon icon-left btn-success py-2" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> Tambah Transaksi Masuk</button>
                
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenCommon">
                            <div class="card-header">
                                <h4>Tabel Transaksi Masuk</h4>
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
                            <div class="row px-3">
                                <div class="custom-control selectgroup col-lg-2 col-md-8 col-12 mr-2">
                                    <label class="mt-2 mr-1" for="label">Label: </label>
                                    <div class="example-optionClass-container">
                                        <select id="label" class="form-control mx-1" name="multiselect[]" multiple="multiple">
                                            @foreach ($labels as $label)
                                            <option value="{{ $label->id }}">{{ $label->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>        
                                </div>                                
                                <div class="form-group col-lg-2 col-md-8 col-12 mt-2 mr-1" id="div_toggle">
                                    <label class="custom-switch">
                                        <input type="checkbox"
                                            name="custom-switch-checkbox"
                                            class="custom-switch-input" id="date_toggle">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Date filter</span>
                                    </label>  
                                </div>     
                                <div class="form-group col-lg-4 col-md-8 col-12 ml-0" style="min-width: 300px; max-width:400px; display:none" id="div_date">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text"
                                            class="form-control daterange-cus" id="date_filter">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive mydata">
                                    <table class="table-striped table">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No.</th>
                                                <th class="tmasuk_sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">Nama</th>
                                                <th class="tmasuk_sorting" data-sorting_type="asc" data-column_name="label_id" style="cursor: pointer">Label</th>
                                                <th class="tmasuk_sorting" data-sorting_type="asc" data-column_name="nominal" style="cursor: pointer">Nominal</th>
                                                <th class="tmasuk_sorting" data-sorting_type="asc" data-column_name="tanggal" style="cursor: pointer">Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>                                        
                                        <tbody id="table-data">@include('dashboard.fetch.tmasuk-data')</tbody>      
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
        @include('dashboard.modal.add-tmasuk')
        @include('dashboard.modal.edit-tmasuk')
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/bootstrap-multiselect/js/bootstrap-multiselect.min.js') }}"></script>    
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/dashboard/tmasuk.js') }}"></script>
@endpush
