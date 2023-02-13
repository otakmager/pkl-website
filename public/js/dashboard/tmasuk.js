"use strict";

$(document).ready(function () {
    var defStrDate = moment("1 January 2017", "D MMMM YYYY").format(
        "YYYY-MM-DD"
    );
    var defEndDate = moment().add(10, "years").format("YYYY-MM-DD");
    var toggleStatus = false;
    // ====================================================================================
    // Components
    // ====================================================================================
    // 1. Multiselect
    // ====================================================================================
    $("#label").multiselect({
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
    $("#label").multiselect("selectAll", false);
    $("#label").multiselect("updateButtonText");
    // ====================================================================================
    // 2. Datepicker
    // ====================================================================================
    $(".daterange-cus").daterangepicker(
        {
            locale: { format: "D MMMM YYYY" },
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [
                    moment().subtract(1, "days"),
                    moment().subtract(1, "days"),
                ],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [
                    moment().startOf("month"),
                    moment().endOf("month"),
                ],
                "Last Month": [
                    moment().subtract(1, "month").startOf("month"),
                    moment().subtract(1, "month").endOf("month"),
                ],
                Default: [
                    moment("1 January 2017", "D MMMM YYYY"),
                    moment().add(10, "years"),
                ],
            },
            // startDate: moment(),
            startDate: moment().startOf("month"),
            endDate: moment(),
            minDate: "1 January 2017",
            // maxDate: moment().endOf("month"),
        },
        function (start, end) {
            $(".daterange-cus").html(
                start.format("D MMMM YYYY") + " - " + end.format("D MMMM YYYY")
            );
        }
    );

    // ====================================================================================
    // 3. Single Datepicker
    // ====================================================================================
    $("#addtanggal, #edittanggal").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        opens: "left",
        drops: "up",
        minYear: 2017,
        maxYear: parseInt(moment().add(10, "years").format("YYYY"), 10),
        locale: { format: "DD/MM/YYYY" },
    });
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
        label_data = [""],
        str_date = defStrDate,
        end_date = defEndDate
    ) {
        $.ajax({
            url:
                "tmasuk/tmasuk_ajax?page=" +
                page +
                "&sorttype=" +
                sort_type +
                "&sortby=" +
                sort_by +
                "&search=" +
                search +
                "&maxdata=" +
                max_data +
                "&labeldata=" +
                label_data +
                "&strdate=" +
                str_date +
                "&enddate=" +
                end_date,
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
        var label_selected = $("#label option:selected");
        var label_data = $("#label").val();
        if (label_selected.length < 1) {
            $("#label").multiselect("selectAll", false);
            $("#label").multiselect("updateButtonText");
            label_data = $("#label").val();
        }
        var str_date = defStrDate;
        var end_date = defEndDate;
        if (toggleStatus == true) {
            var dateString = $("#date_filter").val();
            var dateArray = dateString.split(" - ");
            str_date = moment(dateArray[0], "D MMMM YYYY").format("YYYY-MM-DD");
            end_date = moment(dateArray[1], "D MMMM YYYY").format("YYYY-MM-DD");
        }
        fetch_data(
            page,
            sort_type,
            column_name,
            search,
            max_data,
            label_data,
            str_date,
            end_date
        );
    }
    // ====================================================================================
    // 2. Search + Max Data + Label
    // ====================================================================================
    $(document).on("keyup change", "#search, #max_data, #label", function () {
        reloadPage();
    });
    // ====================================================================================
    // 3. Sorting
    // ====================================================================================
    $(document).on("click", ".tmasuk_sorting", function () {
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
        var label_selected = $("#label option:selected");
        var label_data = $("#label").val();
        if (label_selected.length < 1) {
            $("#label").multiselect("selectAll", false);
            $("#label").multiselect("updateButtonText");
            label_data = $("#label").val();
        }
        var str_date = defStrDate;
        var end_date = defEndDate;
        if (toggleStatus == true) {
            var dateString = $("#date_filter").val();
            var dateArray = dateString.split(" - ");
            str_date = moment(dateArray[0], "D MMMM YYYY").format("YYYY-MM-DD");
            end_date = moment(dateArray[1], "D MMMM YYYY").format("YYYY-MM-DD");
        }
        fetch_data(
            page,
            reverse_order,
            column_name,
            search,
            max_data,
            label_data,
            str_date,
            end_date
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
        var label_selected = $("#label option:selected");
        var label_data = $("#label").val();
        if (label_selected.length < 1) {
            $("#label").multiselect("selectAll", false);
            $("#label").multiselect("updateButtonText");
            label_data = $("#label").val();
        }
        var str_date = defStrDate;
        var end_date = defEndDate;
        if (toggleStatus == true) {
            var dateString = $("#date_filter").val();
            var dateArray = dateString.split(" - ");
            str_date = moment(dateArray[0], "D MMMM YYYY").format("YYYY-MM-DD");
            end_date = moment(dateArray[1], "D MMMM YYYY").format("YYYY-MM-DD");
        }
        fetch_data(
            page,
            sort_type,
            column_name,
            search,
            max_data,
            label_data,
            str_date,
            end_date
        );
    });
    // ====================================================================================
    // 5. Filter Date Toggle
    // ====================================================================================
    $("#date_toggle").on("change", function () {
        // Hidden toggle
        var div_date = $("#div_date");
        if (this.checked) {
            div_date.css("display", "block");
            toggleStatus = true;
        } else {
            div_date.css("display", "none");
            toggleStatus = false;
        }
        // Fetch data
        var search = $("#search").val();
        var column_name = $("#hidden_column_name").val();
        var sort_type = $("#hidden_sort_type").val();
        var page = $("#hidden_page").val();
        var max_data = $("#max_data option:selected").val();
        var label_selected = $("#label option:selected");
        var label_data = $("#label").val();
        if (label_selected.length < 1) {
            $("#label").multiselect("selectAll", false);
            $("#label").multiselect("updateButtonText");
            label_data = $("#label").val();
        }
        var str_date = defStrDate;
        var end_date = defEndDate;
        if (toggleStatus == true) {
            var dateString = $("#date_filter").val();
            var dateArray = dateString.split(" - ");
            str_date = moment(dateArray[0], "D MMMM YYYY").format("YYYY-MM-DD");
            end_date = moment(dateArray[1], "D MMMM YYYY").format("YYYY-MM-DD");
        }
        fetch_data(
            page,
            sort_type,
            column_name,
            search,
            max_data,
            label_data,
            str_date,
            end_date
        );
    });
    // ====================================================================================
    // 6. Filter Date
    // ====================================================================================
    $("#date_filter").on("change", function () {
        var search = $("#search").val();
        var column_name = $("#hidden_column_name").val();
        var sort_type = $("#hidden_sort_type").val();
        var page = $("#hidden_page").val();
        var max_data = $("#max_data option:selected").val();
        var label_selected = $("#label option:selected");
        var label_data = $("#label").val();
        if (label_selected.length < 1) {
            $("#label").multiselect("selectAll", false);
            $("#label").multiselect("updateButtonText");
            label_data = $("#label").val();
        }
        var str_date = defStrDate;
        var end_date = defEndDate;
        if (toggleStatus == true) {
            var dateString = $("#date_filter").val();
            var dateArray = dateString.split(" - ");
            str_date = moment(dateArray[0], "D MMMM YYYY").format("YYYY-MM-DD");
            end_date = moment(dateArray[1], "D MMMM YYYY").format("YYYY-MM-DD");
        }
        fetch_data(
            page,
            sort_type,
            column_name,
            search,
            max_data,
            label_data,
            str_date,
            end_date
        );
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
                "X-CSRF-TOKEN": $('input[name="_token"]').val(),
            },
        });
        let data = {
            name: $("#addname").val(),
            label: $("#addlabel").val(),
            nominal: $("#addnominal").val(),
            tanggal: $("#addtanggal").val(),
            _token: $('input[name="_token"]').val(),
        };
        $.ajax({
            type: "POST",
            url: "/tmasuk",
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
    $(document).on("click", "#btn-edit-tmasuk", function () {
        var id = $(this).data("id");

        $.ajax({
            url: "tmasuk/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("#editModal").modal("show");
                $("#editname").val(data.name);
                $("#editlabel").val(data.label);
                $("#editnominal").val(data.nominal);
                $("#edittanggal").val(
                    moment(data.tanggal, "YYYY-MM-DD").format("DD/MM/YYYY")
                );
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
        var id = $("#btn-edit-tmasuk").data("id");
        var nomor = $("#" + id)
            .find("#nomor")
            .text();
        let data = {
            name: $("#editname").val(),
            label: $("#editlabel").val(),
            nominal: $("#editnominal").val(),
            tanggal: $("#edittanggal").val(),
            _token: $('input[name="_token"][id="tokenEdit"]').val(),
        };
        $.ajax({
            url: "tmasuk/" + id,
            type: "PUT",
            data: data,
            success: function (data) {
                console.log(data);
                swal({
                    title: "Sukses!",
                    text: data.message,
                    icon: "success",
                    timer: 10000,
                });
                //data post
                let tmasuk =
                    `
                <tr class="text-center" id="${data.data.id}">
                <td>` +
                    nomor +
                    `</td>
                <td>${data.data.name}</td>
                <td>${data.data.label}</td>
                <td>Rp` +
                    data.data.nominal
                        .toString()
                        .split(/(?=(?:...)*$)/)
                        .join(".") +
                    `</td>
                <td>` +
                    moment(data.data.tanggal, "YYYY-MM-DD").format(
                        "DD/MM/YYYY"
                    ) +
                    `</td>
                <td class="text-center">
                    <a href="javascript:void(0)" id="btn-edit-tmasuk" data-id="${data.data.id}" class="btn btn-icon icon-left btn-primary" ><i class="far fa-edit"></i> Edit</a>
                    <a href="javascript:void(0)" id="btn-del-tmasuk" data-id="${data.data.id}" class="btn btn-icon icon-left btn-danger" ><i class="fas fa-trash"></i> Hapus</a>
                </td>
                </tr>
                `;
                //append to post data
                $(`#${data.data.id}`).replaceWith(tmasuk);
                $("#editModal").modal("hide");
                $("#editForm").trigger("reset");
                // location.reload();
            },
            error: function (data) {
                console.log(data);
                alert("Gagal mengubah data!");
            },
        });
    });

    // ====================================================================================
});
