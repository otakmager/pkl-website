@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="{{ asset('css/toggle.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        {{-- Button Visibility & Set Dana Awal --}}
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 id="txt-visible">Sembunyikan Data</h4>
                        <div class="card-header-action">
                            <label class="switch">
                                <input type="checkbox" id="btn-visible"/>
                                <span class="slider round"></span>
                              </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Atur Dana Awal</h4>
                        <div class="card-header-action">
                            <button class="btn btn-icon icon-left btn-primary py-2" 
                            data-toggle="modal" data-target="#editModal" id="editDana">
                            <i class="fas fa-edit"></i> Ubah Dana Awal</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Info Hari Ini --}}
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-money-bill-trend-up"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 class="harian">Uang Masuk Hari Ini</h4>
                        </div>
                        <div class="card-body info-hidden" id="masukHari">
                            Rp x.xxx.xxx,00
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-basket-shopping"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 class="harian">Uang Keluar Hari Ini</h4>
                        </div>
                        <div class="card-body info-hidden" id="keluarHari">
                            Rp x.xxx.xxx,00
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4 class="harian">Sisa Uang</h4>
                        </div>
                        <div class="card-body info-hidden" id="sisaUang">
                            Rp x.xxx.xxx,00
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Responsive --}}
        <div class="row">
            {{-- Bagian Kiri --}}
            <div class="col-lg-8 col-md-8 col-12">
                {{-- Info 1 Tahunan --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Pemasukan vs Pengeluaran 1 Tahun Terakhir</h4>
                        <div class="card-header-action">
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart-tahunan"
                            height="158"></canvas>
                    </div>
                </div>
                {{-- Info 4 Week --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Pemasukan vs Pengeluaran 4 Minggu Terakhir</h4>
                        <div class="card-header-action">
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart-4Week"
                            height="158"></canvas>
                    </div>
                </div>
                {{-- Info 1 Mingguan --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Pemasukan vs Pengeluaran 1 Minggu Terakhir</h4>
                        <div class="card-header-action">
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart-Seminggu"
                            height="158"></canvas>
                    </div>
                </div>
            </div>
            {{-- Bagian Kanan --}}
            <div class="col-lg-4 col-md-4 col-12">
                {{-- Pie Chart --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Pie Chart</h4>            
                        <div class="card-header-action">
                            <div class="btn-group">
                                <button type="button"
                                    class="btn btn-primary" id="btnChartTahun">Tahun</button>
                                <button type="button"
                                    class="btn btn-light" id="btnChartBulan">Bulan</button>
                                <button type="button"
                                    class="btn btn-light" id="btnChartMinggu">Minggu</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart-pie"></canvas>
                    </div>
                </div>
                {{-- Top 5 Label Pemasukan --}}
                <div class="card gradient-bottom">
                    <div class="card-header">
                        <h4>Top 5 Label Pemasukan</h4><br>
                        <div class="card-header-action dropdown">
                            <a href="#"
                                id="chooseLabelMasuk"
                                data-toggle="dropdown"
                                class="btn btn-danger dropdown-toggle">Bulan Ini</a>
                            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <li class="dropdown-title">Pilih Periode</li>
                                <li><a href="javascript:{}" id="msk-bln-ini"
                                        class="dropdown-item lb-masuk active">Bulan Ini</a></li>
                                <li><a href="javascript:{}" id="msk-bln-kemarin"
                                        class="dropdown-item lb-masuk">Bulan Kemarin</a></li>
                                <li><a href="javascript:{}" id="msk-thn-ini"
                                        class="dropdown-item lb-masuk">Tahun Ini</a></li>
                                <li><a href="javascript:{}" id="msk-thn-kemarin"
                                        class="dropdown-item lb-masuk">Tahun Kemarin</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body"
                        id="top-5-scroll-masuk">
                        <ul class="list-unstyled list-unstyled-border" id="ul-masuk">
                            <li class="media">
                                <img class="mr-3 rounded"
                                    width="55"
                                    src="{{ asset('img/label/1.png') }}"
                                    alt="product">
                                <div class="media-body">
                                    <div class="media-title">Name Label</div>
                                    <div class="mt-1">
                                        <div class="budget-price-label info-hidden">Rpxxx.xxx</div>
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded"
                                    width="55"
                                    src="{{ asset('img/label/2.png') }}"
                                    alt="product">
                                <div class="media-body">
                                    <div class="media-title">Name Label</div>
                                    <div class="mt-1">
                                        <div class="budget-price-label info-hidden">Rpxxx.xxx</div>
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded"
                                    width="55"
                                    src="{{ asset('img/label/3.png') }}"
                                    alt="product">
                                <div class="media-body">
                                    <div class="media-title">Name Label</div>
                                    <div class="mt-1">
                                        <div class="budget-price-label info-hidden">Rpxxx.xxx</div>
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded"
                                    width="55"
                                    src="{{ asset('img/label/4.png') }}"
                                    alt="product">
                                <div class="media-body">
                                    <div class="media-title">Name Label</div>
                                    <div class="mt-1">
                                        <div class="budget-price-label info-hidden">Rpxxx.xxx</div>
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded"
                                    width="55"
                                    src="{{ asset('img/label/5.png') }}"
                                    alt="product">
                                <div class="media-body">
                                    <div class="media-title">Name Label</div>
                                    <div class="mt-1">
                                        <div class="budget-price-label info-hidden">Rpxxx.xxx</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer d-flex justify-content-center pt-3">
                        <div class="budget-price justify-content-center">
                            <div class="budget-price-square bg-primary"
                                data-width="20"></div>
                            <div class="budget-price-label">Top 5 Label Pemasukan</div>
                        </div>
                    </div>
                </div>
                {{-- Top 5 Label Pengeluaran --}}
                <div class="card gradient-bottom">
                    <div class="card-header">
                        <h4>Top 5 Label Pengeluaran</h4><br>
                        <div class="card-header-action dropdown">
                            <a href="#"
                                id="chooseLabelKeluar"
                                data-toggle="dropdown"
                                class="btn btn-danger dropdown-toggle">Bulan Ini</a>
                            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <li class="dropdown-title">Pilih Periode</li>
                                <li><a href="javascript:{}" id="msk-bln-ini"
                                        class="dropdown-item lb-keluar active">Bulan Ini</a></li>
                                <li><a href="javascript:{}" id="msk-bln-kemarin"
                                        class="dropdown-item lb-keluar">Bulan Kemarin</a></li>
                                <li><a href="javascript:{}" id="msk-thn-ini"
                                        class="dropdown-item lb-keluar">Tahun Ini</a></li>
                                <li><a href="javascript:{}" id="msk-thn-kemarin"
                                        class="dropdown-item lb-keluar">Tahun Kemarin</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body"
                        id="top-5-scroll-keluar">
                        <ul class="list-unstyled list-unstyled-border" id="ul-keluar">
                            <li class="media">
                                <img class="mr-3 rounded"
                                    width="55"
                                    src="{{ asset('img/label/1.png') }}"
                                    alt="product">
                                <div class="media-body">
                                    <div class="media-title">Name Label</div>
                                    <div class="mt-1">
                                        <div class="budget-price-label info-hidden">Rpxxx.xxx</div>
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded"
                                    width="55"
                                    src="{{ asset('img/label/2.png') }}"
                                    alt="product">
                                <div class="media-body">
                                    <div class="media-title">Name Label</div>
                                    <div class="mt-1">
                                        <div class="budget-price-label info-hidden">Rpxxx.xxx</div>
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded"
                                    width="55"
                                    src="{{ asset('img/label/3.png') }}"
                                    alt="product">
                                <div class="media-body">
                                    <div class="media-title">Name Label</div>
                                    <div class="mt-1">
                                        <div class="budget-price-label info-hidden">Rpxxx.xxx</div>
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded"
                                    width="55"
                                    src="{{ asset('img/label/4.png') }}"
                                    alt="product">
                                <div class="media-body">
                                    <div class="media-title">Name Label</div>
                                    <div class="mt-1">
                                        <div class="budget-price-label info-hidden">Rpxxx.xxx</div>
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <img class="mr-3 rounded"
                                    width="55"
                                    src="{{ asset('img/label/5.png') }}"
                                    alt="product">
                                <div class="media-body">
                                    <div class="media-title">Name Label</div>
                                    <div class="mt-1">
                                        <div class="budget-price-label info-hidden">Rpxxx.xxx</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer d-flex justify-content-center pt-3">
                        <div class="budget-price justify-content-center">
                            <div class="budget-price-square bg-danger"
                                data-width="20"></div>
                            <div class="budget-price-label">Top 5 Label Pengeluaran</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@include('dashboard.modal.edit-dana')
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/dashboard/dashboard-admin.js') }}"></script>
@endpush
