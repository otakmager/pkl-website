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
                    swal({
                        title: "Sukses!",
                        text: data.message,
                        icon: "success",
                        timer: 10000,
                    });
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
    // ====================================================================================
});
