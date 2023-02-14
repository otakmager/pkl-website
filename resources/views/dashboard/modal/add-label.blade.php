<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Label</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenAdd">
                <div class="modal-body">                    
                    <div class="form-group">
                        <label>Nama label</label>
                        <input type="text" class="form-control" id="addname" name="name" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Transaksi</label>
                        <select type="text" class="form-control" id="addjenis" name="jenis" required>
                            <option value="0">Transaksi Masuk</option>
                            <option value="1">Transaksi Keluar</option>
                        </select>
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