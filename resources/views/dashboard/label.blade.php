@extends('layouts.app')

@section('title', 'Label Transaksi')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Label Transaksi</h1>
            </div>
            <div class="section-body">
                <a href="#" class="btn btn-icon icon-left btn-success py-2"><i class="fas fa-plus"></i> Tambah Label Transaksi</a>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tabel Label Transaksi</h4>
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
                                            <th>Jenis Transaksi</th>
                                            <th>Aksi</th>
                                        </tr>
                                        @foreach ($labels as $label)            
                                        <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $label->name }}</td>
                                        <td>@if ($label->jenis)
                                                Transaksi Keluar
                                            @else
                                                Transaksi Masuk
                                            @endif
                                        </td>
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
