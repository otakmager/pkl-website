<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- <link rel="stylesheet" href="{{ asset('library/bootstrap-5.3/css/bootstrap.min.css') }}"> --}}
    <?= '<style>' . file_get_contents("library/bootstrap-5.3/css/bootstrap.min.css") . '</style>' ?>
    <style>
        * {
            color: #000;
        }
        .my-hr {
            border: 2px solid black;
            opacity: 0.75;
        }
        .hr-ttd {
            border: 0.5px solid black;
            opacity: 0.75;
        }
        table.my-tb, th.my-tb, td.my-tb {
            border: 1px solid black;
            padding: 5px;
            font-size: 8pt;
        }
        td.myinfo {
            font-size: 10.5pt;
        }
        .address{
            font-size: 9pt;
        }
        .namaCV{
            font-size: 14pt;
        }
        .page-break {
            page-break-after: always;
        }
        .table-container {
            float: right;
            padding: 10px;
            margin-left: 20px;
        }

    </style>
    <title>{{ $title }}</title>
</head>
<body>
    @php $saldo = intval($saldoAwal); @endphp
    @foreach ($dataBig as $index => $dataMed)
    @php $totalMasuk = 0; $totalKeluar = 0; $pendapatan = 0; $saldoAkhir = $saldo; $data = json_decode($dataMed, true);@endphp
    @foreach ($data as $item)
        @php
            $totalMasuk += intval($item['nominal_masuk']);
            $totalKeluar += intval($item['nominal_keluar']);
            $pendapatan = $totalMasuk - $totalKeluar;
        @endphp
    @endforeach
    <div id="myPage" style="min-height: 750px">
        <!-- Header Start -->
        <div class="container mt-3" id="my-header">
            <table class="mb-0">
                <tr>
                    <td>
                        <img class="mb-2" src="data:image/png;base64,{{ base64_encode(file_get_contents(base_path('public/img/logo.png'))); }}" width="60" height="40">
                    </td>
                    <td class="text-center">
                        <div class="row"><h2 class="namaCV">CV Berkah Makmur</h2></div>
                        <div class="row"><p class="address">Perum Argokiloso, Gang Bima Sakti Blok A. No. 19 Rt 01/ 06, Ngijo Tasikmadu, Karanganyar</p></div>
                    </td>
                </tr>
            </table>
            <hr class="my-hr mt-0">
        </div>
        <div class="container mt-2">
            <table class="table">
                <tr>
                    <td class="myinfo" style="width: 100px">Laporan Bulan</td>
                    <td class="myinfo" style="width: 15px">&nbsp;:&nbsp;</td>
                    <td class="myinfo">{{ $monthName[$index] }}</td>
                </tr>
                <tr>
                    <td class="myinfo" style="width: 100px">Rentang tanggal</td>
                    <td class="myinfo" style="width: 15px">&nbsp;:&nbsp;</td>
                    <td class="myinfo">{{ $dataStartDate[$index] }} &ndash; {{ $dataEndDate[$index] }}</td>
                </tr>
            </table>
        </div>
        <!-- Header End -->

        <!-- Data Start -->                
        <div class="d-flex align-item-center mt-3 mb-5 mx-5">
            <div class="row">
                <table class="my-tb">
                    <thead>
                        <tr class="text-center">
                            <th class="my-tb" style="width: 15px">No.</th>
                            <th class="my-tb" style="width: 100px">Tanggal</th>
                            <th class="my-tb" style="width: 125px">Nama</th>
                            <th class="my-tb" style="width: 80px">Label</th>
                            <th class="my-tb" style="width: 50px">Nominal Masuk</th>
                            <th class="my-tb" style="width: 50px">Nominal Keluar</th>
                        </tr>
                    </thead>
                    @if (count($dataMed) > 0)                                        
                    <tbody>                          
                        @php $i = 1; @endphp
                        @foreach ($dataMed as $data)
                        <tr>
                            <td class="text-center my-tb">{{ $i++ . "." }}</td>
                            <td class="text-start my-tb">{{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                            <td class="my-tb">{{$data->name}}</td>
                            <td class="text-center my-tb">{{$data->labels_name}}</td>
                            <td class="text-end my-tb">
                                @if ($data->nominal_masuk == 0)
                                    -
                                @else
                                    @currency($data->nominal_masuk)
                                @endif
                            </td>
                            <td class="text-end my-tb">
                                @if ($data->nominal_keluar == 0)
                                    -
                                @else
                                    @currency($data->nominal_keluar)
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @else
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center fw-bold">Tidak Ada Data</td>
                        </tr>
                    </tbody>      
                    @endif
                </table>            
            </div>
        </div>
        <!-- Data End -->

        <!-- Additional Info Start -->
        <div class="container mt-2 d-block" style="page-break-inside: avoid;">
            <h6>Ringkasan Transaksi {{ $dataStartDate[$index] }} &ndash; {{ $dataEndDate[$index] }}</h6>
            <table class="table mt-3">
                <tr>
                    <td class="myinfo" style="width: 140px">Saldo Awal</td>
                    <td class="myinfo" style="width: 15px; border-style:solid">&nbsp;:&nbsp;</td>
                    @if ($saldo >= 0)
                    <td class="myinfo">@currency($saldo)</td>                        
                    @else                        
                    @php $temp = -$saldo; @endphp
                    <td class="myinfo">-@currency($temp)</td>
                    @endif
                </tr>
                <tr>
                    <td class="myinfo" style="width: 140px">Total Pemasukan</td>
                    <td class="myinfo" style="width: 15px; border-style:solid">&nbsp;:&nbsp;</td>
                    <td class="myinfo">@currency($totalMasuk)</td>
                </tr>
                <tr>
                    <td class="myinfo" style="width: 140px">Total Pengeluaran</td>
                    <td class="myinfo" style="width: 15px; border-style:solid">&nbsp;:&nbsp;</td>
                    <td class="myinfo">@currency($totalKeluar)</td>
                </tr>
                <tr>
                    <td class="myinfo" style="width: 140px">Pendapatan Bulan Ini</td>
                    <td class="myinfo" style="width: 15px; border-style:solid">&nbsp;:&nbsp;</td>
                    @if ($pendapatan >= 0)
                    <td class="myinfo">@currency($pendapatan)</td>                        
                    @else                        
                    @php $temp = -$pendapatan; @endphp
                    <td class="myinfo">-@currency($temp)</td>
                    @endif
                </tr>
                @php                    
                    $saldo = $saldo + $pendapatan;
                    $saldoAkhir = $saldoAkhir + $pendapatan;
                @endphp
                <tr>
                    <td class="myinfo" style="width: 140px">Saldo Akhir</td>
                    <td class="myinfo" style="width: 15px; border-style:solid">&nbsp;:&nbsp;</td>
                    @if ($saldoAkhir >= 0)
                    <td class="myinfo">@currency($saldoAkhir)</td>                        
                    @else                        
                    @php $temp = -$saldoAkhir; @endphp
                    <td class="myinfo">-@currency($temp)</td>
                    @endif
                </tr>
            </table>            

            <!-- Tanda Tangan Start -->        
            <div class="container mt-5" style="page-break-inside: avoid;">
                <div class="table-container">
                    <table class="table">
                        <tr>
                            <td class="myinfo">Karanganyar, {{ $thisDate }}</td>
                        </tr>
                        <tr>
                            <td class="myinfo">Mengetahui</td>
                        </tr>
                        <tr>
                            <td class="myinfo" style="height: 75px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="myinfo">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="myinfo"><hr class="hr-ttd mt-0 mb-0"></td>
                        </tr>
                        <tr>
                            <td class="myinfo">Pimpinan CV Berkah Makmur</td>
                        </tr>
                    </table>
                </div> 
            </div>
            <!-- Tanda Tangan End -->
        </div>
        <!-- Additional Info End -->
    </div>

    <!-- Page Break Start -->
    @if ($index !== (count($dataBig)-1))
    <div id="breakPage" class="page-break"></div>
    @endif
    @endforeach
    <!-- Page Break End -->
</body>
</html>
