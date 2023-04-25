"use strict";
function previewImage() {
    const image = document.querySelector("#image");
    const imgPreview = document.querySelector(".img-preview");

    imgPreview.style.display = "block";
    const ofReader = new FileReader();
    ofReader.readAsDataURL(image.files[0]);
    ofReader.onload = function (oFREvent) {
        imgPreview.src = oFREvent.target.result;
    };
}
$(document).ready(function () {
    // ====================================================================================
    // Setting Awal
    // ====================================================================================
    $("#soal, #jawaban, #label-soal, #label-jawaban").hide();
    $("#btn-visible").prop("checked", false);
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
                    $("#foto-profile").attr("src", "/img/avatar.png");
                    $("#foto-header").attr("src", "/img/avatar.png");
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
        let formData = new FormData(this);
        formData.append("_token", token);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token,
            },
        });
        $.ajax({
            url: "profile/update/" + username,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.success) {
                    swal({
                        title: "Sukses!",
                        text: data.message,
                        icon: "success",
                        timer: 10000,
                    });
                    $("#name").val(data.data.name);
                    $("#name-header").text("Hi, " + data.data.name);
                    $("#email").val(data.data.email);
                    $("#foto-profile").attr(
                        "src",
                        "/storage/" + data.data.image
                    );
                    $("#foto-header").attr(
                        "src",
                        "/storage/" + data.data.image
                    );
                } else {
                    swal({
                        title: "Gagal!",
                        text: data.message,
                        icon: "error",
                        timer: 15000,
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
    $("#editFormLupaPass").on("submit", function (e) {
        e.preventDefault();
        if ($("#soal").val() != "") return false;
        if ($("#jawaban").val() != "") return false;
        let token = $('input[name="_token"][id="form-token"]').val();
        let username = $("#username").val();
        let data = {};
        let flag = $("#btn-visible").is(":checked") ? "NOT NULL" : "NULL";
        if (flag == "NOT NULL") {
            data = {
                username: username,
                flag: flag,
                soal: $("#soal").val(),
                jawaban: $("jawaban").val(),
                _token: token,
            };
        } else {
            data = {
                username: username,
                flag: flag,
                soal: 0,
                jawaban: 0,
                _token: token,
            };
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token,
            },
        });
        $.ajax({
            url: "profile/updateRecov/" + username,
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
                    $("#modal-lupa").modal("hide");
                    $("#editFormLupaPass").trigger("reset");
                    $("#btn-visible").prop("checked", false);
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
