@extends('layouts.appAdmin')

@section('title')
    小组列表
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h1>小组管理</h1>
                <div class="right">
                    <form class="form-inline" onsubmit="return false;">
                        <div class="form-group-sm">
                            <label>搜索</label>
                            <input class="form-control" placeholder="请输入关键词" ms-duplex="keyword">
                            <input type="submit" value="搜索" class="btn btn-primary" ms-click="search()">
                        </div>
                    </form>
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>名称</th>
                        <th>创建者</th>
                        <th>创建时间</th>
                        <th>人数</th>
                        <th></th>
                    </tr>
                    @foreach($groupList as $group)
                        <tr>
                            <td>{{ $group->id }}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ $teacherList[$group->leader_id]['name'] }}</td>
                            <td>{{ $group->created_at }}</td>
                            <td>{{ $group->members_count }}</td>
                            <td>
                                <a class="btn btn-sm btn-info"
                                   href="{{URL::action('Admin\AdminController@groupDetail',array('id'=>$group->id))}}">管理</a>
                                <a class="btn btn-sm btn-warning"
                                   href="{{URL::action('Admin\AdminController@joinContests',array('id'=>$group->id))}}">参加比赛</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <h2>创建小组</h2>
                <div class="col-md-12">
                    <div class="form-group"><label>小组名</label>
                        <input type="text" id="name" class="form-control" maxlength="20" placeholder="名字长度20以内">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group"><label>描述</label>
                        <input type="text" id="description" class="form-control" placeholder="请填写描述">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <a class="btn btn-success btn-lg" onclick="addGroup();">创建小组</a>
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

        function addGroup() {
            var name = $('#name').val();
            var description = $('#description').val();

            $.post(
                    "{{URL::action('Admin\AdminController@saveGroup')}}",
                    {name: name, description: description},
                    function (data, status) {
                        alert(data);
                        if (data == 'success') {
                            location.reload();
                        }
                    }
            );
        }
    </script>
@endsection
