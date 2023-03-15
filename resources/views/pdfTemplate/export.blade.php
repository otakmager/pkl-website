<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('library/bootstrap-5.3/css/bootstrap.min.css') }}">
    <style>
        .my-hr {
            border: 2px solid black;
            opacity: 0.75;
        }
        table.my-tb, th.my-tb, td.my-tb {
            border: 1px solid black;
            padding: 10px;
        }
    </style>
    <title>{{ $title }}</title>
</head>
<body>
    <!-- Header Start -->
    <div class="container mt-3" id="my-header">
        <div class="row text-center align-items-center justify-content-center">
            <div class="col-1 align-items-center">
                <img src="{{ asset('img/logo.png') }}" width="110" height="50">
            </div>
            <div class="col-9">
                <div class="row"><h2>CV Berkah Makmur</h2></div>
                <div class="row"><p>Perum Argokiloso, Gang Bima Sakti Blok A. No. 19 Rt 01/ 06, Ngijo Tasikmadu, Karanganyar</p></div>
            </div>
        </div>
        <hr class="my-hr">
    </div>
    <div class="container mt-2">
        <table>
            <tr>
                <td>Bulan</td>
                <td>&nbsp;:&nbsp;</td>
                <td>Januari</td>
            </tr>
            <tr>
                <td>Rentang tanggal</td>
                <td>&nbsp;:&nbsp;</td>
                <td>1 Januari 2023 - 31 Januari 2023</td>
            </tr>
        </table>
    </div>
    <!-- Header End -->

    <!-- Data Start -->
    <div class="container mt-3 mb-5">
        <div class="row align-items-center">
            <table class="my-tb">
                <thead>
                    <tr class="text-center">
                        <th class="my-tb" style="width: 50px">No.</th>
                        <th class="my-tb" style="width: 230px">Tanggal</th>
                        <th class="my-tb" style="width: 400px">Nama</th>
                        <th class="my-tb" style="width: 200px">Label</th>
                        <th class="my-tb" style="width: 200px">Nominal Masuk</th>
                        <th class="my-tb" style="width: 200px">Nominal Keluar</th>
                    </tr>
                </thead>                                        
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($datas as $data)
                    <tr>
                        <td class="text-center my-tb">{{ $i++ . "." }}</td>
                        <td class="text-start my-tb">{{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                        <td class="my-tb">{{$data->name}}</td>
                        <td class="text-center my-tb">{{$data->label_id}}</td>
                        <td class="text-end my-tb">@currency($data->nominal)</td>
                        <td class="text-end my-tb">@currency($data->nominal)</td>
                    </tr>
                    @endforeach
                </tbody>      
            </table>            
        </div>
    </div>
    <!-- Data End -->

    <!-- Script Start -->    
    <script src="{{ asset('library/bootstrap-5.3/js/bootstrap.min.js') }}"></script>
    <!-- Script End -->
</body>
</html>
