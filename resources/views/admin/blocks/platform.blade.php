<div class="col-md-4 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Booking by Platform</h4>
            <canvas id="platform" class="transaction-chart"></canvas>
            <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                <div class="text-md-center text-xl-left">
                    <h6 class="mb-1">Direct Booking</h6>
                </div>
                <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                    <h6 class="font-weight-bold mb-0">236</h6>
                </div>
            </div>
            <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                <div class="text-md-center text-xl-left">
                    <h6 class="mb-1">Booking.com</h6>
                </div>
                <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                    <h6 class="font-weight-bold mb-0">55</h6>
                </div>
            </div>
            <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                <div class="text-md-center text-xl-left">
                    <h6 class="mb-1">Agoda</h6>
                </div>
                <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                    <h6 class="font-weight-bold mb-0">31</h6>
                </div>
            </div>
            <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                <div class="text-md-center text-xl-left">
                    <h6 class="mb-1">Airbnb</h6>
                </div>
                <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                    <h6 class="font-weight-bold mb-0">12</h6>
                </div>
            </div>
            <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                <div class="text-md-center text-xl-left">
                    <h6 class="mb-1">Other</h6>
                </div>
                <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                    <h6 class="font-weight-bold mb-0">3</h6>
                </div>
            </div>
        </div>
    </div>
</div>

@section('my-script')
    <script>
        const total = 337
        const id = "#platform";
        const percentage = [
            Math.round(236 / total * 100),
            Math.round(55 / total * 100),
            Math.round(31 / total * 100),
            Math.round(12 / total * 100),
            Math.round(3 / total * 100)
        ] // % of each platform
        if ($(id).length) {
            var areaData = {
                labels: [
                    "Direct Booking",
                    "Booking.com",
                    "Agoda",
                    "Airbnb",
                    "Other"
                ],
                datasets: [{ // percentage
                    data: percentage,
                    backgroundColor: [
                        "#007bff",
                        "#6610f2",
                        "#e83e8c",
                        "#fd7e14",
                        "#20c997"
                    ]
                }]
            };
            var areaOptions = {
                responsive: true,
                maintainAspectRatio: true,
                segmentShowStroke: false,
                cutoutPercentage: 70,
                elements: {
                    arc: {
                        borderWidth: 0
                    }
                },
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: true
                }
            }
            var chartPlugins = {
                beforeDraw: function(chart) {
                    var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;

                    ctx.restore();
                    var fontSize = 1;
                    ctx.font = fontSize + "rem sans-serif";
                    ctx.textAlign = 'left';
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "#ffffff";

                    var text = total.toString(),
                        textX = Math.round((width - ctx.measureText(text).width) / 2.05),
                        textY = height / 2.4;

                    ctx.fillText(text, textX, textY);

                    ctx.restore();
                    var fontSize = 0.75;
                    ctx.font = fontSize + "rem sans-serif";
                    ctx.textAlign = 'center';
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "#6c7293";

                    var texts = "Total",
                        textsX = Math.round((width - ctx.measureText(text).width) / 1.93),
                        textsY = height / 1.7;

                    ctx.fillText(texts, textsX, textsY);
                    ctx.save();
                }
            }
            const chartCanvas = $(id).get(0).getContext("2d");
            const roomAvailabilityChart = new Chart(chartCanvas, {
                type: 'doughnut',
                data: areaData,
                options: areaOptions,
                plugins: chartPlugins
            });
        }
    </script>
@endsection
