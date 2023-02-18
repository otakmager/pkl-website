@foreach ($users as $user)            
    <tr class="text-center" id="{{ $user->id }}">
    <td id="nomor">{{ isset($page)? $maxData*($page-1)+$loop->iteration : $loop->iteration }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>
        @if ($user->level === 'pimpinan')
            Aktif
        @else
            <select name="status" id="status" class="form-control" data-id="{{ $user->id }}">
                <option value="0" @if ($user->status === 0) selected @endif>Non-aktif</option>
                <option value="1" @if ($user->status === 1) selected @endif>Aktif</option>
            </select>
        @endif
    </td>
    <td class="text-center">
        @if ($user->level === 'pimpinan')
            <a href="javascript:void(0)" id="btn-setting-admin" data-id="{{ $user->id }}" class="btn btn-icon icon-left btn-warning btn-sm"><i class="fas fa-screwdriver-wrench"></i> Pengaturan Akun</a>
        @else
            <a href="javascript:void(0)" id="btn-reset-user" data-id="{{ $user->id }}" class="btn btn-icon icon-left btn-warning btn-sm" ><i class="fas fa-key"></i> Reset Pass</a>
            <a href="javascript:void(0)" id="btn-del-user" data-id="{{ $user->id }}" class="btn btn-icon icon-left btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</a>        
        @endif   
    </td>
    </tr>
@endforeach   
<tr class="data_pagin_link">
    <td colspan="6" align="center">{{ $users->links() }}</td>
</tr>