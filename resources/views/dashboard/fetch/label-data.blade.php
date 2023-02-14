@foreach ($labels as $label)            
    <tr class="text-center" id="{{ $label->id }}">
    <td id="nomor">{{ isset($page)? $maxData*($page-1)+$loop->iteration : $loop->iteration }}</td>
    <td>{{ $label->name }}</td>
    <td>
        @if ($label->jenis)
            Transaksi Keluar
        @else
            Transaksi Masuk
        @endif
    </td>
    <td class="text-center">
        <a href="javascript:void(0)" id="btn-edit-label" data-id="{{ $label->id }}" class="btn btn-icon icon-left btn-primary" ><i class="far fa-edit"></i> Edit</a>
        <a href="javascript:void(0)" id="btn-del-label" data-id="{{ $label->id }}" class="btn btn-icon icon-left btn-danger" ><i class="fas fa-trash"></i> Hapus</a>
    </td>
    </tr>
@endforeach   
<tr class="data_pagin_link">
    <td colspan="6" align="center">{{ $labels->links() }}</td>
</tr>