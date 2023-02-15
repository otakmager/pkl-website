$(document).ready(function () {
    $.ajax({
        url: "/dashboard/dashboardData",
        type: "GET",
        success: function (data) {
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
            $("#sisaUang").text(
                "Rp " +
                    data["sisaUang"]
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
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var value =
                                data.datasets[tooltipItem.datasetIndex].data[
                                    tooltipItem.index
                                ];
                            value = value.toString();
                            value = value.split(/(?=(?:...)*$)/);
                            value = value.join(".");
                            return "Pemasukan: Rp " + value + ",00";
                        },
                    },
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
            // ====================================================================================
            // Grafik Pie Chart
            // ====================================================================================
            var ctx = document.getElementById("myChart-pie").getContext("2d");
            var myPieChart = new Chart(ctx, {
                type: "pie",
                data: {
                    datasets: [
                        {
                            data: [
                                data["chartMasukTahun"],
                                data["chartKeluarTahun"],
                            ],
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
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var label = data.labels[tooltipItem.index];
                                var value =
                                    data.datasets[0].data[tooltipItem.index];
                                return (
                                    label +
                                    ": Rp " +
                                    value
                                        .toString()
                                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",") +
                                    ",00"
                                );
                            },
                        },
                    },
                },
            });
            function updatePieChart(dataMasuk, dataKeluar) {
                myPieChart.data.datasets[0].data = [dataMasuk, dataKeluar];
                myPieChart.update();
            }
            $("#btnChartBulan").click(function () {
                updatePieChart(
                    data["chartMasukBulan"],
                    data["chartKeluarBulan"]
                );
                $("#btnChartBulan")
                    .removeClass("btn-light")
                    .addClass("btn-primary");
                $("#btnChartMinggu")
                    .removeClass("btn-primary")
                    .addClass("btn-light");
                $("#btnChartTahun")
                    .removeClass("btn-primary")
                    .addClass("btn-light");
            });
            $("#btnChartMinggu").click(function () {
                updatePieChart(
                    data["chartMasukMinggu"],
                    data["chartKeluarMinggu"]
                );
                $("#btnChartMinggu")
                    .removeClass("btn-light")
                    .addClass("btn-primary");
                $("#btnChartBulan")
                    .removeClass("btn-primary")
                    .addClass("btn-light");
                $("#btnChartTahun")
                    .removeClass("btn-primary")
                    .addClass("btn-light");
            });
            $("#btnChartTahun").click(function () {
                updatePieChart(
                    data["chartMasukTahun"],
                    data["chartKeluarTahun"]
                );
                $("#btnChartMinggu")
                    .removeClass("btn-primary")
                    .addClass("btn-light");
                $("#btnChartBulan")
                    .removeClass("btn-primary")
                    .addClass("btn-light");
                $("#btnChartTahun")
                    .removeClass("btn-light")
                    .addClass("btn-primary");
            });
            // ====================================================================================
            // Top 5 Label Pemasukan
            // ====================================================================================
            $(".lb-masuk").on("click", function () {
                // Menghapus kelas active dari semua item
                $(".lb-masuk").removeClass("active");
                // Menambahkan kelas active pada item yang dipilih
                $(this).addClass("active");
                // Mengubah teks pada #chooseLabelMasuk dengan teks dari item yang dipilih
                $("#chooseLabelMasuk").text($(this).text());
            });
            // ====================================================================================
            // Top 5 Label Pengeluaran
            // ====================================================================================
            $(".lb-keluar").on("click", function () {
                // Menghapus kelas active dari semua item
                $(".lb-keluar").removeClass("active");
                // Menambahkan kelas active pada item yang dipilih
                $(this).addClass("active");
                // Mengubah teks pada #chooseLabelKeluar dengan teks dari item yang dipilih
                $("#chooseLabelKeluar").text($(this).text());
            });
            // ====================================================================================
            // Default Top 5 Label Pemasukan
            // ====================================================================================
            var labelMasukThisMonth = data["labelMasukThisMonth"];
            var totalMasukThisMonth = data["totalMasukThisMonth"];
            console.log(labelMasukThisMonth);
            console.log(totalMasukThisMonth);
            populateCardBody("in", labelMasukThisMonth, totalMasukThisMonth);
            // ====================================================================================
            // Default Top 5 Label Pengeluaran
            // ====================================================================================
            var labelKeluarThisMonth = data["labelKeluarThisMonth"];
            var totalKeluarThisMonth = data["totalKeluarThisMonth"];
            console.log(labelKeluarThisMonth);
            console.log(totalKeluarThisMonth);
            populateCardBody("out", labelKeluarThisMonth, totalKeluarThisMonth);
        },
    });
});
// ====================================================================================
// Diluar Document on Ready
// ====================================================================================
// Fungsi untuk mengisi card-body dengan data label dan total
function populateCardBody(tipe, labels, totals) {
    if (tipe === "in") {
        var cardBody = $("#ul-masuk");
    } else {
        var cardBody = $("#ul-keluar");
    }
    cardBody.empty();

    if (labels.length == 0 || totals.length == 0) {
        cardBody.html("<p>Belum ada data label</p>");
    } else {
        for (var i = 0; i < labels.length && i < totals.length; i++) {
            var listItem = $("<li>").addClass("media");
            var img = $("<img>")
                .addClass("mr-3 rounded")
                .attr("width", "55")
                .attr("src", "img/label/" + (i + 1) + ".png")
                .attr("alt", "product");
            var mediaBody = $("<div>").addClass("media-body");
            var mediaTitle = $("<div>").addClass("media-title").text(labels[i]);
            var mt1 = $("<div>").addClass("mt-1");
            var budgetPriceLabel = $("<div>")
                .addClass("budget-price-label")
                .text("Rp" + formatNumber(totals[i]));

            mt1.append(budgetPriceLabel);
            mediaBody.append(mediaTitle);
            mediaBody.append(mt1);
            listItem.append(img);
            listItem.append(mediaBody);
            cardBody.append(listItem);
        }
    }
}

// Fungsi untuk memformat angka menjadi format uang
function formatNumber(number) {
    return new Intl.NumberFormat("id-ID").format(number);
}
