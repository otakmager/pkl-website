@extends('layouts.app')

@section('title', 'Transaksi Keluar')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Transaksi Keluar</h1>
            </div>
            <div class="section-body">
                <a href="#" class="btn btn-icon icon-left btn-success py-2"><i class="fas fa-plus"></i> Tambah Transaksi Keluar</a>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tabel Transaksi Keluar</h4>
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
                                            <th>Label</th>
                                            <th>Nominal</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                        @foreach ($tkeluars as $tkeluar)            
                                        <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $tkeluar->name }}</td>
                                        <td>{{ $tkeluar->label }}</td>
                                        <td>{{ $tkeluar->nominal }}</td>
                                        <td>{{ $tkeluar->tanggal }}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Edit</a>
                                            <form action="#" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-icon icon-left btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Hapus</button>
                                            </form>
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
