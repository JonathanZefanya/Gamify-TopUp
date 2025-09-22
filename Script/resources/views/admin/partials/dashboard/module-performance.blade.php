<div class="card mb-3 mb-lg-5">
    <div class="row col-lg-divider">
        <div class="col-lg-4" id="topUpOrderRecord">
            <div class="card-body">
                <h4>@lang('Total Direct Top Order')
                </h4>
                <div class="row align-items-sm-center mt-4 mt-sm-0 mb-5">
                    <div class="col-sm mb-3 mb-sm-0">
                        <span class="display-5 text-dark me-2 totalTopUpOrderCount"></span>
                    </div>
                </div>
                <div class="chartjs-custom mb-4 bar-chart-height">
                    <canvas class="" id="chartTopUpOrderRecordsGraph">
                    </canvas>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <span class="legend-indicator"></span> @lang('Yesterday')
                    </div>
                    <div class="col-auto">
                        <span class="legend-indicator bg-primary"></span> @lang('Today')
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4" id="cardOrderRecord">
            <div class="card-body">
                <h4>@lang('Total Card Order')</h4>

                <div class="row align-items-sm-center mt-4 mt-sm-0 mb-5">
                    <div class="col-sm mb-3 mb-sm-0">
                        <span class="display-5 text-dark me-2 totalCardOrderCount"></span>
                    </div>
                </div>
                <div class="chartjs-custom mb-4 bar-chart-height">
                    <canvas class="" id="chartCardOrderRecordsGraph">
                    </canvas>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <span class="legend-indicator"></span> @lang('Yesterday')
                    </div>
                    <div class="col-auto">
                        <span class="legend-indicator bg-primary"></span> @lang('Today')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4" id="addFundRecord">
            <div class="card-body">
                <h4>@lang('Total Add Fund')</h4>

                <div class="row align-items-sm-center mt-4 mt-sm-0 mb-5">
                    <div class="col-sm mb-3 mb-sm-0">
                        <span class="display-5 text-dark me-2 totalAddFundCount"></span>
                    </div>
                </div>
                <div class="chartjs-custom mb-4 bar-chart-height">
                    <canvas class="" id="chartAddFundRecordsGraph">
                    </canvas>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <span class="legend-indicator"></span> @lang('Yesterday')
                    </div>
                    <div class="col-auto">
                        <span class="legend-indicator bg-primary"></span> @lang('Today')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        Notiflix.Block.standard('#topUpOrderRecord');
        HSCore.components.HSChartJS.init(document.querySelector('#chartTopUpOrderRecordsGraph'), {
            type: "line",
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: "transparent",
                    borderColor: "#377dff",
                    borderWidth: 2,
                    pointRadius: 0,
                    hoverBorderColor: "#377dff",
                    pointBackgroundColor: "#377dff",
                    pointBorderColor: "#fff",
                    pointHoverRadius: 0,
                    tension: 0.4
                },
                    {
                        data: [],
                        backgroundColor: "transparent",
                        borderColor: "#e7eaf3",
                        borderWidth: 2,
                        pointRadius: 0,
                        hoverBorderColor: "#e7eaf3",
                        pointBackgroundColor: "#e7eaf3",
                        pointBorderColor: "#fff",
                        pointHoverRadius: 0,
                        tension: 0.4
                    }]
            },
            options: {
                scales: {
                    y: {
                        grid: {
                            color: "#e7eaf3",
                            drawBorder: false,
                            zeroLineColor: "#e7eaf3"
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 100,
                            color: "#97a4af",
                            font: {
                                size: 12,
                                family: "Open Sans, sans-serif"
                            },
                            padding: 10,
                            prefix: "$",
                            postfix: "k"
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: "#97a4af",
                            font: {
                                size: 12,
                                family: "Open Sans, sans-serif"
                            },
                            padding: 5
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        prefix: "",
                        postfix: "",
                        hasIndicator: true,
                        mode: "index",
                        intersect: false,
                        lineMode: true,
                        lineWithLineColor: "rgba(19, 33, 68, 0.075)"
                    }
                },
                hover: {
                    mode: "nearest",
                    intersect: true
                }
            }
        });
        const chartTopUpOrderRecordsGraph = HSCore.components.HSChartJS.getItem('chartTopUpOrderRecordsGraph');

        updateChartOrderRecordsGraph();

        async function updateChartOrderRecordsGraph() {
            let $url = "{{ route('admin.chartTopUpOrderRecords') }}"
            await axios.get($url)
                .then(function (res) {

                    $('.totalTopUpOrderCount').text(res.data.topUpOrderRecord.totalTopUpOrder);

                    chartTopUpOrderRecordsGraph.data.labels = res.data.topUpOrderRecord.topUpOrderToday.hours;
                    chartTopUpOrderRecordsGraph.data.datasets[0].data = res.data.topUpOrderRecord.topUpOrderToday.counts;
                    chartTopUpOrderRecordsGraph.data.datasets[1].data = res.data.topUpOrderRecord.topUpOrderYesterday.counts;
                    chartTopUpOrderRecordsGraph.update();
                    Notiflix.Block.remove('#topUpOrderRecord');
                })
                .catch(function (error) {
                });
        }
    </script>

    <script>
        Notiflix.Block.standard('#cardOrderRecord');
        HSCore.components.HSChartJS.init(document.querySelector('#chartCardOrderRecordsGraph'), {
            type: "line",
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: "transparent",
                    borderColor: "#377dff",
                    borderWidth: 2,
                    pointRadius: 0,
                    hoverBorderColor: "#377dff",
                    pointBackgroundColor: "#377dff",
                    pointBorderColor: "#fff",
                    pointHoverRadius: 0,
                    tension: 0.4
                },
                    {
                        data: [],
                        backgroundColor: "transparent",
                        borderColor: "#e7eaf3",
                        borderWidth: 2,
                        pointRadius: 0,
                        hoverBorderColor: "#e7eaf3",
                        pointBackgroundColor: "#e7eaf3",
                        pointBorderColor: "#fff",
                        pointHoverRadius: 0,
                        tension: 0.4
                    }]
            },
            options: {
                scales: {
                    y: {
                        grid: {
                            color: "#e7eaf3",
                            drawBorder: false,
                            zeroLineColor: "#e7eaf3"
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 100,
                            color: "#97a4af",
                            font: {
                                size: 12,
                                family: "Open Sans, sans-serif"
                            },
                            padding: 10,
                            prefix: "$",
                            postfix: "k"
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: "#97a4af",
                            font: {
                                size: 12,
                                family: "Open Sans, sans-serif"
                            },
                            padding: 5
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        prefix: "",
                        postfix: "",
                        hasIndicator: true,
                        mode: "index",
                        intersect: false,
                        lineMode: true,
                        lineWithLineColor: "rgba(19, 33, 68, 0.075)"
                    }
                },
                hover: {
                    mode: "nearest",
                    intersect: true
                }
            }
        });
        const chartCardOrderRecordsGraph = HSCore.components.HSChartJS.getItem('chartCardOrderRecordsGraph');

        updateChartCardOrderRecordsGraph();

        async function updateChartCardOrderRecordsGraph() {
            let $url = "{{ route('admin.chartCardOrderRecords') }}"
            await axios.get($url)
                .then(function (res) {

                    $('.totalCardOrderCount').text(res.data.cardOrderRecord.totalCardOrder);

                    chartCardOrderRecordsGraph.data.labels = res.data.cardOrderRecord.cardOrderToday.hours;
                    chartCardOrderRecordsGraph.data.datasets[0].data = res.data.cardOrderRecord.cardOrderToday.counts;
                    chartCardOrderRecordsGraph.data.datasets[1].data = res.data.cardOrderRecord.cardOrderYesterday.counts;
                    chartCardOrderRecordsGraph.update();
                    Notiflix.Block.remove('#cardOrderRecord');
                })
                .catch(function (error) {

                });
        }
    </script>

    <script>
        Notiflix.Block.standard('#addFundRecord');
        HSCore.components.HSChartJS.init(document.querySelector('#chartAddFundRecordsGraph'), {
            type: "line",
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: "transparent",
                    borderColor: "#377dff",
                    borderWidth: 2,
                    pointRadius: 0,
                    hoverBorderColor: "#377dff",
                    pointBackgroundColor: "#377dff",
                    pointBorderColor: "#fff",
                    pointHoverRadius: 0,
                    tension: 0.4
                },
                    {
                        data: [],
                        backgroundColor: "transparent",
                        borderColor: "#e7eaf3",
                        borderWidth: 2,
                        pointRadius: 0,
                        hoverBorderColor: "#e7eaf3",
                        pointBackgroundColor: "#e7eaf3",
                        pointBorderColor: "#fff",
                        pointHoverRadius: 0,
                        tension: 0.4
                    }]
            },
            options: {
                scales: {
                    y: {
                        grid: {
                            color: "#e7eaf3",
                            drawBorder: false,
                            zeroLineColor: "#e7eaf3"
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 100,
                            color: "#97a4af",
                            font: {
                                size: 12,
                                family: "Open Sans, sans-serif"
                            },
                            padding: 10,
                            prefix: "$",
                            postfix: "k"
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: "#97a4af",
                            font: {
                                size: 12,
                                family: "Open Sans, sans-serif"
                            },
                            padding: 5
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        prefix: "",
                        postfix: "",
                        hasIndicator: true,
                        mode: "index",
                        intersect: false,
                        lineMode: true,
                        lineWithLineColor: "rgba(19, 33, 68, 0.075)"
                    }
                },
                hover: {
                    mode: "nearest",
                    intersect: true
                }
            }
        });
        const chartAddFundRecordsGraph = HSCore.components.HSChartJS.getItem('chartAddFundRecordsGraph');

        updateChartAddFundRecordsGraph();

        async function updateChartAddFundRecordsGraph() {
            let $url = "{{ route('admin.chartAddFundRecords') }}"
            await axios.get($url)
                .then(function (res) {

                    $('.totalAddFundCount').text(res.data.addFundRecord.currencySymbol + parseFloat(res.data.addFundRecord.totalAddFund).toFixed(2));
                    chartAddFundRecordsGraph.data.labels = res.data.addFundRecord.cardAddFundToday.hours;
                    chartAddFundRecordsGraph.data.datasets[0].data = res.data.addFundRecord.cardAddFundToday.counts;
                    chartAddFundRecordsGraph.data.datasets[1].data = res.data.addFundRecord.cardAddFundYesterday.counts;
                    chartAddFundRecordsGraph.update();
                    Notiflix.Block.remove('#addFundRecord');
                })
                .catch(function (error) {

                });
        }
    </script>
@endpush
