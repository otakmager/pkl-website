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
        table.my-tb, th.my-tb, td.my-tb {
            border: 1px solid black;
            padding: 10px;
            font-size: 8pt;
        }
        td.myinfo {
            font-size: 11pt;
        }
        .address{
            font-size: 8pt;
        }
        .namaCV{
            font-size: 14pt;
        }
        @media print {
            .table-responsive {
                overflow-x: auto !important;
                min-height: 0 !important;
            }
            .table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 1rem;
                background-color: transparent;
            }
            .table td,
            .table th {
                padding: 0.75rem;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
            }
            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #dee2e6;
            }
        }

    </style>
    <title>{{ $title }}</title>
</head>
<body>
    @foreach ($dataBig as $index => $dataMed)
    <div class="myPage" style="min-height: 750px">
        <!-- Header Start -->
        <div class="container mt-3" id="my-header">
            <div class="row">
                <div class="col-3">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(base_path('public/img/logo.png'))); }}" width="50" height="30">
                </div>
                <div class="col-9">
                    <div class="row"><h2 class="namaCV">CV Berkah Makmur</h2></div>
                    <div class="row"><p class="address">Perum Argokiloso, Gang Bima Sakti Blok A. No. 19 Rt 01/ 06, Ngijo Tasikmadu, Karanganyar</p></div>
                </div>
            </div>
            <hr class="my-hr">
        </div>
        <div class="container mt-2">
            <table class="table">
                <tr>
                    <td class="myinfo">Laporan Bulan</td>
                    <td class="myinfo">&nbsp;:&nbsp;</td>
                    <td class="myinfo">{{ $monthName[$index] }}</td>
                </tr>
                <tr>
                    <td class="myinfo">Rentang tanggal</td>
                    <td class="myinfo">&nbsp;:&nbsp;</td>
                    <td class="myinfo">{{ $dataStartDate[$index] }} &ndash; {{ $dataEndDate[$index] }}</td>
                </tr>
            </table>
        </div>
        <!-- Header End -->

        <!-- Data Start -->
        <div class="container mt-3 mb-5">
            <div class="row align-items-center mx-auto">
                <table class="my-tb">
                    <thead>
                        <tr class="text-center">
                            <th class="my-tb" style="max-width: 50px">No.</th>
                            <th class="my-tb" style="max-width: 240px; min-width: 110px">Tanggal</th>
                            <th class="my-tb" style="max-width: 400px">Nama</th>
                            <th class="my-tb" style="max-width: 200px">Label</th>
                            <th class="my-tb" style="max-width: 200px">Nominal Masuk</th>
                            <th class="my-tb" style="max-width: 200px">Nominal Keluar</th>
                        </tr>
                    </thead>                                        
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
                </table>            
            </div>
        </div>
        <!-- Data End -->
    </div>
    @endforeach

    <!-- Script Start -->    
    <script src="{{ asset('library/bootstrap-5.3/js/bootstrap.min.js') }}"></script>
    <!-- Script End -->
</body>
</html>
