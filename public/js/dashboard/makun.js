"use strict";

$(document).ready(function () {
    // ====================================================================================
    // Components
    // ====================================================================================
    // 1. Multiselect
    // ====================================================================================
    $("#status").multiselect({
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
    $("#status").multiselect("selectAll", false);
    $("#status").multiselect("updateButtonText");
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
        status = [""]
    ) {
        $.ajax({
            url:
                "makun/makun_ajax?page=" +
                page +
                "&sorttype=" +
                sort_type +
                "&sortby=" +
                sort_by +
                "&search=" +
                search +
                "&maxdata=" +
                max_data +
                "&status=" +
                status,
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
        var status_selected = $("#status option:selected");
        var status_data = $("#status").val();
        if (status_selected.length < 1) {
            $("#status").multiselect("selectAll", false);
            $("#status").multiselect("updateButtonText");
            status_data = $("#status").val();
        }
        fetch_data(page, sort_type, column_name, search, max_data, status_data);
    }
    // ====================================================================================
    // 2. Search + Max Data + Status Akun
    // ====================================================================================
    $(document).on("keyup change", "#search, #max_data, #status", function () {
        reloadPage();
    });
    // ====================================================================================
    // 3. Sorting
    // ====================================================================================
    $(document).on("click", ".makun_sorting", function () {
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
        var status_selected = $("#status option:selected");
        var status_data = $("#status").val();
        if (status_selected.length < 1) {
            $("#status").multiselect("selectAll", false);
            $("#status").multiselect("updateButtonText");
            status_data = $("#status").val();
        }
        fetch_data(
            page,
            reverse_order,
            column_name,
            search,
            max_data,
            status_data
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
        var status_selected = $("#status option:selected");
        var status_data = $("#status").val();
        if (status_selected.length < 1) {
            $("#status").multiselect("selectAll", false);
            $("#status").multiselect("updateButtonText");
            status_data = $("#status").val();
        }
        fetch_data(page, sort_type, column_name, search, max_data, status_data);
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
            email: $("#addemail").val(),
            password: $("#addpassword").val(),
            repassword: $("#addrepassword").val(),
            _token: $('input[name="_token"][id="tokenAdd"]').val(),
        };
        $.ajax({
            type: "POST",
            url: "/makun",
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
    $(document).on("click", "#btn-reset-user", function () {
        let id = $(this).data("id");
        edit_id = id;

        $.ajax({
            url: "makun/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("#editModal").modal("show");
                $("#editname").val(data.name);
                $("#editemail").val(data.email);
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
            email: $("#editemail").val(),
            password: $("#editpassword").val(),
            repassword: $("#editrepassword").val(),
            _token: $('input[name="_token"][id="tokenEdit"]').val(),
        };
        console.log("Data yang akan dikirim: ");
        console.log(data);
        $.ajax({
            url: "makun/" + id,
            type: "PUT",
            data: data,
            success: function (data) {
                swal({
                    title: "Sukses!",
                    text: data.message,
                    icon: "success",
                    timer: 10000,
                });
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
    $(document).on("click", "#btn-del-user", function () {
        let id = $(this).data("id");
        let token = $('input[name="_token"][id="tokenCommon"]').val();

        swal({
            title: "Apakah Anda Yakin?",
            text: "Data akan dihapus secara permanen.",
            icon: "warning",
            buttons: {
                cancel: "Batal",
                confirm: "Ya, Hapus!",
            },
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                //fetch to delete data
                $.ajax({
                    url: "makun/" + id,
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

                        //remove post on table
                        $("#" + id).remove();
                    },
                });
            }
        });
    });
    // ====================================================================================
});
