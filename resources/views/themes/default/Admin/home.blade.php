@extends('layouts.appAdmin')

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h1>admin home</h1>
                <div id="chart" style="width: 600px;height:500px;"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/3.1.7/echarts.min.js"></script>
    <script type="text/javascript">
        var myChart = echarts.init(document.getElementById('chart'));
        option = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                x: 'left',
                data: ['全部提交数量', '全部通过数量']
            },
            series: [
                {
                    name: '题目情况',
                    type: 'pie',
                    radius: ['50%', '70%'],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: '30',
                                fontWeight: 'bold'
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data: [
                        {value: {{ $submissions }}, name: '全部提交数量'},
                        {value: {{ $submissions }}, name: '全部通过数量'},
                    ]
                }
            ]
        };

        myChart.setOption(option);
    </script>
@endsection
