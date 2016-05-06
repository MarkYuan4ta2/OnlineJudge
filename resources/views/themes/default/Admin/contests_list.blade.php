@extends('layouts.appAdmin')

@section('title')
    比赛列表
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h1>比赛列表</h1>

                <div class="right">
                    <form class="form-inline" onsubmit="return false;">
                        <div class="form-group-sm">
                            <label>搜索</label>
                            <input name="keyWord" class="form-control" placeholder="请输入关键词">
                            <input type="submit" value="搜索" class="btn btn-primary">
                        </div>
                    </form>
                    <br>
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>标题</th>
                        <th>比赛状态</th>
                        <th>创建时间</th>
                        <th>创建者</th>
                        <th></th>
                    </tr>
                    @foreach($contestList as $contest)
                        <tr>
                            <td>{{ $contest->id }}</td>
                            <td>{{ $contest->name }}</td>
                            <td>{{ $contest->state }}</td>
                            <td>{{ $contest->created_at }}</td>
                            <td>{{ $teacherList[$contest->created_by]->name }}</td>
                            <td>
                                <a class="btn btn-info btn-sm">编辑</a>
                                <a class="btn btn-info btn-sm">题目</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{--<div class="form-group">--}}
                    {{--<label>仅显示可见 <input type="checkbox"/></label>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection
