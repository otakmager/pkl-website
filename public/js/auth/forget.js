"use strict";
$(document).ready(function () {
    // ====================================================================================
    // 1. Cek email
    // ====================================================================================
    $("#form-pass").on("submit", function (e) {
        e.preventDefault();
        if ($("#email").val() == "") return false;
        let email = $("#email").val();
        $.ajax({
            url: "forget-password/cek/",
            type: "GET",
            data: { email: email },
            success: function (data) {
                if (data.success) {
                    $("#alert-lupa").attr("hidden", true);
                    $("#modal-opsi").modal("show");
                } else {
                    $("#alert-lupa").removeAttr("hidden");
                    $("#isi-lupa").text(data.message);
                }
            },
            error: function (data) {
                console.log(data);
                alert("Gagal mendapatkan data!");
            },
        });
    });
    // ====================================================================================
    // 2. Buka Modal Soal
    // ====================================================================================
    $("#btn-soal").on("click", function (e) {
        $("#modal-soal").modal("show");
    });
    // ====================================================================================
    // 3. Buka Modal Ganti Password
    // ====================================================================================
    $("#btn-kirim").on("click", function (e) {
        $("#modal-soal").modal("hide");
        $("#soal").text("-");
        $("#jawaban").val();
        $("#modal-reset").modal("show");
    });
    // ====================================================================================
    // 4. Ganti Password
    // ====================================================================================
    $("#btn-update").on("click", function (e) {
        $("#newpassword").val();
        $("#renewpassword").val();
        $("#edit-rpw-error").text("");
        $("#modal-reset").modal("hide");
    });
    // ====================================================================================
    // ====================================================================================
});
