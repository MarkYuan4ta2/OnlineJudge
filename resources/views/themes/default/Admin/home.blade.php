@extends('layouts.appAdmin')

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-5 col-lg-5">
                <h1>提交概况</h1>
                <div id="submissionChart" style="height: 500px;"></div>
            </div>
            <div class="col-md-5 col-lg-5">
                <h1>用户概况</h1>
                <div id="userChart" style="height: 500px;"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/3.1.7/echarts.min.js"></script>
    <script type="text/javascript">
        var submissionChart = echarts.init(document.getElementById('submissionChart'));
        var userChart = echarts.init(document.getElementById('userChart'));
        option = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                x: 'left',
                data: ['答案通过', '答案错误', '编译错误', '运行超时']
            },
            series: [
                {
                    name: '提交情况',
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
                        {value: {{ $accepted }}, name: '答案通过'},
                        {value: {{ $timeExceeded }}, name: '答案错误'},
                        {value: {{ $compileError }}, name: '编译错误'},
                        {value: {{ $wrongAnswer }}, name: '运行超时'}
                    ]
                }
            ]
        };

        submissionChart.setOption(option);

        option = {
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                x: 'left',
                data: ['普通用户', '管理员用户', '超级管理员']
            },
            series: [
                {
                    name: '提交情况',
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
                        {value: {{ $customUser }}, name: '普通用户'},
                        {value: {{ $admin }}, name: '管理员用户'},
                        {value: {{ $superAdmin }}, name: '超级管理员'}
                    ]
                }
            ]
        };

        userChart.setOption(option);
    </script>
@endsection
