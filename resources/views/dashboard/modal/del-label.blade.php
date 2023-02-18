<div class="modal fade" tabindex="-1" role="dialog" id="delModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Data Label</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenEdit">
                <div class="modal-body text-center">                    
                    <div>Label <span id="label-name" data-label-name="xxx"></span> memiliki <span id="label-sum" data-label-sum="sum"> data transaksi.</div>
                    <p>Apakah Anda yakin menghapus label ini dan seluruh data transaksi terkait?</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="btnedit" id="btnedit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>