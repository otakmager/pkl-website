"use strict";

$(document).ready(function () {
    // ====================================================================================
    // Components
    // ====================================================================================
    // 1. Multiselect
    // ====================================================================================
    $("#jenis").multiselect({
        includeSelectAllOption: true, // add select all option as usual
        optionClass: function (element) {
            var value = $(element).val();

            if (value % 2 == 0) {
                return "even";
            } else {
                return "odd";
            }
        },
    });
    $("#jenis").multiselect("selectAll", false);
    $("#jenis").multiselect("updateButtonText");
    // ====================================================================================

    // ====================================================================================
    // Pagination + Sorting + Filtering + Searching
    // ====================================================================================
    // 1-a. Ajax Fetch Data
    // ====================================================================================
    function fetch_data(
        page,
        sort_type = "",
        sort_by = "",
        search = "",
        max_data = 5,
        jenis = [""]
    ) {
        $.ajax({
            url:
                "label/label_ajax?page=" +
                page +
                "&sorttype=" +
                sort_type +
                "&sortby=" +
                sort_by +
                "&search=" +
                search +
                "&maxdata=" +
                max_data +
                "&jenis=" +
                jenis,
            success: function (data) {
                $(".mydata tbody").html(data);
            },
        });
    }
    // ====================================================================================
    // 1-b. Ajax Reload Table
    // ====================================================================================
    function reloadPage() {
        var search = $("#search").val();
        var column_name = $("#hidden_column_name").val();
        var sort_type = $("#hidden_sort_type").val();
        var page = $("#hidden_page").val();
        var max_data = $("#max_data option:selected").val();
        var jenis_selected = $("#jenis option:selected");
        var jenis_data = $("#jenis").val();
        if (jenis_selected.length < 1) {
            $("#jenis").multiselect("selectAll", false);
            $("#jenis").multiselect("updateButtonText");
            jenis_data = $("#jenis").val();
        }
        fetch_data(page, sort_type, column_name, search, max_data, jenis_data);
    }
    // ====================================================================================
    // 2. Search + Max Data + Jenis Label
    // ====================================================================================
    $(document).on("keyup change", "#search, #max_data, #jenis", function () {
        $("#hidden_page").val(1);
        reloadPage();
    });
    // ====================================================================================
    // 3. Sorting
    // ====================================================================================
    $(document).on("click", ".label_sorting", function () {
        $("#hidden_page").val(1);
        var column_name = $(this).data("column_name");
        var order_type = $(this).data("sorting_type");
        var reverse_order = "";
        if (order_type == "asc") {
            $(this).data("sorting_type", "desc");
            reverse_order = "desc";
        } else {
            $(this).data("sorting_type", "asc");
            reverse_order = "asc";
        }
        $("#hidden_column_name").val(column_name);
        $("#hidden_sort_type").val(reverse_order);
        var search = $("#search").val();
        var page = $("#hidden_page").val();
        var max_data = $("#max_data option:selected").val();
        var jenis_selected = $("#jenis option:selected");
        var jenis_data = $("#jenis").val();
        if (jenis_selected.length < 1) {
            $("#jenis").multiselect("selectAll", false);
            $("#jenis").multiselect("updateButtonText");
            jenis_data = $("#jenis").val();
        }
        fetch_data(
            page,
            reverse_order,
            column_name,
            search,
            max_data,
            jenis_data
        );
    });
    // ====================================================================================
    // 4. Pagination
    // ====================================================================================
    $(document).on("click", ".data_pagin_link a", function (e) {
        e.preventDefault();
        var search = $("#search").val();
        var column_name = $("#hidden_column_name").val();
        var sort_type = $("#hidden_sort_type").val();
        var page = $(this).attr("href").split("page=")[1];
        var max_data = $("#max_data option:selected").val();
        var jenis_selected = $("#jenis option:selected");
        var jenis_data = $("#jenis").val();
        if (jenis_selected.length < 1) {
            $("#jenis").multiselect("selectAll", false);
            $("#jenis").multiselect("updateButtonText");
            jenis_data = $("#jenis").val();
        }
        fetch_data(page, sort_type, column_name, search, max_data, jenis_data);
        $("#hidden_page").val($(this).attr("href").split("page=")[1]);
    });
    // ====================================================================================

    // ====================================================================================
    // Insert, Edit, and Delete
    // ====================================================================================
    // 1. Insert Data
    // ====================================================================================
    $("#addModal").submit(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"][id="tokenAdd"]').val(),
            },
        });
        let data = {
            name: $("#addname").val(),
            jenis: $("#addjenis").val(),
            _token: $('input[name="_token"][id="tokenAdd"]').val(),
        };
        $.ajax({
            type: "POST",
            url: "/label",
            data: data,
            success: function (data) {
                if (data.success) {
                    $("#addModal").modal("hide");
                    $("#addForm").trigger("reset");
                    swal({
                        title: "Sukses!",
                        text: data.message,
                        icon: "success",
                        timer: 10000,
                    });
                    $("#hidden_page").val(1);
                    reloadPage();
                }
            },
            error: function (data) {
                $("#addModal").modal("hide");
                $("#addForm").trigger("reset");
                console.log(data);
            },
        });
    });
    // ====================================================================================
    // 2. Fetch Detail Data
    // ====================================================================================
    let edit_id;
    $(document).on("click", "#btn-edit-label", function () {
        let id = $(this).data("id");
        edit_id = id;

        $.ajax({
            url: "label/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("#editModal").modal("show");
                $("#editname").val(data.name);
                $("#editjenis option[value='0']").remove();
                $("#editjenis option[value='1']").remove();
                if (data.jenis == 0) {
                    $("#editjenis").append(
                        '<option value="0">Transaksi Masuk</option>'
                    );
                    $("#editjenis").val(0);
                } else {
                    $("#editjenis").append(
                        '<option value="1">Transaksi Keluar</option>'
                    );
                    $("#editjenis").val(1);
                }
            },
            error: function () {
                alert("Tidak dapat menampilkan data!");
            },
        });
    });
    // ====================================================================================
    // 3. Update Data
    // ====================================================================================
    $("#editForm").on("submit", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"][id="tokenEdit"]').val(),
            },
        });
        var id = edit_id;
        var nomor = $("#" + id)
            .find("#nomor")
            .text();
        let data = {
            name: $("#editname").val(),
            jenis: $("#editjenis").val(),
            _token: $('input[name="_token"][id="tokenEdit"]').val(),
        };
        $.ajax({
            url: "label/" + id,
            type: "PUT",
            data: data,
            success: function (data) {
                swal({
                    title: "Sukses!",
                    text: data.message,
                    icon: "success",
                    timer: 10000,
                });
                //replace tr
                let label =
                    `
                <tr class="text-center" id="${data.data.id}">
                <td id="nomor">` +
                    nomor +
                    `</td>
                <td>${data.data.name}</td>
                <td>` +
                    (data.data.jenis == 0
                        ? "Transaksi masuk"
                        : "Transaksi keluar") +
                    `</td>
                <td class="text-center">
                    <a href="javascript:void(0)" id="btn-edit-label" data-id="${data.data.id}" class="btn btn-icon icon-left btn-primary" ><i class="far fa-edit"></i> Edit</a>
                    <a href="javascript:void(0)" id="btn-del-label" data-id="${data.data.id}" class="btn btn-icon icon-left btn-danger" ><i class="fas fa-trash"></i> Hapus</a>
                </td>
                </tr>
                `;
                //append to post data
                $(`#${data.data.id}`).replaceWith(label);
                $("#editModal").modal("hide");
                $("#editForm").trigger("reset");
            },
            error: function (data) {
                console.log(data);
                alert("Gagal mengubah data!");
            },
        });
    });
    // ====================================================================================
    // 3. Delete Data
    // ====================================================================================
    $(document).on("click", "#btn-del-label", function () {
        let id = $(this).data("id");
        let token = $('input[name="_token"][id="tokenCommon"]').val();

        // check total data
        $.ajax({
            url: "label/label_sum/" + id,
            type: "GET",
            cache: false,
            data: {
                _token: token,
            },
            success: function (data) {
                swal({
                    title: "Terdapat " + data.sum + " Data!",
                    text:
                        "Label ini mempunyai " +
                        data.sum +
                        " data. Jika Anda menghapus label ini maka semua data transaksi akan dihapus",
                    icon: "warning",
                    buttons: {
                        cancel: "Batal",
                        confirm: "Hapus Sekarang!",
                    },
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        swal({
                            title: "Apakah Anda Yakin?",
                            text: "Data transaksi akan dihapus ke tempat sampah \ndan dapat dipulihkan sebelum 14 hari sejak dihapus.",
                            icon: "warning",
                            buttons: {
                                cancel: "Batal",
                                confirm: "Ya, Hapus!",
                            },
                            dangerMode: true,
                        }).then((willDeletePermanently) => {
                            if (willDeletePermanently) {
                                //fetch to delete data
                                $.ajax({
                                    url: "label/" + id,
                                    type: "DELETE",
                                    cache: false,
                                    data: {
                                        _token: token,
                                    },
                                    success: function (data) {
                                        //show success message
                                        swal({
                                            title: "Sukses!",
                                            text: data.message,
                                            icon: "success",
                                            timer: 10000,
                                        });

                                        //reload table
                                        reloadPage();
                                    },
                                });
                            }
                        });
                    }
                });
            },
        });
    });
    // ====================================================================================
});
