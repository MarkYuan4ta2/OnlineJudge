@extends('layouts.app')

@section('title')
    比赛列表
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/problems.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container main">
        <div class="row">
            <div class="col-md-9 col-lg-9">
                <div class="row">
                    <div class="right">
                        <form class="form-inline" method="get">
                            <div class="form-group-sm">
                                <input name="keyword" class="form-control" value="" placeholder="请输入关键词">
                                <input type="submit" value="搜索" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
                <div>
                    @if(count($contestList) != 0)
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>比赛名称</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
                                <th>发起人</th>
                                <th>状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contestList as $contest)
                                <tr>
                                    <th scope="row">{{ $contest->id }}</th>
                                    <td><a href="{{URL::action('User\UserController@contestDetail',array('id'=>$contest->id))}}">{{ $contest->name }}</a></td>
                                    <td>{{ $contest->start_time }}</td>
                                    <td>{{ $contest->end_time }}</td>
                                    <td>{{ $teacherList[$contest->created_by]->name }}</td>
                                    <td class="@if($contest->state == 'start')alert-success
                                            @elseif($contest->state == 'not_start')alert-warning
                                            @else alert-danger
                                            @endif
                                    ">{{ trans('messages.'.$contest->state) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>当前你没有加入小组或你的小组没有比赛,你可以尝试到<a href="{{ url('/groups') }}">小组列表</a>加入一些其他小组</p>
                    @endif
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                @include('themes.default.User.announcements')
            </div>
        </div>
    </div>
@endsection
