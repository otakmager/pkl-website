"use strict";

// Setting format tanggal dan interaksi
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
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [
                moment().subtract(1, "month").startOf("month"),
                moment().subtract(1, "month").endOf("month"),
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
