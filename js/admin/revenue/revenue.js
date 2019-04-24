(function ($) {

    let startDate = null;
    let endDate = null;

    let revenueHaNoiStoreChart = null;
    let revenueHoChiMinhStoreChart = null;
    let soldProportionChart = null;
    let revenueProportionChart = null;

    let totalRevenueHaNoiStore = 0;
    let totalRevenueHoChiMinhStore = 0;
    let totalSoldHaNoiStore = 0;
    let totalSoldHoChiMinhStore = 0;

    let storeLabels = ['Ha Noi Store', 'Ho Chi Minh Store'];

    let soldProductColor = ["#ff9f40", "#4bc0c0"];
    let revenueProportionColor = ["#ffcd56", "#36a2eb"];

    Chart.defaults.global.defaultFontFamily = 'Segoe UI';

    $("#date-range-picker").daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $("#date-range-picker").on('apply.daterangepicker', function (ev, picker) {
        startDate = picker.startDate.format('DD/MM/YYYY');
        endDate = picker.endDate.format('DD/MM/YYYY');
        $(this).val(startDate + ' ~ ' + endDate);
    });

    $("#date-range-picker").on('cancel.daterangepicker', function (ev, picker) {
        startDate = null;
        endDate = null;
        $(this).val('');
    });

    let renderRevenueHaNoiStoreChart = function () {
        $.get("/api/store-revenue-statistic", {
            storeId: 1,
            startDate: startDate,
            endDate: endDate
        }, function (response) {
            let labels = [];
            let revenueData = [];
            let soldProductsData = [];

            response.listRevenue.forEach(function (ele) {
                labels.push(ele.colName);
                revenueData.push(ele.total / 1000000);
                totalRevenueHaNoiStore += ele.total / 1000000;
            });

            response.listSoldProduct.forEach(function (ele) {
                soldProductsData.push(ele.total);
                totalSoldHaNoiStore += ele.total;
            });

            revenueHaNoiStoreChart = new Chart($("#ha-noi-revenue"), {
                type: 'bar',
                data: {
                    datasets: [{
                        label: 'Sold Product',
                        data: soldProductsData,
                        yAxisID: 'soldProductAxis',
                        type: 'line',
                        backgroundColor: "#36a2eb",
                        borderColor: "#36a2eb",
                        fill: false
                    }, {
                        label: 'Revenue',
                        yAxisID: 'revenueAxis',
                        data: revenueData,
                        backgroundColor: "#ff638459",
                        borderColor: "#ff638459",
                        type: "bar"
                    }],
                    labels: labels
                },
                options: {
                    title: {
                        display: true,
                        text: 'Statistic from ' + labels[0] + ' to ' + labels[labels.length - 1]
                    },
                    legend: {
                        onClick: (e) => e.stopPropagation()
                    },
                    // elements: {
                    //     line: {
                    //         tension: 0
                    //     }
                    // },
                    scales: {
                        yAxes: [{
                            id: 'revenueAxis',
                            gridLines: {
                                display: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Revenue (million VND)'
                            },
                            ticks: {
                                stepSize: 10,
                                beginAtZero: true,
                                callback: function (tickValue, index, ticks) {
                                    if (!(index % parseInt(ticks.length / 10))) {
                                        return tickValue;
                                    }
                                }
                            }
                        }, {
                            id: 'soldProductAxis',
                            gridLines: {
                                display: false
                            },
                            type: 'linear',
                            position: 'right',
                            scaleLabel: {
                                display: true,
                                labelString: 'Total Sold Product (pcs)'
                            },
                            ticks: {
                                stepSize: 2,
                                beginAtZero: true,
                                callback: function (tickValue, index, ticks) {
                                    if (!(index % parseInt(ticks.length / 10))) {
                                        return tickValue;
                                    }
                                }
                            }
                        }],
                        xAxes: [{
                            barPercentage: 0.5,
                            scaleLabel: {
                                display: true,
                                labelString: 'Day in Month'
                            }
                        }]
                    }
                }
            });

            renderRevenueHoChiMinhStoreChart();
        });
    }

    let renderRevenueHoChiMinhStoreChart = function () {
        $.get("/api/store-revenue-statistic", {
            storeId: 2,
            startDate: startDate,
            endDate: endDate
        }, function (response) {
            let labels = [];
            let revenueData = [];
            let soldProductsData = [];

            response.listRevenue.forEach(function (ele) {
                labels.push(ele.colName);
                revenueData.push(ele.total / 1000000);
                totalRevenueHoChiMinhStore += ele.total / 1000000;
            });

            response.listSoldProduct.forEach(function (ele) {
                soldProductsData.push(ele.total);
                totalSoldHoChiMinhStore += ele.total;
            });

            revenueHoChiMinhStoreChart = new Chart($("#ho-chi-minh-revenue"), {
                type: 'bar',
                data: {
                    datasets: [{
                        label: 'Sold Product',
                        data: soldProductsData,
                        yAxisID: 'soldProductAxis',
                        type: 'line',
                        backgroundColor: "#36a2eb",
                        borderColor: "#36a2eb",
                        fill: false
                    }, {
                        label: 'Revenue',
                        yAxisID: 'revenueAxis',
                        data: revenueData,
                        backgroundColor: "#ff638459",
                        borderColor: "#ff638459",
                        type: "bar"
                    }],
                    labels: labels
                },
                options: {
                    title: {
                        display: true,
                        text: 'Statistic from ' + labels[0] + ' to ' + labels[labels.length - 1]
                    },
                    legend: {
                        onClick: (e) => e.stopPropagation()
                    },
                    // elements: {
                    //     line: {
                    //         tension: 0
                    //     }
                    // },
                    scales: {
                        yAxes: [{
                            id: 'revenueAxis',
                            gridLines: {
                                display: false
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Revenue (million VND)'
                            },
                            ticks: {
                                stepSize: 10,
                                beginAtZero: true,
                                callback: function (tickValue, index, ticks) {
                                    if (!(index % parseInt(ticks.length / 10))) {
                                        return tickValue;
                                    }
                                }
                            }
                        }, {
                            id: 'soldProductAxis',
                            gridLines: {
                                display: false
                            },
                            type: 'linear',
                            position: 'right',
                            scaleLabel: {
                                display: true,
                                labelString: 'Total Sold Product (pcs)'
                            },
                            ticks: {
                                stepSize: 2,
                                beginAtZero: true,
                                callback: function (tickValue, index, ticks) {
                                    if (!(index % parseInt(ticks.length / 10))) {
                                        return tickValue;
                                    }
                                }
                            }
                        }],
                        xAxes: [{
                            barPercentage: 0.5,
                            scaleLabel: {
                                display: true,
                                labelString: 'Day in Month'
                            }
                        }]
                    }
                }
            });

            renderSoldProportionChart();
            renderRevenueProportionChart();
        });
    }

    let renderSoldProportionChart = function () {
        let total = totalSoldHaNoiStore + totalSoldHoChiMinhStore;
        let data = [totalSoldHaNoiStore, totalSoldHoChiMinhStore];
        soldProportionChart = new Chart($("#sold-proportion"), {
            type: 'pie',
            data: {
                labels: storeLabels,
                datasets: [{
                    backgroundColor: soldProductColor,
                    borderColor: soldProductColor,
                    data: data
                }]
            },
            options: {
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
    }

    let renderRevenueProportionChart = function () {
        let total = totalRevenueHaNoiStore + totalRevenueHoChiMinhStore;
        let data = [totalRevenueHaNoiStore, totalRevenueHoChiMinhStore];
        revenueProportionChart = new Chart($("#revenue-proportion"), {
            type: 'pie',
            data: {
                labels: storeLabels,
                datasets: [{
                    backgroundColor: revenueProportionColor,
                    borderColor: revenueProportionColor,
                    data: data
                }]
            },
            options: {
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
    }

    $("#analyze-button").click(function () {
        if (revenueHaNoiStoreChart != null) {
            revenueHaNoiStoreChart.destroy();
            revenueHoChiMinhStoreChart.destroy();
            soldProportionChart.destroy();
            revenueProportionChart.destroy();

            $("#ha-noi-revenue").empty();
            $("#ho-chi-minh-revenue").empty();
            $("#sold-proportion").empty();
            $("#revenue-proportion").empty();

            renderRevenueHaNoiStoreChart();
        }
    });

    renderRevenueHaNoiStoreChart();

})(jQuery);