<div class="modal fade" id="modal-soal" tabindex="-1" aria-labelledby="soalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="soalModalLabel">Pertanyaan Pemulihan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-lupa" hidden>
                <div id="isi-alert-pertanyaan"></div>
            </div>
            <form id="form-soal" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenSoal">
                <div class="form-group mt-2">
                    <label id="label-soal"><h5>Pertanyaan Pemulihan</h5></label>
                    <p id="soal">-</p>
                </div>
                <div class="form-group mt-2">
                    <label id="label-jawaban" for="jawaban"><h5>Tulis Jawabanmu</h5></label>
                    <input type="text" class="form-control" id="jawaban" name="jawaban" minlength="3" maxlength="255" autofocus>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button id="btn-close-soal" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button id="btn-kirim" type="button" class="btn btn-primary">Kirim</button>
        </div>
      </div>
    </div>
  </div>