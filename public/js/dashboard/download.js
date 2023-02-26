"use strict";

// Setting format tanggal dan interaksi
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
