<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Transaksi Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/tmasuk/" method="POST">
                @csrf
                <div class="modal-body">                    
                    <div class="form-group">
                        <label>Nama Transaksi</label>
                        <input type="text" class="form-control @error('nameTransaksi')is-invalid @enderror" id="addnameTransaksi" name="nameTransaksi" maxlength="100" required value="{{ old('nameTransaksi') }}">
                        @error('nameTransaksi')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                        @error('nominal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="text" class="form-control @error('tanggal')is-invalid @enderror" id="addtanggal" name="tanggal" required value="{{ old('tanggal') }}">
                        @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>