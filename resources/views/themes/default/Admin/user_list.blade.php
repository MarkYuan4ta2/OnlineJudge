@extends('layouts.appAdmin')

@section('title')
    用户列表
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h1>用户列表</h1>

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
                        <th>用户名</th>
                        <th>注册时间</th>
                        <th>电子邮箱</th>
                        <th>用户类型</th>
                        <th>修改</th>
                    </tr>
                    @foreach($userList as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->email }}</td>
                            <td id="td{{ $user->id }}">{{ $userType[$user->is_admin] }}</td>
                            <td>
                                <a onclick="changePriority({{ $user->id }})"
                                   class="btn btn-sm btn-info">编辑权限</a>
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

        var button = null;

        function changePriority(id) {
            if (button == null) {
                button = $(this);

                var td = $('#td' + id);
                var priority = td.html();
                var options = '<option value="0">普通用户</option><option value="1">管理员</option><option value="2">超级管理员</option>';
                var select = '<select class="form-control" id="priority">' + options + '</select>';
                var buttonAc = '<button onclick="acceptChange(' + id + ')" class="btn btn-success">确认修改</button>';
                var buttonCa = '<button onclick="cancelChange(' + id + ',\'' + priority + '\')" class="btn btn-warning">放弃修改</button>';
                td.html(select + buttonAc + buttonCa);
            }
        }

        function acceptChange(id) {
            var is_admin = $('#priority').val();
            $.post(
                    "{{URL::action('Admin\AdminController@saveUserInfo')}}",
                    {id: id, is_admin:is_admin},
                    function (data, status) {
                        alert(data);
                        location.reload();
                    }
            );
        }

        function cancelChange(id, priority) {
            var td = $('#td' + id);
            td.empty().html(priority);
            button = null;
        }
    </script>
@endsection
