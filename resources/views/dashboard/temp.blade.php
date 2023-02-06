@extends('layouts.app')

@section('title', 'Transaksi Masuk')
<meta name="csrf-token" content="{{ csrf_token() }}">

@push('style')
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}"> --}}
    {{-- @livewireStyles() --}}
    {{-- <link rel="stylesheet" href="{{ asset('library/bootstrap-multiselect/css/bootstrap-multiselect.min.css') }}"/> --}}
    {{-- <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/> --}}
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    {{-- <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
@endpush

@push('scripts')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Transaksi Masuk</h1>
            </div>
            <div class="section-body">
                <a href="#" class="btn btn-icon icon-left btn-success py-2"><i class="fas fa-plus"></i> Tambah Transaksi Masuk</a>

                <div class="row mt-3">
                    <div class="col-12">
                        
                        {{-- @livewire('cari-tmasuk') --}}
                        {{-- @stack('scripts') --}}

                        {{-- Start Main Card --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Tabel Transaksi Masuk</h4>
                                <div class="card-header-form">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search"
                                            id="q" name="q">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>      
                            </div>
                            <div class="form-group mb-2">
                                <div class="custom-control selectgroup align-items-center">
                                    <label for="p" class="mt-2">Show: </label>
                                    <select class="form-control mx-1 " id="p" name="p" style="max-width: 75px" >
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <label class="mt-2" for="p"> entries: </label>
                                </div>
                                <div class="custom-control selectgroup align-items-center">
                                    <label class="mt-2" for="label">Label: </label>
                                    <div class="example-optionClass-container">
                                        <select id="label" class="form-control mx-1" name="multiselect[]" multiple="multiple">
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                            <option value="3">Option 3</option>
                                            <option value="4">Option 4</option>
                                            <option value="5">Option 5</option>
                                            <option value="6">Option 6</option>
                                        </select>
                                    </div>            
                                </div>
                            </div>
                            
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="tabel-tmasuk" >
                                        <thead>
                                            <tr class="text-center">
                                                <th>No. </th>
                                                <th>Nama</th>
                                                <th>Label</th>
                                                <th>Nominal</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>                                        
                                           
                                        {{-- <tbody id="table-content">
                                            @foreach ($tmasuks as $tmasuk)            
                                            <tr class="text-center">
                                            <td>{{ $tmasuks->firstItem() + $loop->index }}</td>
                                            <td>{{ $tmasuk->name }}</td>
                                            <td>{{ $tmasuk->label }}</td>
                                            <td>@currency($tmasuk->nominal)</td>
                                            <td>{{ date('d/m/Y', strtotime($tmasuk->tanggal)) }}</td>
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
                                        </tbody>                                   --}}
                                    </table>
                                </div>
                                {{-- <div id="pagination-container" class="mt-3 mx-4">{{ $tmasuks->links() }}</div> --}}
                            </div>
                        </div>
                        
                        {{-- End Main Card --}}
                        

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('library/bootstrap-multiselect/js/bootstrap-multiselect.min.js') }}"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}

    <!-- Page Specific JS File -->
    {{-- <script src="{{ 'js/dashboard/tmasuk.js' }}"></script> --}}
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module']) }} --}}
    {{-- @livewireScripts() --}}
    {{-- <script type="text/javascript">
        $(function () {
          
          var table = $('#tabel-tmasuk').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{!! route('tmasuk.index') !!}",
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                  {data: 'name', name: 'name'},
                  {data: 'label', name: 'label'},
                  {data: 'nominal', name: 'nominal'},
                  {data: 'tanggal', name: 'tanggal'},
                  {data: 'action', name: 'action', orderable: false, searchable: false},
              ]
          });
          
        });
    </script> --}}
    {{-- <script>
        $("#q").on("keyup", function () {
        $value = $(this).val();
        $.ajax({
            type: "get",
            url: '{{ route('tmasuk.search') }}',
            data: { q: $value },
            success: function (data) {
                // console.log(data);
                $("#table-content").html(data['result']);
                $('#pagination-container').html(data['pagination']);
            },
        });
    });
    </script> --}}
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}
    <script type="text/javascript">
      $(function () {
        
        var table = $('#tabel-tmasuk').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('tmasuk.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'label', name: 'label'},
                {data: 'nominal', name: 'nominal'},
                {data: 'tanggal', name: 'tanggal'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });
        
      });
    </script>
@endpush
