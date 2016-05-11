@extends('layouts.appAdmin')

@section('title')
    参加比赛列表
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h1>未参加比赛列表</h1><br>
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>标题</th>
                        <th>创建时间</th>
                        <th>创建者</th>
                        <th></th>
                    </tr>
                    @foreach($contestList as $contest)
                        <tr>
                            <td>{{ $contest->id }}</td>
                            <td>{{ $contest->name }}</td>
                            <td>{{ $contest->created_at }}</td>
                            <td>{{ $teacherList[$contest->created_by]->name }}</td>
                            <td>
                                <a class="btn btn-info btn-sm" onclick="joinContest({{$contest->id}});">加入</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <hr>
                <h1>已参加比赛列表</h1><br>
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>标题</th>
                        <th>创建时间</th>
                        <th>创建者</th>
                    </tr>
                    @if(count($groupContests) != 0)
                        @foreach($groupContests as $contest)
                            <tr>
                                <td>{{ $contest->id }}</td>
                                <td>{{ $contest->name }}</td>
                                <td>{{ $contest->created_at }}</td>
                                <td>{{ $teacherList[$contest->created_by]->name }}</td>
                            </tr>
                        @endforeach
                    @endif
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

        function joinContest(id) {
            var g_id = {{$groupId}};
            $.post(
                    "{{URL::action('Admin\AdminController@joinInContests')}}",
                    {g_id: g_id, c_id: id},
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
