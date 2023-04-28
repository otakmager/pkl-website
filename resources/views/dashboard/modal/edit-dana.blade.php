<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Edit Dana Awal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenEdit">
                <div class="modal-body" style="background: #f5f5f5">         
                    <div class="form-group">
                        <label>Dana Awal</label>
                        <input type="number" class="form-control" id="edituang" name="uang" required>
                    </div>
                    <div class="form-group" style="font-size: 30px">
                        <label>Tertulis:</label>
                        <strong id="tanda">-</strong><strong id="myuang">Rpxxx.xxx.xxx</strong>,00                      
                        <p style="font-size: 16px">Tips: Gunakan tanda '-' jika dana negatif</p>    
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