@foreach ($tmasuks as $tmasuk)            
    <tr class="text-center" id="{{ $tmasuk->slug }}">
    <td>{{ isset($page)? $maxData*($page-1)+$loop->iteration : $loop->iteration }}</td>
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
<tr class="data_pagin_link">
    <td colspan="6" align="center">{{ $tmasuks->links() }}</td>
</tr>