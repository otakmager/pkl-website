<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Transaksi Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                {{-- @csrf --}}
                {{-- <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" id="csrf-token"/> --}}
                <div class="modal-body">                    
                    <div class="form-group">
                        <label>Nama Transaksi</label>
                        <input type="text" class="form-control @error('nameTransaksi')is-invalid @enderror" id="addname" name="name" maxlength="100" required value="{{ old('nameTransaksi') }}">
                        {{-- @error('nameTransaksi')<div class="invalid-feedback">{{ $message }}</div>@enderror --}}
                    </div>
                    <div class="form-group">
                        <label>Label</label>
                        <select type="text" class="form-control" id="addlabel" name="label" required>
                            <option value="Reparasi">Reparasi</option>
                            <option value="Jualan">Jualan</option>
                            <option value="Donasi">Donasi</option>
                            <option value="Kas">Kas</option>
                            <option value="Hibah">Hibah</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="number" class="form-control @error('nominal')is-invalid @enderror" id="addnominal" name="nominal" min="1" required value="{{ old('nominal') }}">
                        {{-- @error('nominal')<div class="invalid-feedback">{{ $message }}</div>@enderror --}}
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="text" class="form-control @error('tanggal')is-invalid @enderror" id="addtanggal" name="tanggal" required value="{{ old('tanggal') }}">
                        {{-- @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror --}}
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="btnadd" id="btnadd">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    //action create post
    // $('#btnadd').click(function(e) {
    //     e.preventDefault();

    //     //define variable
    //     let name   = $('#addname').val();
    //     let label   = $('#addlabel').val();
    //     let nominal   = $('#addnominal').val();
    //     let tanggal   = $('#addtanggal').val();
    //     let token   = $("meta[name='csrf-token']").attr("content");
        
    //     //ajax
    //     $.ajax({

    //         url: `/tmasuk`,
    //         type: "POST",
    //         cache: false,
    //         data: {
    //             "name": name,
    //             "label": label,
    //             "nominal": nominal,
    //             "tanggal": tanggal,
    //             "_token": token
    //         },
    //         success:function(response){

    //             //show success message
    //             Swal.fire({
    //                 type: 'success',
    //                 icon: 'success',
    //                 title: `${response.message}`,
    //                 showConfirmButton: false,
    //                 timer: 3000
    //             });

    //             //data post
    //             let post = `
    //                 <tr id="index_${response.data.id}">
    //                     <td>${response.data.name}</td>
    //                     <td>${response.data.label}</td>
    //                     <td>${response.data.nominal}</td>
    //                     <td>${response.data.date}</td>
    //                     <td class="text-center">
    //                         <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
    //                         <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
    //                     </td>
    //                 </tr>
    //             `;
                
    //             //append to table
    //             $('#table-data').prepend(post);
                
    //             //clear form
    //             $('#addname').val('');
    //             $('#addlabel').val('');
    //             $('#addnominal').val('');
    //             $('#addtanggal').val('');

    //             //close modal
    //             $('#addmodal').modal('hide');
                

    //         },
    //         error:function(error){
                
    //             if(error.responseJSON.title[0]) {

    //                 //show alert
    //                 $('#alert-title').removeClass('d-none');
    //                 $('#alert-title').addClass('d-block');

    //                 //add message to alert
    //                 $('#alert-title').html(error.responseJSON.title[0]);
    //             } 

    //             if(error.responseJSON.content[0]) {

    //                 //show alert
    //                 $('#alert-content').removeClass('d-none');
    //                 $('#alert-content').addClass('d-block');

    //                 //add message to alert
    //                 $('#alert-content').html(error.responseJSON.content[0]);
    //             } 

    //         }

    //     });

    // });

</script>