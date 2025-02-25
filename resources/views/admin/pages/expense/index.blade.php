@extends('admin.layouts.master')
@php
    use Carbon\Carbon;
@endphp

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-6 col-xl-4 grid-margin stretch-card">
                    <x-card-dashboard title="Total Balance" value="${{ number_format($thisWeekBalance, 2) }}"
                        percentage="{{ number_format($balanceChange, 2) }}%"
                        is_positive="{{ $balanceChange < 0 ? 'false' : 'true' }}" icon="mdi mdi-wallet mdi-12px icon-item" />
                </div>
                <div class="col-md-6 col-xl-4 grid-margin stretch-card">
                    <x-card-dashboard title="Total Income" value="${{ number_format($thisWeekIncome, 2) }}"
                        percentage="{{ number_format($incomeChange, 2) }}%" icon="mdi mdi-currency-usd mdi-12px icon-item"
                        is_positive="{{ $incomeChange < 0 ? 'false' : 'true' }}" />
                </div>
                <div class="col-md-6 col-xl-4 grid-margin stretch-card">
                    <x-card-dashboard title="Total Expenses" value="${{ number_format($thisWeekExpense, 2) }}"
                        percentage="{{ number_format($expenseChange, 2) }}%"
                        icon="mdi mdi mdi-currency-usd-off mdi-12px icon-item"
                        is_positive="{{ $expenseChange < 0 ? 'false' : 'true' }}" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title
                        ">Expenses</h4>

                            <canvas id="earningChart" style="height:230px"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="width: 100%;">
                    <li class="nav-item" style="width: 50%;">
                        <a class="nav-link active" id="income-tab" data-toggle="tab" href="#income" role="tab"
                            aria-controls="income" aria-selected="true">Income</a>
                    </li>
                    <li class="nav-item" style="width: 50%;">
                        <a class="nav-link" id="expense-tab" data-toggle="tab" href="#expense" role="tab"
                            aria-controls="expense" aria-selected="false">Expense</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="income" role="tabpanel" aria-labelledby="income-tab">
                        <canvas id="income-transaction" class="transaction-chart"></canvas>
                        @foreach ($categoryComparisons as $categoryName => $categoryComparison)
                            @if ($categoryComparison['totalIncome'] > 0)
                                <x-card-platform title="{{ $categoryName }}"
                                    value="${{ number_format($categoryComparison['totalIncome'], 2) }}" />
                            @endif
                        @endforeach

                    </div>
                    <div class="tab-pane fade" id="expense" role="tabpanel" aria-labelledby="expense-tab">
                        <canvas id="expense-transaction" class="transaction-chart"></canvas>
                        @foreach ($categoryComparisons as $categoryName => $categoryComparison)
                            @if ($categoryComparison['totalExpense'] > 0)
                                <x-card-platform title="{{ $categoryName }}"
                                    value="${{ number_format($categoryComparison['totalExpense'], 2) }}" />
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('my-script')
    <script>
        $(document).ready(function() {
            var incomeData = {
                labels: {!! json_encode(array_keys($categoryComparisons)) !!},
                datasets: [{
                    data: {!! json_encode(array_column($categoryComparisons, 'totalIncome')) !!},
                    backgroundColor: {!! json_encode(array_column($categoryComparisons, 'colorCode')) !!},
                }],
            };

            var expenseData = {
                labels: {!! json_encode(array_keys($categoryComparisons)) !!},
                datasets: [{
                    data: {!! json_encode(array_column($categoryComparisons, 'totalExpense')) !!},
                    backgroundColor: {!! json_encode(array_column($categoryComparisons, 'colorCode')) !!},
                }],
            };

            var chartOptions = {
                responsive: true,
                maintainAspectRatio: true,
                segmentShowStroke: false,
                cutoutPercentage: 70,
                elements: {
                    arc: {
                        borderWidth: 0,
                    },
                },
                legend: {
                    display: false,
                },
                tooltips: {
                    enabled: true,
                },
            };

            var chartPlugins = {
                beforeDraw: function(chart) {
                    var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;

                    ctx.restore();
                    var fontSize = 1;
                    ctx.font = fontSize + "rem sans-serif";
                    ctx.textAlign = "left";
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "#ffffff";

                    var text = "$" + chart.data.datasets[0].data.map(Number).reduce((a, b) => a + b, 0),
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = height / 2.4;

                    ctx.fillText(text, textX, textY);

                    ctx.restore();
                    var fontSize = 0.75;
                    ctx.font = fontSize + "rem sans-serif";
                    ctx.textAlign = "left";
                    ctx.textBaseline = "middle";
                    ctx.fillStyle = "#6c7293";

                    var texts = "Total",
                        textsX = Math.round((width - ctx.measureText(text).width) / 1.93),
                        textsY = height / 1.7;

                    ctx.fillText(texts, textsX, textsY);
                    ctx.save();
                },
            };

            if ($("#income-transaction").length) {
                var incomeChartCanvas = $("#income-transaction").get(0).getContext("2d");
                var incomeChart = new Chart(incomeChartCanvas, {
                    type: "doughnut",
                    data: incomeData,
                    options: chartOptions,
                    plugins: chartPlugins,
                });
            }

            if ($("#expense-transaction").length) {
                var expenseChartCanvas = $("#expense-transaction").get(0).getContext("2d");
                var expenseChart = new Chart(expenseChartCanvas, {
                    type: "doughnut",
                    data: expenseData,
                    options: chartOptions,
                    plugins: chartPlugins,
                });
            }

            var ctx = $('#earningChart');
            var dataQualitySmall = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(
                        $monthlyEarnings->keys()->map(function ($month) {
                            return Carbon::create()->month($month + 1)->format('M');
                        }),
                    ) !!},
                    datasets: [{
                            label: 'Income',
                            data: {!! $monthlyEarnings->map(function ($earning) {
                                return $earning['total_income'];
                            }) !!},
                            backgroundColor: '#e6f78f',
                            borderColor: '#e6f78f',
                            borderWidth: 1
                        },
                        {
                            label: 'Expense',
                            data: {!! $monthlyEarnings->map(function ($earning) {
                                return $earning['total_expense'];
                            }) !!},
                            backgroundColor: '#d5f6e5',
                            borderColor: '#d5f6e5',
                            borderWidth: 1
                        }
                    ]

                },
                options: {
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataset = data.datasets[tooltipItem.datasetIndex];
                                var value = dataset.data[tooltipItem.index];
                                return dataset.label + ': $' + value;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            stacked: true
                        }],
                        xAxes: [{
                            stacked: true
                        }]
                    },
                }
            });
        });
    </script>
@endsection
