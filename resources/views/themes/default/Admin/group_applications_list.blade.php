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
            <div class="col-md-9">
                <h1>加入小组请求管理</h1>
                <table class="table table-striped">
                    <tr>
                        <th>创建时间</th>
                        <th>小组</th>
                        <th>用户</th>
                        <th>附加消息</th>
                        <th></th>
                    </tr>
                    @foreach($applicationList as $application)
                        <tr>
                            <td>{{ $application->created_at }}</td>
                            <td>{{ $application->created_at }}</td>
                            <td>{{ $application->created_at }}</td>
                            <td>{{ $application->created_at }}</td>

                            <td>
                                <a class="btn btn-sm btn-success" onclick="replyApplication(true);">同意</a>
                                <a class="btn btn-sm btn-danger" onclick="replyApplication(false);">拒绝</a>
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

        function replyApplication(reply) {
            var name = $('#name').val();
            var description = $('#description').val();

            $.post(
                    "{{URL::action('Admin\AdminController@replyApplication')}}",
                    {group_id: name, reply: reply},
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
