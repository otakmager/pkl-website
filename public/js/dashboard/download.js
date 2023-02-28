"use strict";
// ====================================================================================
// Default Date
// ====================================================================================
const defStrDate = moment().startOf("year");
const defEndDate = moment().endOf("month");
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
// Make URL Function
// ====================================================================================
function makeURL(
    url,
    name,
    formatLaporan,
    label = [],
    str_date = defStrDate,
    end_date = defEndDate,
    token
) {
    url += "name=" + name;
    url += "&formatLaporan=" + formatLaporan;
    url += "&label=" + label;
    url += "&str_date=" + str_date;
    url += "&end_date=" + end_date;
    url += "&_token=" + token;
    return url;
}
// ====================================================================================
// Main Function
// ====================================================================================
$(document).ready(function () {
    $("#download-form").on("submit", function (event) {
        event.preventDefault();

        // Preprocessing data
        let dateString = $("#tanggal").val();
        let dateArray = dateString.split(" - ");
        let str_date = moment(dateArray[0], "D MMMM YYYY").format("YYYY-MM-DD");
        let end_date = moment(dateArray[1], "D MMMM YYYY").format("YYYY-MM-DD");

        // Get data
        let name = $("#name").val();
        let jenis = $("#jenis").val();
        let formatLaporan = $("#format-laporan").val();
        let label = $("#label").val();
        let token = $('input[name="_token"][id="tokenCommon"]').val();

        // Set URL
        let url = "/download?";
        if (jenis == "excel") {
            url = "/download/format/excel?";
            name += ".xlsx";
        } else if (jenis == "pdf") {
            url = "/download/format/pdf?";
            name += ".pdf";
        }
        url = makeURL(
            url,
            name,
            formatLaporan,
            label,
            str_date,
            end_date,
            token
        );

        // Open new tab with URL
        window.open(url, "_blank");
    });
});
