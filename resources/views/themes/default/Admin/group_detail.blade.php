@extends('layouts.appAdmin')

@section('title')
    小组详情
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h2>小组成员管理</h2>
                <div class="col-md-12 col-lg-12">
                    <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>用户邮箱</th>
                            <th>加入时间</th>
                            <th></th>
                        </tr>
                        @foreach($memberList as $member)
                            <tr>
                                <td>{{ $userList[$member['user_id']]->id }}</td>
                                <td>{{ $userList[$member['user_id']]->name }}</td>
                                <td>{{ $userList[$member['user_id']]->email }}</td>
                                <td>{{ $userList[$member['user_id']]->created_at }}</td>
                                <td>
                                    <a class="btn btn-sm btn-danger">移除</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <h2>修改小组信息</h2>
                <div class="col-md-12 col-lg-12">
                    <form id="edit_group_form">
                        <div class="col-md-6">
                            <div class="form-group"><label>小组名</label>
                                <input type="text" id="name" class="form-control" maxlength="20"
                                       value="{{$groupInfo->name}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>组长</label>
                                <select id="leader_id" class="form-control">
                                    @foreach($teacherList as $teacher)
                                        <option value="{{$teacher->id}}"
                                                @if($teacher->id == $groupInfo->leader_id) selected="selected"@endif>
                                            {{$teacher->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group"><label>描述</label>
                                <input type="text" id="description" class="form-control"
                                       value="{{$groupInfo->description}}">
                            </div>
                            <input type="hidden" id="group_id" value="{{$groupInfo->id}}">
                            <a class="btn btn-primary" onclick="saveChange();">确认修改</a>
                        </div>
                    </form>
                </div>
            </div>
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

        function saveChange() {
            var name = $('#name').val();
            var description = $('#description').val();
            var leader_id = $('#leader_id').val();
            var id = $('#group_id').val();

            $.post(
                    "{{URL::action('Admin\AdminController@saveGroup')}}",
                    {name: name, description: description, leader_id: leader_id, id:id},
                    function (data, status) {
//                        alert(data);
                        console.log(data);
                        if (data == 'success') {
                            location.reload();
                        }
                    }
            );
        }
    </script>
@endsection
