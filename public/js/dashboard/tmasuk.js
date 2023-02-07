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
    $("#addtanggal").daterangepicker({
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
    // 1. Ajax Fetch Data
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
    // 2. Search + Max Data + Label
    // ====================================================================================
    $(document).on("keyup change", "#search, #max_data, #label", function () {
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
    // Ajax Add Data
    // ====================================================================================
    $("#btnadd").on("click", function () {
        console.log($("#addname").val());
        console.log($("#addlabel").val());
        console.log($("#addnominal").val());
        console.log($("#addtanggal").val());
    });
    // $("#btnadd").click(function (e) {
    //     e.preventDefault();

    //     //define variable
    //     let name = $("#addname").val();
    //     let label = $("#addlabel").val();
    //     let nominal = $("#addnominal").val();
    //     let tanggal = $("#addtanggal").val();
    //     let token = $("#csrf-token").val();

    //     //ajax
    //     // $.ajax({
    //     //     url: `/tmasuk/store_ajax`,
    //     //     type: "POST",
    //     //     cache: false,
    //     //     data: {
    //     //         name: name,
    //     //         label: label,
    //     //         nominal: nominal,
    //     //         tanggal: tanggal,
    //     //         _token: token,
    //     //     },
    //     //     success: function (response) {
    //     //         //show success message
    //     //         Swal.fire({
    //     //             type: "success",
    //     //             icon: "success",
    //     //             title: `${response.message}`,
    //     //             showConfirmButton: false,
    //     //             timer: 3000,
    //     //         });

    //     //         //data post
    //     //         let post = `
    //     //             <tr">
    //     //                 <td>${response.data.name}</td>
    //     //                 <td>${response.data.label}</td>
    //     //                 <td>${response.data.nominal}</td>
    //     //                 <td>${response.data.tanggal}</td>
    //     //                 <td class="text-center">
    //     //                     <a href="javascript:void(0)" id="btn-edit-post"" class="btn btn-primary btn-sm">EDIT</a>
    //     //                     <a href="javascript:void(0)" id="btn-delete-post"" class="btn btn-danger btn-sm">DELETE</a>
    //     //                 </td>
    //     //             </tr>
    //     //         `;

    //     //         //append to table
    //     //         $("#table-data").prepend(post);

    //     //         //clear form
    //     //         $("#addname").val("");
    //     //         $("#addlabel").val("");
    //     //         $("#addnominal").val("");
    //     //         $("#addtanggal").val("");

    //     //         //close modal
    //     //         $("#addmodal").modal("hide");
    //     //     },
    //     //     error: function (error) {
    //     //         if (error.responseJSON.title[0]) {
    //     //             //show alert
    //     //             $("#alert-title").removeClass("d-none");
    //     //             $("#alert-title").addClass("d-block");

    //     //             //add message to alert
    //     //             $("#alert-title").html(error.responseJSON.title[0]);
    //     //         }

    //     //         if (error.responseJSON.content[0]) {
    //     //             //show alert
    //     //             $("#alert-content").removeClass("d-none");
    //     //             $("#alert-content").addClass("d-block");

    //     //             //add message to alert
    //     //             $("#alert-content").html(error.responseJSON.content[0]);
    //     //         }
    //     //     },
    //     // });
    // });

    // ====================================================================================
});
