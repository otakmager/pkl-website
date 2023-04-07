"use strict";

$(document).ready(function () {
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
        console.log("start");
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
    // ====================================================================================
});
