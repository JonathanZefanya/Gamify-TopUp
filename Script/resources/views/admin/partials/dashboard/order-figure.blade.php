<div class="row mb-2">
    <div class="col-md-12">
        <div class="card mt-50" id="orderPerformance">
            <div class="card-body">
                <div id="chart"></div>
            </div>
        </div>
    </div>
</div>


@push('script')
    <script>
        Notiflix.Block.standard('#orderPerformance');
        var options = {
            series: [
                {
                    name: "Top Up",
                    data: []
                },
                {
                    name: "Card",
                    data: []
                },
            ],
            chart: {
                height: 350,
                type: 'line',
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: false
                }
            },
            colors: ['#77B6EA', '#545454'],
            dataLabels: {
                enabled: true,
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: 'Order Movement',
                align: 'left'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            markers: {
                size: 1
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                title: {
                    text: 'Month'
                }
            },
            yaxis: {
                title: {
                    text: 'Count'
                },
                min: 5,
                max: 40
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        updateOrderMovementGraph();

        async function updateOrderMovementGraph() {
            let $url = "{{ route('admin.chartOrderMovement') }}";
            await axios.get($url)
                .then(function (res) {
                    let data = res.data.orderFigures.horizontalBarChatInbox;
                    options.series[0].data = data.topUp;
                    options.series[1].data = data.card;
                    chart.updateSeries(options.series);
                    Notiflix.Block.remove('#orderPerformance');
                })
                .catch(function (error) {
                    console.error(error);
                });
        }

    </script>
@endpush
