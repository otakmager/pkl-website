"use strict";

// ====================================================================================
// DatePicker
// ====================================================================================
$(".daterange-cus").daterangepicker(
    {
        opens: "left",
        drops: "up",
        locale: { format: "D MMMM YYYY" },
        ranges: {
            "Hari Ini": [moment(), moment()],
            Kemarin: [
                moment().subtract(1, "days"),
                moment().subtract(1, "days"),
            ],
            "Bulan Ini": [moment().startOf("month"), moment().endOf("month")],
            "Bulan Kemarin": [
                moment().subtract(1, "month").startOf("month"),
                moment().subtract(1, "month").endOf("month"),
            ],
            "Tahun Ini": [moment().startOf("year"), moment().endOf("year")],
            "Tahun Kemarin": [
                moment().subtract(1, "year").startOf("year"),
                moment().subtract(1, "year").endOf("year"),
            ],
            "Awal Tahun Sampai Bulan Ini": [
                moment().startOf("year"),
                moment().endOf("month"),
            ],
        },
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
// Multiselect
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
// Main Function
// ====================================================================================
$(document).ready(function () {
    $("#btn-download").on("click", function () {
        // Ajax setup
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $(
                    'input[name="_token"][id="tokenCommon"]'
                ).val(),
            },
        });
        // Make data container
        let data = {
            name: $("#name").val() + ".xlsx",
            // jenis: $("#format-laporan").val(),
            jenis: "tmasuk",
            _token: $('input[name="_token"][id="tokenCommon"]').val(),
        };
        // Testing
        console.log(data);
        // Ajax to request make file laporan
        $.ajax({
            type: "GET",
            url: "/download/format/excel",
            data: data,
            success: function (data) {
                if (data.success) {
                    console.log(data);
                } else {
                    console.log("data.error");
                    console.log(data);
                }
            },
            error: function (data) {
                console.log("error");
                console.log(data);
            },
        });
    });
});
