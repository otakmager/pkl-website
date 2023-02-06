<div class="card">
    <div class="card-header">
        <h4>Tabel Transaksi Masuk</h4>
        <div class="card-header-form">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search"
                    id="search" name="search" wire:model="searchTerm">
                <div class="input-group-btn">
                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>      
    </div>
    <div class="form-group mb-2">
        <div class="custom-control selectgroup align-items-center">
            <label for="p" class="mt-2">Show: </label>
            <select class="form-control mx-1 " id="p" name="p" style="max-width: 75px" wire:model="p">
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
                <select id="example-post" class="form-control mx-1" name="multiselect[]" multiple="multiple" wire:model="label" wire:ignore>
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
            <table class="table-striped table" id="tabel-tmasuk">
                <tr class="text-center">
                    <th>No. </th>
                    <th>Nama</th>
                    <th>Label</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
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
            </table>
        </div>
        <div class="mt-3 mx-4 d-flex justify-content-center">{{ $tmasuks->links() }}</div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:load", function(event) {
            $('#example-post').multiselect({
                includeSelectAllOption: true,
                enableFiltering: true,
                buttonContainer: '<div class="btn-group w-100" />'
            });
        //     window.livewire.hook('afterDomUpdate', () => {
        //         jQuery(function($) {
        //             // $('.desc').shorten({
        //             //    chars: 300,
        //             //    ellipses: '...',
        //             //    more: 'see more',
        //             //    less: '...less'
        //             // });
        //             // $('#example-post').multiselect({
        //             //     includeSelectAllOption: true,
        //             //     enableFiltering: true,
        //             //     buttonContainer: '<div class="btn-group w-100" />'
        //             // });
        //         });
        //    });
       });
   </script>
@endpush
