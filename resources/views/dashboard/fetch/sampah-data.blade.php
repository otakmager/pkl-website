@foreach ($transactions as $transaction)            
    <tr class="text-center" id="{{ $transaction->id }}">
    <td id="nomor">{{ isset($page)? $maxData*($page-1)+$loop->iteration : $loop->iteration }}</td>
    <td>{{ $transaction->name }}</td>
    <td>{{ $transaction->label->name }}</td>
    <td>@currency($transaction->nominal)</td>
    <td>{{ date('d/m/Y', strtotime($transaction->tanggal)) }}</td>
    <td class="text-center">
        <a href="javascript:void(0)" id="btn-edit-transaction" data-id="{{ $transaction->id }}" class="btn btn-icon icon-left btn-primary" ><i class="fas fa-rotate-left"></i> Pulihkan</a>
        <a href="javascript:void(0)" id="btn-del-transaction" data-id="{{ $transaction->id }}" class="btn btn-icon icon-left btn-danger" ><i class="fas fa-trash"></i> Hapus</a>
    </td>
    </tr>
@endforeach   
<tr class="data_pagin_link">
    <td colspan="6" align="center">{{ $transactions->links() }}</td>
</tr>