<div class="modal fade" tabindex="-1" role="dialog" id="modal-pass">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Reset password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editFormPass">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenEditPass">
                <div class="modal-body">              
                    <div class="form-group">
                        <label>Password Lama</label>
                        <input type="password" class="form-control" id="oldpassword" name="oldpassword" minlength="5" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" class="form-control" id="newpassword" name="newpassword" minlength="5" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" class="form-control" id="renewpassword" name="renewpassword" minlength="5" maxlength="255" required>
                        <span id="edit-rpw-error" class="text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="btnedit" id="btneditPass">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>