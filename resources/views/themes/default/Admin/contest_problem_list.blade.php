@extends('layouts.appAdmin')

@section('title')
    比赛-题目添加列表
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <div class="alert alert-warning" role="alert">
                    <p>比赛的题目在创建题目时选择，您可以通过编辑题目来将题目加入该比赛。<a href="{{URL::action('Admin\AdminController@listProblems')}}">题目列表</a>
                    </p>
                    <p>被选入比赛的题目如果选择了前台不可见，则该题目在公开题目列表不可见，在比赛题目列表可见。</p>
                    <p>在此处删除题目只会将题目移出比赛题目列表。</p>
                </div>
                <h1>比赛{{$contest->name}} 题目列表</h1>

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
                        <th>最近时间</th>
                        <th>作者</th>
                        <th>可见</th>
                        <th>通过次数/提交总数</th>
                        <th>修改</th>
                    </tr>
                    @foreach($problemList as $problem)
                        <tr>
                            <td>{{ $problem->id }}</td>
                            <td>{{ $problem->title }}</td>
                            <td>{{ $problem->updated_at or $problem->created_at }}</td>
                            <td>{{ $teacherList[$problem->created_by]['name'] }}</td>
                            <td>@if($problem->visible)可见@else不可见@endif</td>
                            <td>{{ $problem->total_accepted_number }}/{{ $problem->total_submit_number }}</td>
                            <td>
                                <a href="{{ URL::action('Admin\AdminController@editProblems',array('id'=> $problem->id)) }}"
                                   class="btn btn-sm btn-info">编辑</a>
                                <a onclick="removeFromContest({{$problem->id}})"
                                   class="btn btn-sm btn-danger">删除</a>
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

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        function removeFromContest(id) {
            $.post(
                    "{{URL::action('Admin\AdminController@deleteContestProblems')}}",
                    {id: id},
                    function (data, status) {
                        alert(data);
                        location.reload();
                    }
            );
        }
    </script>
@endsection