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
        let token = $('input[name="_token"][id="tokenSoal"]').val();
        let email = $("#email").val();
        let data = {
            email: email,
            _token: token,
        };
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token,
            },
        });
        $.ajax({
            url: "forget-password/get-soal/" + email,
            type: "GET",
            data: data,
            success: function (data) {
                if (data.success) {
                    $("#alert-soal").attr("hidden", true);
                    $("#isi-alert-soal").text("");
                    $("#soal").text(data.soal);
                    $("#soal-hidden").val(data.hidden);
                    $("#modal-soal").modal("show");
                } else {
                    swal({
                        title: "Gagal!",
                        text: data.message,
                        icon: "error",
                        timer: 20000,
                    });
                }
            },
            error: function (data) {
                console.log(data);
                alert("Gagal mendapatkan data!");
            },
        });
    });
    // ====================================================================================
    // 3. Buka Modal Ganti Password
    // ====================================================================================
    $("#btn-kirim").on("click", function (e) {
        let token = $('input[name="_token"][id="tokenSoal"]').val();
        let email = $("#email").val();
        let data = {
            email: email,
            soal: $("#soal-hidden").val(),
            jawaban: $("#jawaban").val(),
            _token: token,
        };
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token,
            },
        });
        $.ajax({
            url: "forget-password/validasi-soal/" + email,
            type: "GET",
            data: data,
            success: function (data) {
                if (data.success) {
                    if (data.isValid) {
                        $("#alert-soal").attr("hidden", true);
                        $("#isi-alert-soal").text("");
                        $("#modal-soal").modal("hide");
                        $("#soal").text("-");
                        $("#soal-hidden").val();
                        $("#jawaban").val();
                        $("#modal-reset").modal("show");
                    } else {
                        $("#alert-soal").removeAttr("hidden");
                        $("#isi-alert-soal").text(data.message);
                    }
                } else {
                    swal({
                        title: "Gagal!",
                        text: data.message,
                        icon: "error",
                        timer: 10000,
                    });
                }
            },
            error: function (data) {
                console.log(data);
                alert("Gagal mendapatkan data!");
            },
        });
    });
    // ====================================================================================
    // 4. Validation Reset Password
    // ====================================================================================
    $("#newpassword, #renewpassword").on("keyup", function () {
        let pw = $("#newpassword").val();
        let rpw = $("#renewpassword").val();
        if (pw.length < 5 || pw.length > 255) {
            $("#edit-pw-error").text(
                "Minimal 5 karakter & maksimal 255 karakter"
            );
        } else {
            $("#edit-pw-error").text("");
        }
        if (pw != rpw) {
            $("#edit-rpw-error").text("Konfirmasi password berbeda");
        } else {
            $("#edit-rpw-error").text("");
        }
    });
    // ====================================================================================
    // 5. Ganti Password
    // ====================================================================================
    $("#btn-update").on("click", function (e) {
        let token = $('input[name="_token"][id="tokenReset"]').val();
        let email = $("#email").val();
        let newPassword = $("#newpassword").val();
        let renewPassword = $("#renewpassword").val();
        if (newPassword != renewPassword) return false;
        if (newPassword.length < 5 || newPassword.length > 255) return false;
        let data = {
            email: email,
            newPassword: newPassword,
            renewPassword: renewPassword,
            _token: token,
        };
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token,
            },
        });
        $.ajax({
            url: "forget-password/reset-pass/" + email,
            type: "PUT",
            data: data,
            success: function (data) {
                if (data.success) {
                    $("#newpassword").val();
                    $("#renewpassword").val();
                    $("#edit-rpw-error").text("");
                    $("#modal-reset").modal("hide");
                    $("#modal-opsi").modal("hide");
                    $("#email").val();
                    window.location.replace("/login");
                } else {
                    swal({
                        title: "Gagal!",
                        text: data.message,
                        icon: "error",
                        timer: 10000,
                    });
                }
            },
            error: function (data) {
                console.log(data);
                alert("Gagal mendapatkan data!");
            },
        });
    });
    // ====================================================================================
    // ====================================================================================
});
