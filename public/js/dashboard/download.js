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
// Toggle change button name to download
// ====================================================================================
$("#jenis").on("change", function () {
    var formatFile = $(this).val();
    var downloadBtn = $("#btn-download");

    if (formatFile == "excel") {
        downloadBtn.text("Download Excel");
        downloadBtn.removeClass("btn-warning").addClass("btn-success");
    } else if (formatFile == "pdf") {
        downloadBtn.text("Download PDF");
        downloadBtn.removeClass("btn-success").addClass("btn-warning");
    }
});
// ====================================================================================
// Main Function
// ====================================================================================
$(document).ready(function () {
    $("#download-form").on("submit", function (event) {
        event.preventDefault();
        // Set URL with custom data as query string
        let url = "/download/format/excel?";
        url += "name=" + $("#name").val() + ".xlsx";
        url += "&jenis=tmasuk";
        url += "&_token=" + $('input[name="_token"][id="tokenCommon"]').val();

        // Open new tab with URL
        window.open(url, "_blank");
    });
});
