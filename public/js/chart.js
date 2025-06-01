const dataPrev = {
    2020: [
        ["kr", 9],
        ["MD", 12],
        ["au", 8],
        ["de", 17],
        ["HR", 19],
        ["LB", 26],
        ["BW", 27],
        ["RM", 46],
    ],
    2016: [
        ["kr", 13],
        ["MD", 7],
        ["au", 8],
        ["de", 11],
        ["HR", 20],
        ["LB", 38],
        ["BW", 29],
        ["RM", 47],
    ],
    2012: [
        ["kr", 13],
        ["MD", 9],
        ["au", 14],
        ["de", 16],
        ["HR", 24],
        ["LB", 48],
        ["BW", 19],
        ["RM", 36],
    ],
    2008: [
        ["kr", 9],
        ["MD", 17],
        ["au", 18],
        ["de", 13],
        ["HR", 29],
        ["LB", 33],
        ["BW", 9],
        ["RM", 37],
    ],
    2004: [
        ["kr", 8],
        ["MD", 5],
        ["au", 16],
        ["de", 13],
        ["HR", 32],
        ["LB", 28],
        ["BW", 11],
        ["RM", 37],
    ],
    2000: [
        ["kr", 7],
        ["MD", 3],
        ["au", 9],
        ["de", 20],
        ["HR", 26],
        ["LB", 16],
        ["BW", 1],
        ["RM", 44],
    ],
};

const data = {
    2020: [
        ["kr", 6],
        ["MD", 27],
        ["au", 17],
        ["de", 10],
        ["HR", 20],
        ["LB", 38],
        ["BW", 22],
        ["RM", 39],
    ],
    2016: [
        ["kr", 9],
        ["MD", 12],
        ["au", 8],
        ["de", 17],
        ["HR", 19],
        ["LB", 26],
        ["BW", 27],
        ["RM", 46],
    ],
    2012: [
        ["kr", 13],
        ["MD", 7],
        ["au", 8],
        ["de", 11],
        ["HR", 20],
        ["LB", 38],
        ["BW", 29],
        ["RM", 47],
    ],
    2008: [
        ["kr", 13],
        ["MD", 9],
        ["au", 14],
        ["de", 16],
        ["HR", 24],
        ["LB", 48],
        ["BW", 19],
        ["RM", 36],
    ],
    2004: [
        ["kr", 9],
        ["MD", 17],
        ["au", 18],
        ["de", 13],
        ["HR", 29],
        ["LB", 33],
        ["BW", 9],
        ["RM", 37],
    ],
    2000: [
        ["kr", 8],
        ["MD", 5],
        ["au", 16],
        ["de", 13],
        ["HR", 32],
        ["LB", 28],
        ["BW", 11],
        ["RM", 37],
    ],
};

const countries = {
    kr: {
        name: "Hewri Poah",
        color: "#E2BA76",
    },
    MD: {
        name: "Mendung",
        color: "#E2BA76",
    },
    au: {
        name: "Bumi",
        color: "#E2BA76",
    },
    de: {
        name: "Sains",
        color: "#E2BA76",
    },
    HR: {
        name: "Heriyadi",
        color: "#E2BA76",
    },
    LB: {
        name: "Laut Bergosip",
        color: "#E2BA76",
    },
    BW: {
        name: "Buwlan",
        color: "#E2BA76",
    },
    RM: {
        name: "Resep Masakan Ros",
        color: "#E2BA76",
    },
};

// Add upper case country code
for (const [key, value] of Object.entries(countries)) {
    value.ucCode = key.toUpperCase();
}

const getData = (data) =>
    data.map((point) => ({
        name: point[0],
        y: point[1],
        color: countries[point[0]].color,
    }));

const chart = Highcharts.chart("container", {
    chart: {
        type: "column",
        backgroundColor: "transparent",
    },
    credits: {
        enabled: false,
    },
    // Custom option for templates
    countries,
    title: {
        text: "Gdebook 2020 - Top 5 popular books",
        align: "left",
        style: {
            color: "#e0dbc0",
        },
    },
    subtitle: {
        text: "Lorem Ipsum dolor sit amet, consectetur adipiscing elit. (subtitle)",
        align: "left",
        style: {
            color: "#e0dbc0",
        },
    },
    plotOptions: {
        series: {
            grouping: false,
            borderWidth: 0,
        },
    },
    legend: {
        enabled: false,
    },
    tooltip: {
        shared: true,
        headerFormat:
            '<span style="font-size: 15px">' +
            "{series.chart.options.countries.(point.key).name}" +
            "</span><br/>",
        pointFormat:
            '<span style="color:{point.color}">\u25CF</span> ' +
            "{series.name}: <b>{point.y} loans</b><br/>",
    },
    xAxis: {
        type: "category",
        accessibility: {
            description: "Countries",
        },
        max: 4,
        labels: {
            useHTML: true,
            animate: true,
            format:
                "{chart.options.countries.(value).ucCode}<br>" +
                '<span class="f32">' +
                '<span style="display:inline-block;height:32px;',
            style: {
                textAlign: "center",
                color: "#e0dbc0",
            },
        },
    },
    yAxis: [
        {
            title: {
                text: "Total Loans",
                style: {
                    color: "#e0dbc0",
                },
            },
            labels: {
                style: {
                    color: "#e0dbc0",
                },
            },
            showFirstLabel: false,
        },
    ],

    series: [
        {
            color: "rgba(158, 159, 163, 0.5)",
            pointPlacement: -0.2,
            linkedTo: "main",
            data: dataPrev[2020].slice(),
            name: "2016",
        },
        {
            name: "2020",
            id: "main",
            dataSorting: {
                enabled: true,
                matchByName: true,
            },
            dataLabels: [
                {
                    enabled: true,
                    inside: true,
                    style: {
                        fontSize: "16px",
                    },
                },
            ],
            data: getData(data[2020]).slice(),
        },
    ],
    exporting: {
        // allowHTML: true,
        enabled: false,
    },
});

const years = [2020, 2016, 2012, 2008, 2004, 2000];

years.forEach((year) => {
    const btn = document.getElementById(year);

    btn.addEventListener("click", () => {
        document
            .querySelectorAll(".buttons button.active")
            .forEach((active) => {
                active.className = "";
            });
        btn.className = "active";

        chart.update(
            {
                title: {
                    text: "Gdebook " + year + " - Top 5 popular books",
                },
                subtitle: {
                    text: "Lorem Ipsum dolor sit amet, consectetur adipiscing elit. (subtitle)",
                },
                series: [
                    {
                        name: year - 4,
                        data: dataPrev[year].slice(),
                    },
                    {
                        name: year,
                        data: getData(data[year]).slice(),
                    },
                ],
            },
            true,
            false,
            {
                duration: 800,
            }
        );
    });
});
