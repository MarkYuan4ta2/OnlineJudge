@extends('layouts.appAdmin')

@section('title')
    加入小组请求列表
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9">
                <h1>加入小组请求管理</h1>
                <table class="table table-striped">
                    <tr>
                        <th>#</th>
                        <th>小组</th>
                        <th>用户</th>
                        <th>附加消息</th>
                        <th></th>
                    </tr>
                    @foreach($applicationList as $application)
                        <tr>
                            <td>{{ $application->id }}</td>
                            <td>{{ $groupList[$application->group_id]->name }}</td>
                            <td>{{ $userList[$application->user_id]->name }}</td>
                            <td>{{ $application->addition_info }}</td>

                            <td>
                                <a class="btn btn-sm btn-success" onclick="replyApplication(1, {{$application->id}});">同意</a>
                                <a class="btn btn-sm btn-danger" onclick="replyApplication(0, {{$application->id}});">拒绝</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
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

        function replyApplication(reply, id) {
            $.post(
                    "{{URL::action('Admin\AdminController@replyApplication')}}",
                    {id: id, reply: reply},
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
