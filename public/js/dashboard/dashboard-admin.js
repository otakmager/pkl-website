$(document).ready(function () {
    console.log("hi");
    $.ajax({
        url: "/dashboard/dashboardData",
        type: "GET",
        success: function (data) {
            // console.log(data);
            // ====================================================================================
            // Info Hari Ini
            // ====================================================================================
            $("#masukHari").text(
                "Rp " +
                    data["masukHari"]
                        .toString()
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ".") +
                    ",00"
            );
            $("#keluarHari").text(
                "Rp " +
                    data["keluarHari"]
                        .toString()
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ".") +
                    ",00"
            );
            // ====================================================================================
            // Setting Option Grafik
            // ====================================================================================
            // Menentukan opsi untuk grafik
            const options = {
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                color: "#f2f2f2",
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function (value, index, values) {
                                    return "Rp" + value;
                                },
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                display: false,
                                tickMarkLength: 15,
                            },
                        },
                    ],
                },
            };
            // ====================================================================================
            // Grafik 1 Tahun Terakhir
            // ====================================================================================
            const dataTahunan = {
                labels: data["labelSetahun"],
                datasets: [
                    {
                        label: "Pemasukan",
                        data: data["dataMasukSetahun"],
                        backgroundColor: "#6777ef",
                    },
                    {
                        label: "Pengeluaran",
                        data: data["dataKeluarSetahun"],
                        backgroundColor: "#fc544b",
                    },
                ],
            };
            const ctxTahunan = document
                .getElementById("myChart-tahunan")
                .getContext("2d");
            const chartTahunan = new Chart(ctxTahunan, {
                type: "bar",
                data: dataTahunan,
                options: options,
            });
            // ====================================================================================
            // Grafik 4 week alias
            // ====================================================================================
            const data4Week = {
                labels: data["label4Week"],
                datasets: [
                    {
                        label: "Pemasukan",
                        data: data["dataMasuk4Week"],
                        backgroundColor: "#6777ef",
                    },
                    {
                        label: "Pengeluaran",
                        data: data["dataKeluar4Week"],
                        backgroundColor: "#fc544b",
                    },
                ],
            };
            const ctx4Week = document
                .getElementById("myChart-4Week")
                .getContext("2d");
            const chart4Week = new Chart(ctx4Week, {
                type: "bar",
                data: data4Week,
                options: options,
            });
            // ====================================================================================
            // Grafik Seminggu
            // ====================================================================================
            const dataSeminggu = {
                labels: data["labelSeminggu"],
                datasets: [
                    {
                        label: "Pemasukan",
                        data: data["dataMasukSeminggu"],
                        backgroundColor: "#6777ef",
                    },
                    {
                        label: "Pengeluaran",
                        data: data["dataKeluarSeminggu"],
                        backgroundColor: "#fc544b",
                    },
                ],
            };
            const ctxSeminggu = document
                .getElementById("myChart-Seminggu")
                .getContext("2d");
            const chartSeminggu = new Chart(ctxSeminggu, {
                type: "bar",
                data: dataSeminggu,
                options: options,
            });
        },
    });
});

// Pie Chart
var ctx = document.getElementById("myChart-pie").getContext("2d");
var myChart = new Chart(ctx, {
    type: "pie",
    data: {
        datasets: [
            {
                data: [1080, 2048],
                backgroundColor: ["#6777ef", "#fc544b"],
                label: "Dataset 1",
            },
        ],
        labels: ["Pemasukan", "Pengeluaran"],
    },
    options: {
        responsive: true,
        legend: {
            position: "bottom",
        },
    },
});
