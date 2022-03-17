@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        <form class="form-filter-charts row align-items-center mb-1" action="{{route('admin.dashboard.thong.ke')}}" method="POST" name="form-thongke"
            accept-charset="utf-8">
            @csrf
            <div class="col-md-4">
                <div class="form-group">
                    <select class="form-control select2" name="year" id="year">
                        <option value="">Chọn năm</option>
                        @php
                            for($i=2022; $i<=date("Y")+5;$i++){
                                echo "<option value=".$i.">$i</option>";
                            }
                        @endphp
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"><button type="submit" name="submit" class="btn btn-success">Thống Kê</button>
                </div>
            </div>
        </form>
        <?php
            $year = date("Y");
            if(isset($_POST['year'])){
                $year = $_POST['year'];
            }
        ?>
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Thống kê đơn hàng năm {{$year}}
                            {{-- <select class="" name="" id="select_year">
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                            </select> --}}
                        </h4>
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="cart-title">Goals</h5>
                        <canvas id="goals-chart" class="mt-4 mb-4"></canvas>
                        <div id="goals-legend" class="chartjs-legend pt-4 pb-3 border-bottom"></div>
                        <div class="d-flex flex-column align-items-center mt-4">
                            <p class="font-weight-bold">Revenue</p>
                            <h1 class="text-primary">284</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <h5 class="card-title">Sales</h5>
                            <div class="icon-rounded-primary d-none d-lg-block">
                                <i class="mdi mdi-arrow-top-right icon-md"></i>
                            </div>
                        </div>
                        <h1 class="mt-lg-3">39881</h1>
                        <div class="d-flex mt-2">
                            <p class="text-success mb-0 font-weight-bold"><span class="mdi mdi-arrow-up mr-1"></span>5.15%
                            </p>
                            <p class="text-muted mb-0 ml-2">Since last month</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <h5 class="card-title">Purchases</h5>
                            <div class="icon-rounded-primary d-none d-lg-block">
                                <i class="mdi mdi-basket icon-md"></i>
                            </div>
                        </div>
                        <h1 class="mt-lg-3">42283</h1>
                        <div class="d-flex mt-2">
                            <p class="text-danger mb-0 font-weight-bold"><span class="mdi mdi-arrow-down mr-1"></span>2.83%
                            </p>
                            <p class="text-muted mb-0 ml-2">Since last month</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <h5 class="card-title">Orders</h5>
                            <div class="icon-rounded-primary d-none d-lg-block">
                                <i class="mdi mdi-chart-donut icon-md"></i>
                            </div>
                        </div>
                        <h1 class="mt-lg-3">58470</h1>
                        <div class="d-flex mt-2">
                            <p class="text-success mb-0 font-weight-bold"><span class="mdi mdi-arrow-up mr-1"></span>5.15%
                            </p>
                            <p class="text-muted mb-0 ml-2">Since last month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
@push('script')
    <script>

        $(function() {
            /* ChartJS
             * -------
             * Data and config for chartjs
             */
            <?php
            $order_total_mont_1 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-01-01 00:00:00', $year . '-01-' . date('t', strtotime($year . '-01-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            $order_total_mont_2 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-02-01 00:00:00', $year . '-02-' . date('t', strtotime($year . '-02-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            $order_total_mont_3 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-03-01 00:00:00', $year . '-03-' . date('t', strtotime($year . '-03-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            $order_total_mont_4 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-04-01 00:00:00', $year . '-04-' . date('t', strtotime($year . '-04-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            $order_total_mont_5 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-05-01 00:00:00', $year . '-05-' . date('t', strtotime($year . '-05-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            $order_total_mont_6 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-06-01 00:00:00', $year . '-06-' . date('t', strtotime($year . '-06-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            $order_total_mont_7 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-07-01 00:00:00', $year . '-07-' . date('t', strtotime($year . '-07-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            $order_total_mont_8 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-08-01 00:00:00', $year . '-08-' . date('t', strtotime($year . '-08-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            $order_total_mont_9 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-09-01 00:00:00', $year . '-09-' . date('t', strtotime($year . '-09-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            $order_total_mont_10 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-10-01 00:00:00', $year . '-10-' . date('t', strtotime($year . '-10-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            $order_total_mont_11 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-11-01 00:00:00', $year . '-11-' . date('t', strtotime($year . '-11-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            $order_total_mont_12 = count(
                DB::table('orders')
                    ->whereBetween('created_at', [$year . '-12-01 00:00:00', $year . '-12-' . date('t', strtotime($year . '-12-01')) . ' 23:59:59'])
                    ->whereIn('status', [0, 1, 2, 3])
                    ->get(),
            );
            ?>

                'use strict';
            var data = {
                labels: ["T1", "T2", "T3", "T4", "T5", "T6", "T7", "T8", "T9", "T10", "T11", "T12"],

                datasets: [{
                    label: '# Đơn hàng',
                    data: [
                        {{ $order_total_mont_1 }},
                        {{ $order_total_mont_2 }},
                        {{ $order_total_mont_3 }},
                        {{ $order_total_mont_4 }},
                        {{ $order_total_mont_5 }},
                        {{ $order_total_mont_6 }},
                        {{ $order_total_mont_7 }},
                        {{ $order_total_mont_8 }},
                        {{ $order_total_mont_9 }},
                        {{ $order_total_mont_10 }},
                        {{ $order_total_mont_11 }},
                        {{ $order_total_mont_12 }}
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1,
                    fill: false
                }]
            };
            var multiLineData = {
                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                datasets: [{
                        label: 'Dataset 1',
                        data: [12, 19, 3, 5, 2, 3],
                        borderColor: [
                            '#587ce4'
                        ],
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Dataset 2',
                        data: [5, 23, 7, 12, 42, 23],
                        borderColor: [
                            '#ede190'
                        ],
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Dataset 3',
                        data: [15, 10, 21, 32, 12, 33],
                        borderColor: [
                            '#f44252'
                        ],
                        borderWidth: 2,
                        fill: false
                    }
                ]
            };
            var options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                elements: {
                    point: {
                        radius: 0
                    }
                }

            };

            // Get context with jQuery - using jQuery's .get() method.
            if ($("#barChart").length) {
                var barChartCanvas = $("#barChart").get(0).getContext("2d");
                // This will get the first returned node in the jQuery collection.
                var barChart = new Chart(barChartCanvas, {
                    type: 'bar',
                    data: data,
                    options: options
                });
            }

        });
    </script>
@endpush
