"use strict";

$(document).ready(function () {
    // ====================================================================================
    // Setting Awal
    // ====================================================================================
    $("#soal, #jawaban, #label-soal, #label-jawaban").hide();
    // ====================================================================================
    // 1. Validation Reset Password
    // ====================================================================================
    $("#newpassword, #renewpassword").on("keyup", function () {
        let pw = $("#newpassword").val();
        let rpw = $("#renewpassword").val();
        if (pw != rpw) {
            $("#edit-rpw-error").text("Konfirmasi password berbeda");
        } else {
            $("#edit-rpw-error").text("");
        }
    });
    // ====================================================================================
    // 2. Reset Password
    // ====================================================================================
    $("#editFormPass").on("submit", function (e) {
        e.preventDefault();
        if ($("#newpassword").val() != $("#renewpassword").val()) return false;
        let token = $('input[name="_token"][id="tokenEditPass"]').val();
        let username = $("#username").val();
        let data = {
            username: username,
            oldPassword: $("#oldpassword").val(),
            newPassword: $("#newpassword").val(),
            renewPassword: $("#renewpassword").val(),
            _token: token,
        };
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token,
            },
        });
        $.ajax({
            url: "profile/resetPass/" + username,
            type: "PUT",
            data: data,
            success: function (data) {
                if (data.success) {
                    swal({
                        title: "Sukses!",
                        text: data.message,
                        icon: "success",
                        timer: 10000,
                    });
                    $("#modal-pass").modal("hide");
                    $("#editFormPass").trigger("reset");
                } else {
                    swal({
                        title: "Gagal!",
                        text: data.message,
                        icon: "error",
                        timer: 10000,
                    });
                    $("#editFormPass").trigger("reset");
                }
            },
            error: function (data) {
                console.log(data);
                alert("Gagal mengubah data!");
            },
        });
    });
    // ====================================================================================
    // 3. Delete Photo
    // ====================================================================================
    $("#form-img").on("submit", function (e) {
        e.preventDefault();
        if ($("#newpassword").val() != $("#renewpassword").val()) return false;
        let token = $('input[name="_token"][id="form-token"]').val();
        let username = $("#username").val();
        let data = {
            username: username,
            _token: token,
        };
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token,
            },
        });
        $.ajax({
            url: "profile/deletePhoto/" + username,
            type: "PUT",
            data: data,
            success: function (data) {
                if (data.success) {
                    swal({
                        title: "Sukses!",
                        text: data.message,
                        icon: "success",
                        timer: 10000,
                    });
                    $("#foto-profie").attr("src", "/img/avatar.png");
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
                alert("Gagal mengubah data!");
            },
        });
    });
    // ====================================================================================
    // 4. Update Data
    // ====================================================================================
    $("#form-akun").on("submit", function (e) {
        e.preventDefault();
        if ($("#newpassword").val() != $("#renewpassword").val()) return false;
        let token = $('input[name="_token"][id="form-token"]').val();
        let username = $("#username").val();
        let data = {
            username: username,
            name: $("#name").val(),
            email: $("#email").val(),
            image: $("foto").val(),
            _token: token,
        };
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token,
            },
        });
        $.ajax({
            url: "profile/update/" + username,
            type: "PUT",
            data: data,
            success: function (data) {
                if (data.success) {
                    swal({
                        title: "Sukses!",
                        text: data.message,
                        icon: "success",
                        timer: 10000,
                    });
                    $("#name").val(data.name);
                    $("#email").val(data.email);
                    $("#foto-profie").attr("src", "/img/" + data.image);
                    $("#foto-header").attr("src", "/img/" + data.image);
                    $("foto").val("");
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
                alert("Gagal mengubah data!");
            },
        });
    });
    // ====================================================================================
    // 5. Cek Fitur Lupa Password
    // ====================================================================================
    $("#btn-modal-lupa").on("click", function (e) {
        let token = $('input[name="_token"][id="form-token"]').val();
        let username = $("#username").val();
        let data = {
            username: username,
            _token: token,
        };
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token,
            },
        });
        $.ajax({
            url: "profile/recovInfo/" + username,
            type: "GET",
            data: data,
            success: function (data) {
                if (data.success) {
                    if (data.data.isAda) {
                        $("#btn-visible").prop("checked", true);
                        $(
                            "#soal, #jawaban, #label-soal, #label-jawaban"
                        ).show();
                        $("#soal")
                            .find("option[value='" + data.data.soal + "']")
                            .prop("selected", true);
                        $("#jawaban").val(data.data.jawaban);
                    } else {
                        $("#btn-visible").prop("checked", false);
                        $(
                            "#soal, #jawaban, #label-soal, #label-jawaban"
                        ).hide();
                        $("#soal")
                            .find("option[value='']")
                            .prop("selected", true);
                        $("#jawaban").val("");
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
    // 6. Button Fitur Lupa Password ON/OFF
    // ====================================================================================
    $("#btn-visible").on("change", (event) => {
        if (event.target.checked) {
            $("#txt-visible").text("Fitur Nyala");
            $("#soal, #jawaban, #label-soal, #label-jawaban").show();
        } else {
            $("#txt-visible").text("Fitur Mati");
            $("#soal, #jawaban, #label-soal, #label-jawaban").hide();
        }
    });
    // ====================================================================================
    // 7. Update Fitur Lupa Password
    // ====================================================================================
    $("#form-akun").on("submit", function (e) {
        e.preventDefault();
        if ($("#newpassword").val() != $("#renewpassword").val()) return false;
        let token = $('input[name="_token"][id="form-token"]').val();
        let username = $("#username").val();
        let data = {
            username: username,
            name: $("#name").val(),
            email: $("#email").val(),
            image: $("foto").val(),
            _token: token,
        };
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token,
            },
        });
        $.ajax({
            url: "profile/update/" + username,
            type: "PUT",
            data: data,
            success: function (data) {
                if (data.success) {
                    swal({
                        title: "Sukses!",
                        text: data.message,
                        icon: "success",
                        timer: 10000,
                    });
                    $("#name").val(data.name);
                    $("#email").val(data.email);
                    $("#foto-profie").attr("src", "/img/" + data.image);
                    $("#foto-header").attr("src", "/img/" + data.image);
                    $("foto").val("");
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
                alert("Gagal mengubah data!");
            },
        });
    });
    // ====================================================================================
    // ====================================================================================
});
