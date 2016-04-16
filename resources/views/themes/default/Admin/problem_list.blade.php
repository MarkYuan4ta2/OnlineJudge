@extends('layouts.appAdmin')

@section('title')
    题目列表
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h1>题目列表</h1>

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
                        <th>题目</th>
                        <th>创建时间</th>
                        <th>作者</th>
                        <th>可见</th>
                        <th>通过次数/提交总数</th>
                        <th>修改</th>
                    </tr>
                    @foreach($problemList as $problem)
                        <tr>
                            <td>{{ $problem->id }}</td>
                            <td>{{ $problem->title }}</td>
                            <td>2016-4-14 16:27:54</td>
                            {{--<td>{{ $problem->created_at }}</td>--}}
                            <td>{{ $teacherList[$problem->created_by]['name'] }}</td>
                            <td>@if($problem->visible)可见@else不可见@endif</td>
                            <td>{{ $problem->total_accepted_number }}/{{ $problem->total_submit_number }}</td>
                            <td>
                                @if(checkUserPriority($problem->created_by))
                                    <a href="{{ URL::action('Admin\AdminController@editProblems',array('id'=> $problem->id)) }}"
                                       class="btn btn-sm btn-info">编辑</a>
                                    <a href="{{ URL::action('Admin\AdminController@deleteProblems',array('id'=>$problem->id)) }}"
                                       class="btn btn-sm btn-danger">删除</a>
                                @else
                                    <a class="btn btn-sm btn-info disabled">编辑</a>
                                    <a class="btn btn-sm btn-danger disabled">删除</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{--<div class="form-group">--}}
                {{--<label>仅显示可见<input type="checkbox"/></label>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection
