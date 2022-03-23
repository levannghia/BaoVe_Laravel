@extends('admin.layout')
@section('title', $row->title)
@section('content')
    <div class="content-wrapper">
        <form class="form-filter-charts row align-items-center mb-1" name="form-thongke" accept-charset="utf-8" autocomplete="off">
            @csrf
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control " id="datepicker">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group"><button type="button" name="submit" id="btnChart" class="btn btn-success">Thống Kê</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tổng truy cập tháng <span id="monthCurrent"></span>: <span id="totalHits"></span> lượt</h4>
                        <div id="myfirstchart" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(function() {
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd",
            });
        });

        
        $(document).ready(function() {
            mounthNow();
            var chart =  new Morris.Area({
                element: 'myfirstchart',

                lineColors: ['#5646ff'],
                fillOpacity: 0.4,
                parseTime:false,
                hideHover: 'auto',
                // pointFillColors: [''],
                // pointStrokeColors: [''],
              
                xkey: 'period',
                ykeys: ['counter'],
                labels: ['Tổng lượt truy cập']
            });

            $('#btnChart').click(function(){
                var _token = "{{csrf_token()}}";
                var total = $('#totalHits');
                var date = $('#datepicker').val();
                var month = $('#monthCurrent');
                
                $.ajax({
                    url: "{{route('admin.dashboard.thong.ke')}}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        date: date,
                        _token: _token,
                    },
                    success: function(data){
                        chart.setData(data.data_day);
                        total.html(data.totalMonth);
                        month.html(data.monthCurrent);
                    }
                })
            })

            function mounthNow(){
                var _token = "{{csrf_token()}}";
                var total = $('#totalHits');
                var month = $('#monthCurrent');
                
                $.ajax({
                    url: "{{route('admin.dashboard.thong.ke.now')}}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        _token: _token,
                    },
                    success: function(data){
                        chart.setData(data.data_day);
                        total.html(data.totalMonth);
                        month.html(data.monthCurrent);
                    }
                })
            }
        });

        
    </script>
@endpush
