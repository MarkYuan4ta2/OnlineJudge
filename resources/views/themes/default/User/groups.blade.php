@extends('layouts.app')

@section('title')
    小组列表
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
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>名称</th>
                            <th>创建者</th>
                            <th>小组人数</th>
                            <th>创建时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groupList as $group)
                            <tr>
                                <th scope="row">
                                    <a href="{{URL::action('User\UserController@groupDetail',array('id'=>$group->id))}}"
                                       target="_blank">{{ $group->id }}</a></th>
                                <td><a href="{{URL::action('User\UserController@groupDetail',array('id'=>$group->id))}}"
                                       target="_blank">{{ $group->name }}</a></td>
                                <td>{{ $teacherList[$group->leader_id]->name }}</td>
                                <td>{{ $group->members_count }}</td>
                                <td>{{ $group->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                @include('themes.default.User.announcements')
            </div>
        </div>
    </div>
@endsection
