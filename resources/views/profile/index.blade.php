@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('css/toggle.css') }}">
    <style>
        .mylabel {
            color: #000000;
            font-size: 14pt;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pengaturan Akun</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-12 text-center mb-3">
                                @if (!empty($data->image))
                                    <img alt="image"
                                    src="{{ asset('storage/' . $data->image) }}"
                                    class="rounded-circle mr-1"
                                    style="max-width: 175px; max-width: 175px; min-width: 50px; min-width: 50px;">
                                @else  
                                    <img alt="image"
                                        src="{{ asset('img/avatar.png') }}"
                                        class="rounded-circle mr-1"
                                        style="max-width: 175px; max-width: 175px; min-width: 50px; min-width: 50px;">
                                @endif
                                <form id="form-img" class="mt-4 pt-1">
                                    <button class="btn btn-danger">Hapus Gambar</button>
                                </form>
                            </div>
                            <div class="col-lg-9 col-md-9 col-12 mb-3">
                                <form id="form-akun">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="form-token">
                                    <input type="text" name="username" id="username" hidden value="x">
                                    <div class="form-group row mb-4 d-flex align-item-center justify-content-center">
                                        <label class="mylabel col-form-label text-md-right col-12 col-md-3 col-lg-3 mt-1">Nama Lengkap</label>
                                        <div class="col-sm-12 col-md-9">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="nama lengkap" required value="{{ $data['name'] }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4 d-flex align-item-center justify-content-center">
                                        <label class="mylabel col-form-label text-md-right col-12 col-md-3 col-lg-3 mt-1">Email</label>
                                        <div class="col-sm-12 col-md-9">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="email" required value="{{ $data['email'] }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4 d-flex align-item-center justify-content-center">
                                        <label class="mylabel col-form-label text-md-right col-12 col-md-3 col-lg-3 mt-1">Foto profile</label>
                                        <div class="col-sm-12 col-md-9">
                                            <input type="file" class="form-control" name="foto" id="foto">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4 pt-1">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
                                            <button type="submit" id="btn-update" class="btn btn-primary">Perbarui Data</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-icon icon-left btn-success py-2" data-toggle="modal" data-target="#modal-pass"><i class="fas fa-key"></i> Ganti Password</button>
                        <button class="btn btn-icon icon-left btn-success py-2" data-toggle="modal" data-target="#modal-lupa"><i class="fas fa-unlock-keyhole"></i></i> Fitur Lupa Password</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('profile.modal.reset-pass')
    @include('profile.modal.lupa-pass')
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
