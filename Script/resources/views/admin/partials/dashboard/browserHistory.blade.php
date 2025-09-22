<div class="row">
    <div class="col-lg-4 mb-3 mb-lg-5" id="loginHistory">
        <!-- Card -->
        <div class="card h-100">
            <div class="card-header">
                <h4 class="card-header-title">@lang("Browser History")</h4>
            </div>
            <!-- Body -->
            <div class="card-body text-center">
                <div class="h3">
                            <span class="badge bg-soft-info text-info rounded-pill">
                              <i class="bi-check-circle-fill me-1"></i> @lang("On track")
                            </span>
                </div>

                <!-- Chart Half -->
                <!-- Pie Chart -->
                <div class="chartjs-custom mb-3 mb-sm-5" style="height: 14rem;">
                    <canvas class="" id="chartBrowserHistoryGraph">
                    </canvas>
                </div>
                <!-- End Pie Chart -->
                <hr>
                <div class="row col-divider">
                    <div class="col text-center">
                        <span class="d-block">@lang("Last 30 Days Browser History")</span>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->
    </div>
    <div class="col-lg-4 mb-3 mb-lg-5" id="loginHistory">
        <!-- Card -->
        <div class="card h-100">
            <div class="card-header">
                <h4 class="card-header-title">@lang("Operating System History")</h4>
            </div>
            <!-- Body -->
            <div class="card-body text-center">
                <div class="h3">
                            <span class="badge bg-soft-info text-info rounded-pill">
                              <i class="bi-check-circle-fill me-1"></i> @lang("On track")
                            </span>
                </div>

                <!-- Chart Half -->
                <!-- Pie Chart -->
                <div class="chartjs-custom mb-3 mb-sm-5" style="height: 14rem;">
                    <canvas class="" id="chartOSHistoryGraph">
                    </canvas>
                </div>
                <!-- End Pie Chart -->

                <hr>

                <div class="row col-divider">
                    <div class="col text-center">
                        <span class="d-block">@lang("Last 30 Days OS History")</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <div class="col-lg-4 mb-3 mb-lg-5" id="loginHistory">
        <div class="card h-100">
            <div class="card-header">
                <h4 class="card-header-title">@lang("Device History")</h4>
            </div>
            <!-- Body -->
            <div class="card-body text-center">
                <div class="h3">
                            <span class="badge bg-soft-info text-info rounded-pill">
                              <i class="bi-check-circle-fill me-1"></i> @lang("On track")
                            </span>
                </div>
                <!-- Pie Chart -->
                <div class="chartjs-custom mb-3 mb-sm-5" style="height: 14rem;">
                    <canvas class="" id="chartDeviceHistoryGraph">
                    </canvas>
                </div>
                <!-- End Pie Chart -->

                <hr>

                <div class="row col-divider">
                    <div class="col text-center">
                        <span class="d-block">@lang("Last 30 Days Device History")</span>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->
    </div>
</div>

@push('script')
    <script>
        Notiflix.Block.standard('#loginHistory');
        HSCore.components.HSChartJS.init(document.querySelector('#chartBrowserHistoryGraph'), {
            type: "doughnut",
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: ["#0072C6", "#FF9500", "#FF5733", "#4285F4", "#0078D4", "#FF1B2D", "#006699", "#002558", "#003399", "#3E74A0", "#5EAA51", "#999999"],
                    borderWidth: 0.5,
                    hoverBorderColor: "#fff"
                }]
            },
            options: {
                cutout: "70%",
                plugins: {
                    tooltip: {
                        hasIndicator: true,
                        mode: "index",
                        intersect: false
                    }
                },
                hover: {
                    mode: "nearest",
                    intersect: true
                }
            },
        });
        const chartBrowserHistoryGraph = HSCore.components.HSChartJS.getItem('chartBrowserHistoryGraph');

        // OS

        HSCore.components.HSChartJS.init(document.querySelector('#chartOSHistoryGraph'), {
            type: "doughnut",
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: ["#0072C6", "#FF9500", "#FF5733", "#4285F4", "#0078D4", "#FF1B2D", "#006699", "#002558", "#003399", "#3E74A0", "#5EAA51", "#999999"],
                    borderWidth: 0.5,
                    hoverBorderColor: "#fff"
                }]
            },
            options: {
                cutout: "70%",
                plugins: {
                    tooltip: {
                        hasIndicator: true,
                        mode: "index",
                        intersect: false
                    }
                },
                hover: {
                    mode: "nearest",
                    intersect: true
                }
            },
        });
        const chartOSHistoryGraph = HSCore.components.HSChartJS.getItem('chartOSHistoryGraph');

        // Device
        HSCore.components.HSChartJS.init(document.querySelector('#chartDeviceHistoryGraph'), {
            type: "doughnut",
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: ["#0072C6", "#FF9500", "#FF5733", "#4285F4", "#0078D4", "#FF1B2D", "#006699", "#002558", "#003399", "#3E74A0", "#5EAA51", "#999999"],
                    borderWidth: 0.5,
                    hoverBorderColor: "#fff"
                }]
            },
            options: {
                cutout: "70%",
                plugins: {
                    tooltip: {
                        hasIndicator: true,
                        mode: "index",
                        intersect: false
                    }
                },
                hover: {
                    mode: "nearest",
                    intersect: true
                }
            },
        });
        const chartDeviceHistoryGraph = HSCore.components.HSChartJS.getItem('chartDeviceHistoryGraph');

        updateChartLoginHistoryGraph();

        async function updateChartLoginHistoryGraph() {
            let $url = "{{ route('admin.chartLoginHistory') }}"
            await axios.get($url)
                .then(function (res) {
                    browserHistory(res.data.loginPerformance);
                    operatingHistory(res.data.loginPerformance);
                    deviceHistory(res.data.loginPerformance);
                    Notiflix.Block.remove('#loginHistory');
                })
                .catch(function (error) {

                });
        }

        function browserHistory(loginPerformance) {
            chartBrowserHistoryGraph.data.labels = loginPerformance.browserKeys
            chartBrowserHistoryGraph.data.datasets[0].data = loginPerformance.browserValue
            chartBrowserHistoryGraph.update();
        }

        function operatingHistory(loginPerformance) {
            chartOSHistoryGraph.data.labels = loginPerformance.osKeys
            chartOSHistoryGraph.data.datasets[0].data = loginPerformance.osValue
            chartOSHistoryGraph.update();
        }

        function deviceHistory(loginPerformance) {
            chartDeviceHistoryGraph.data.labels = loginPerformance.deviceKeys
            chartDeviceHistoryGraph.data.datasets[0].data = loginPerformance.deviceValue
            chartDeviceHistoryGraph.update();
        }

    </script>
@endpush
