@foreach ($tkeluars as $tkeluar)            
    <tr class="text-center" id="{{ $tkeluar->id }}">
    <td id="nomor">{{ isset($page)? $maxData*($page-1)+$loop->iteration : $loop->iteration }}</td>
    <td>{{ $tkeluar->name }}</td>
    <td>{{ $tkeluar->label->name }}</td>
    <td>@currency($tkeluar->nominal)</td>
    <td>{{ date('d/m/Y', strtotime($tkeluar->tanggal)) }}</td>
    <td class="text-center">
        <a href="javascript:void(0)" id="btn-edit-tkeluar" data-id="{{ $tkeluar->id }}" class="btn btn-icon icon-left btn-primary" ><i class="far fa-edit"></i> Edit</a>
        <a href="javascript:void(0)" id="btn-del-tkeluar" data-id="{{ $tkeluar->id }}" class="btn btn-icon icon-left btn-danger" ><i class="fas fa-trash"></i> Hapus</a>
    </td>
    </tr>
@endforeach   
<tr class="data_pagin_link">
    <td colspan="6" align="center">{{ $tkeluars->links() }}</td>
</tr>