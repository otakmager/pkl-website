<div class="modal fade" id="modal-opsi" tabindex="-1" aria-labelledby="opsiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="opsiModalLabel">Opsi Pemulihan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg btn-block btn-icon-split mt-2">
                <i class="fas fa-headset"></i> Hubungi Admin atau Pimpinan
            </a>
            <button type="button" id="btn-soal" class="btn btn-outline-primary btn-lg btn-block btn-icon-split mt-2">
                <i class="fas fa-clipboard-question"></i> Pertanyaan Pemulihan
            </button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>