@extends('layouts.app')

@section('title', 'Manajemen Akun')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manajemen Akun</h1>
            </div>
            <div class="section-body">
                <a href="#" class="btn btn-icon icon-left btn-success py-2"><i class="fas fa-plus"></i> Tambah Akun</a>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tabel Akun</h4>
                                <div class="card-header-form">
                                    <form>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr class="text-center">
                                            <th>No. </th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                        @foreach ($users as $user)            
                                        <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->level === 'pimpinan')
                                                Aktif
                                            @else
                                            <select name="status" id="status" class="form-control text-center">
                                                <option value="0" @if ($user->status === 0) selected @endif>Non Aktif</option>
                                                <option value="1" @if ($user->status === 1) selected @endif>Aktif</option>
                                            </select>
                                            @endif
                                        </td>
                                        <td class="text-center">      
                                            @if ($user->level === 'pimpinan')
                                            <a href="#" class="btn btn-icon icon-left btn-warning btn-sm"><i class="fas fa-screwdriver-wrench"></i> Pengaturan Akun</a>
                                            @else
                                            <a href="#" class="btn btn-icon icon-left btn-warning btn-sm"><i class="fas fa-key"></i> Reset Password</a>
                                            <form action="#" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-icon icon-left btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Hapus</button>
                                            </form>
                                            @endif   
                                        </td>
                                        </tr>
                                        @endforeach                                       
                                    </table>
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

    <!-- Page Specific JS File -->
@endpush
