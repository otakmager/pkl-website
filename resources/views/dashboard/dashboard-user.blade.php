@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <h3 style="color: #1a1c2b">Hi, Selamat Datang Dimas!</h3>
                        <p class="mt-3 text-justify" style="color:#111111">Di aplikasi ini, Anda dapat menginputkan 
                            <a href="{{ url('tmasuk') }}">transaksi masuk</a> dan <a href="{{ url('tkeluar') }}">transaksi keluar</a> 
                            sesuai format formulir yang disediakan. Jika Anda tidak sengaja atau ingin memulihkan data yang dihapus, 
                            Anda dapat pergi ke menu <a href="{{ url('sampah') }}">Sampah</a> 
                            selama data tersebut belum 14 hari sejak dihapus.</p>
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
