document.addEventListener("DOMContentLoaded", function () {
    if (typeof chartData === "undefined") return;

    Highcharts.chart("container", {
        chart: { type: "column", backgroundColor: "transparent" },
        credits: { enabled: false },
        title: {
            text: "Top 5 Most Borrowed Books",
            align: "left",
            style: { color: "#e0dbc0" },
        },
        xAxis: {
            type: "category",
            labels: { style: { color: "#e0dbc0" } },
        },
        yAxis: [
            {
                title: { text: "Total Loans", style: { color: "#e0dbc0" } },
                labels: { style: { color: "#e0dbc0" } },
                showFirstLabel: false,
            },
        ],
        legend: { enabled: false },
        tooltip: {
            pointFormat:
                '<span style="color:{point.color}">\u25CF</span> <b>{point.y} loans</b><br/>',
        },
        series: [
            {
                name: "Loans",
                data: chartData,
                color: "#E2BA76",
                dataLabels: {
                    enabled: false,
                    // enabled: true,
                    // inside: true,
                    // style: { fontSize: "16px" },
                },
            },
        ],
        exporting: { enabled: false },
    });
});
