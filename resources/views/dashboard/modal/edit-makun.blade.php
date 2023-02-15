<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Reset password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenEdit">
                <div class="modal-body">              
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="editname" name="name" maxlength="100" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="editemail" name="email" required readonly>
                    </div>      
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="editpassword" name="password" minlength="5" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" class="form-control" id="editrepassword" name="repassword" minlength="5" maxlength="255" required>
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