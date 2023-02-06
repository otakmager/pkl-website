// Menentukan data yang akan ditampilkan dalam grafik
const dataTahunan = {
    labels: [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ],
    datasets: [
        {
            label: "Pemasukan",
            data: [200, 300, 400, 500, 130, 900, 122, 912, 102, 239, 547, 342],
            backgroundColor: "#6777ef",
        },
        {
            label: "Pengeluaran",
            data: [150, 200, 300, 400, 500, 700, 121, 232, 454, 232, 434, 120],
            backgroundColor: "#fc544b",
        },
    ],
};
const dataBulanan = {
    labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
    datasets: [
        {
            label: "Pemasukan",
            data: [121, 312, 491, 172],
            backgroundColor: "#6777ef",
        },
        {
            label: "Pengeluaran",
            data: [101, 981, 121, 323],
            backgroundColor: "#fc544b",
        },
    ],
};
const dataMingguan = {
    labels: [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
    ],
    datasets: [
        {
            label: "Pemasukan",
            data: [121, 312, 491, 172, 101, 121, 101],
            backgroundColor: "#6777ef",
        },
        {
            label: "Pengeluaran",
            data: [101, 981, 121, 323, 112, 401, 212],
            backgroundColor: "#fc544b",
        },
    ],
};

// Menentukan opsi untuk grafik
const options = {
    legend: {
        display: false,
    },
    scales: {
        yAxes: [
            {
                gridLines: {
                    // display: false,
                    drawBorder: false,
                    color: "#f2f2f2",
                },
                ticks: {
                    beginAtZero: true,
                    stepSize: 100,
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

// Menampilkan grafik dalam canvas
const ctxTahunan = document.getElementById("myChart-tahunan").getContext("2d");
const chartTahunan = new Chart(ctxTahunan, {
    type: "bar",
    data: dataTahunan,
    options: options,
});
const ctxBulanan = document.getElementById("myChart-bulanan").getContext("2d");
const chartBulanan = new Chart(ctxBulanan, {
    type: "bar",
    data: dataBulanan,
    options: options,
});
const ctxMingguan = document.getElementById("myChart-week").getContext("2d");
const chartMingguan = new Chart(ctxMingguan, {
    type: "bar",
    data: dataMingguan,
    options: options,
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
