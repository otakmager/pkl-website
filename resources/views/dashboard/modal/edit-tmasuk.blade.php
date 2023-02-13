<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Data Transaksi Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenEdit">
                <div class="modal-body">                    
                    <div class="form-group">
                        <label>Nama Transaksi</label>
                        <input type="text" class="form-control" id="editname" name="name" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label>Label</label>
                        <select type="text" class="form-control" id="editlabel" name="label" required>
                            @foreach ($labels as $label)
                            <option value="{{ $label->id }}">{{ $label->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="number" class="form-control" id="editnominal" name="nominal" min="1">
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="text" class="form-control" id="edittanggal" name="tanggal" required>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="btnedit" id="btnedit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>