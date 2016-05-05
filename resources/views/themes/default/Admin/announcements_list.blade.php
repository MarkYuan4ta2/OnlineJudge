@extends('layouts.appAdmin')

@section('title')
    公告列表
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h1>公告管理</h1>
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
                        <th>标题</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>创建者</th>
                        <th></th>
                    </tr>
                    @foreach($announcementList as $announcement)
                        <tr>
                            <td>{{ $announcement->id }}</td>
                            <td id="title_{{$announcement->id}}">{{ $announcement->title }}</td>
                            <td>{{ $announcement->created_at }}</td>
                            <td>{{ $announcement->updated_at }}</td>
                            <td>{{ $teacherList[$announcement->created_by]['name'] }}</td>
                            <td>
                                <a class="btn btn-sm btn-info" onclick="modifyAnnouncement({{$announcement->id}})">编辑</a>
                            </td>
                            <input type="hidden" id="content_{{$announcement->id}}"
                                   value="{{ $announcement->content }}">
                        </tr>
                    @endforeach
                </table>

                <h2>添加公告</h2>
                <div class="col-md-12">
                    <div class="form-group"><label>标题</label>
                        <input type="text" id="title" class="form-control" maxlength="20" placeholder="名字长度20以内">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group"><label>内容</label>
                        <textarea id="content" class="form-control" placeholder="请填写公告内容"></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <input type="hidden" id="id" value="">
                <a class="btn btn-success btn-lg" id="confirm" onclick="saveAnnouncement();">确定添加</a>
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

        function modifyAnnouncement(id) {
            var title_val = $('#title_'+id).html();
            var content_val = $('#content_'+id).val();

            $('#title').val(title_val);
            $('#content').val(content_val);
            $('#id').val(id);
            $('#confirm').html('确认修改');
        }

        function saveAnnouncement() {
            var title = $('#title').val();
            var content = $('#content').val();
            var id = $('#id').val();
            var data = {title: title, contents: content};
            if(id != ""){
                data.id = id;
            }
            $.post(
                    "{{URL::action('Admin\AdminController@saveAnnouncements')}}",
                    data,
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
