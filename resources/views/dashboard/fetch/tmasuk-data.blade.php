@foreach ($tmasuks as $tmasuk)            
    <tr class="text-center" id="{{ $tmasuk->id }}">
    <td id="nomor">{{ isset($page)? $maxData*($page-1)+$loop->iteration : $loop->iteration }}</td>
    <td>{{ $tmasuk->name }}</td>
    <td>{{ $tmasuk->label->name }}</td>
    <td>@currency($tmasuk->nominal)</td>
    <td>{{ date('d/m/Y', strtotime($tmasuk->tanggal)) }}</td>
    <td class="text-center">
        <a href="javascript:void(0)" id="btn-edit-tmasuk" data-id="{{ $tmasuk->id }}" class="btn btn-icon icon-left btn-primary" ><i class="far fa-edit"></i> Edit</a>
        <a href="javascript:void(0)" id="btn-del-tmasuk" data-id="{{ $tmasuk->id }}" class="btn btn-icon icon-left btn-danger" ><i class="fas fa-trash"></i> Hapus</a>
    </td>
    </tr>
@endforeach   
<tr class="data_pagin_link">
    <td colspan="6" align="center">{{ $tmasuks->links() }}</td>
</tr>