<div class="modal fade" tabindex="-1" role="dialog" id="modal-lupa">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Fitur lupa password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="tokenEdit">
                <div class="modal-body">       
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 id="txt-visible">Fitur Mati</h4>
                            <div class="card-header-action">
                                <label class="switch">
                                    <input type="checkbox" id="btn-visible"/>
                                    <span class="slider round"></span>
                                  </label>
                            </div>
                        </div>
                    </div>       
                    <div class="form-group">
                        <label>Pertanyaan Pemulihan</label>
                        <select class="form-control mx-1" name="soal[]" id="soal">
                            <option value="" selected disabled>Pilih Pertanyaan Pemulihan</option>
                            <option value="a">Siapa nama orang yang kamu kenal pertama kali saat masih kecil?</option>
                            <option value="b">Apa nama hewan peliharaanmu pertama kali?</option>
                            <option value="c">Apa merek mobil/sepeda motor pertama yang kamu miliki?</option>
                            <option value="d">Siapa nama panggilan teman masa kecilmu?</option>
                            <option value="e">Apa makanan favorit Anda saat masih kecil?</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jawaban</label>
                        <input type="text" class="form-control" id="jawaban" name="jawaban" minlength="3" maxlength="255">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="btnedit" id="btnedit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>