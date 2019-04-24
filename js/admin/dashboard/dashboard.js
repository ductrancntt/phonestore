(function ($) {

    let currentDate = new Date();

    let earningsOverviewChart = null;

    let earningsProportionChart = null;

    Chart.defaults.global.defaultFontFamily = 'Segoe UI';

    $.get("/api/employees/total-employees", function (response) {
        $("#total-employees").text(response);
    });

    $.get("/api/customers/total-customers", function (response) {
        $("#total-customers").text(response);
    });

    $.get("/api/invoices/earnings-monthly", function (response) {
        if (response.length == 0)
            $("#earnings-monthly").text("0 ₫");
        else
            $("#earnings-monthly").text(formatNumber(response) + " ₫");
    });

    $.get("/api/invoices/earnings-annual", function (response) {
        if (response.length == 0)
            $("#earnings-annual").text("0 ₫");
        else
            $("#earnings-annual").text(formatNumber(response) + " ₫");
    });

    let renderEarningsOverviewMonthChart = function () {
        $.get("/api/invoices/earnings-current-month", function (response) {
            let labels = [];
            let data = [];
            let backgroundColor = [];
            let borderColor = []
            response.forEach(function (ele) {
                labels.push(ele.colName);
                data.push(ele.total / 1000000);
                let r = Math.floor(Math.random() * 255);
                let g = Math.floor(Math.random() * 255);
                let b = Math.floor(Math.random() * 255);
                backgroundColor.push("rgba(" + r + "," + g + "," + b + ",0.3)");
                borderColor.push("rgba(" + r + "," + g + "," + b + ",1)");
            });

            earningsOverviewChart = new Chart($("#earnings-overview-chart"), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Earnings',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Earnings In ' + (currentDate.getMonth() + 1) + "/" + (currentDate.getFullYear())
                    },
                    legend: {
                        onClick: (e) => e.stopPropagation()
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Total (million VND)'
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Day in Month'
                            }
                        }]
                    }
                }
            });
        });
    }

    let renderEarningOverviewYearChart = function () {
        $.get("/api/invoices/earnings-current-year", function (response) {
            let labels = [];
            let data = [];
            let backgroundColor = [];
            let borderColor = [];
            response.forEach(function (ele) {
                labels.push(ele.colName);
                data.push(ele.total / 1000000);
                let r = Math.floor(Math.random() * 255);
                let g = Math.floor(Math.random() * 255);
                let b = Math.floor(Math.random() * 255);
                backgroundColor.push("rgba(" + r + "," + g + "," + b + ",0.3)");
                borderColor.push("rgba(" + r + "," + g + "," + b + ",1)");
            });

            earningsOverviewChart = new Chart($("#earnings-overview-chart"), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Earnings',
                        data: data,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Earnings In ' + currentDate.getFullYear()
                    },
                    legend: {
                        onClick: (e) => e.stopPropagation()
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Total (million VND)'
                            },
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Month in Year'
                            }
                        }]
                    }
                }
            });
        });
    }

    let renderStoreProportionMonthChart = function () {
        $.get("/api/invoices/store-proportion-current-month", function (response) {
            let labels = [];
            let data = [];
            let backgroundColor = [];
            let borderColor = [];
            let total = 0;
            response.forEach(function (ele) {
                labels.push(ele.storeName);
                total += ele.total;
                data.push(ele.total);
                let r = Math.floor(Math.random() * 255);
                let g = Math.floor(Math.random() * 255);
                let b = Math.floor(Math.random() * 255);
                backgroundColor.push("rgba(" + r + "," + g + "," + b + ",0.3)");
                borderColor.push("rgba(" + r + "," + g + "," + b + ",1)");
            });

            earningsProportionChart = new Chart($("#earning-proportion-chart"), {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        data: data
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Earning Proportion In ' + (currentDate.getMonth() + 1) + "/" + (currentDate.getFullYear())
                    },
                    legend: {
                        onClick: (e) => e.stopPropagation()
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                return data['labels'][tooltipItem['index']] + ': ' + (data['datasets'][0]['data'][tooltipItem['index']] * 100 / total).toFixed(2) + '%';
                            }
                        }
                    }
                }
            });
        });
    }

    let renderStoreProportionYearChart = function () {
        $.get("/api/invoices/store-proportion-current-year", function (response) {
            let labels = [];
            let data = [];
            let backgroundColor = [];
            let borderColor = [];
            let total = 0;
            response.forEach(function (ele) {
                labels.push(ele.storeName);
                total += ele.total;
                data.push(ele.total);
                let r = Math.floor(Math.random() * 255);
                let g = Math.floor(Math.random() * 255);
                let b = Math.floor(Math.random() * 255);
                backgroundColor.push("rgba(" + r + "," + g + "," + b + ",0.3)");
                borderColor.push("rgba(" + r + "," + g + "," + b + ",1)");
            });

            earningsProportionChart = new Chart($("#earning-proportion-chart"), {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        data: data
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Earning Proportion In ' + (currentDate.getFullYear())
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                return data['labels'][tooltipItem['index']] + ': ' + (data['datasets'][0]['data'][tooltipItem['index']] * 100 / total).toFixed(2) + '%';
                            }
                        }
                    }
                }
            });
        });
    }

    $("#earning-this-month-chart").click(function () {
        if (earningsOverviewChart != null)
            earningsOverviewChart.destroy();

        $("#earnings-overview-chart").empty();

        renderEarningsOverviewMonthChart();
    });

    $("#earning-this-year-chart").click(function () {
        if (earningsOverviewChart != null)
            earningsOverviewChart.destroy();

        $("#earnings-overview-chart").empty();

        renderEarningOverviewYearChart();
    });

    $("#store-proportion-this-month").click(function () {
        if (earningsProportionChart != null)
            earningsProportionChart.destroy();

        $("#earning-proportion-chart").empty();

        renderStoreProportionMonthChart();
    });

    $("#store-proportion-this-year").click(function () {
        if (earningsProportionChart != null)
            earningsProportionChart.destroy();

        $("#earning-proportion-chart").empty();

        renderStoreProportionYearChart();
    });

    renderEarningsOverviewMonthChart();

    renderStoreProportionMonthChart();

})(jQuery);