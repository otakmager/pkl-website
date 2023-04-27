<div class="modal fade" id="modal-reset" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="resetModalLabel">Ganti Password</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="form-reset" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenReset">
                <div class="form-group mt-2">
                    <label>Password Baru</label>
                    <input type="password" class="form-control" id="newpassword" name="newpassword" minlength="5" maxlength="255" required>
                </div>
                <div class="form-group mt-2">
                    <label>Konfirmasi Password</label>
                    <input type="password" class="form-control" id="renewpassword" name="renewpassword" minlength="5" maxlength="255" required>
                    <span id="edit-rpw-error" class="text-danger"></span>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button id="btn-close-reset" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button id="btn-update" type="button" class="btn btn-primary">Kirim</button>
        </div>
      </div>
    </div>
  </div>