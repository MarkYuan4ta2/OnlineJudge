@extends('layouts.appAdmin')

@section('title')
    分类列表
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h1>分类列表</h1>

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
                <div class="">
                    <form class="form-inline" name="saveClass" id="saveClass" method="post"
                          action="{{ URL::action('Admin\AdminController@saveClassifications')}}">
                        <div class="form-group">
                            <label>添加分类</label>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="text" class="form-control" name="name" placeholder="填入你想要的分类名称">
                        </div>
                        <button type="submit" class="btn btn-success" onclick="alert('succeed!');">确认添加</button>
                    </form>
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>分类名称</th>
                        <th>作者</th>
                        <th>最近修改时间</th>
                        <th>相关题目数量</th>
                        <th>修改</th>
                    </tr>
                    @foreach($classificationList as $classification)
                        <tr>
                            <td id="id_td{{ $classification->id }}">{{ $classification->id }}</td>
                            <td id="td{{ $classification->id }}">{{ $classification->name }}</td>
                            <td>{{ $teacherList[$classification->created_by]['name'] }}</td>
                            <td>{{ $classification->updated_at or $classification->created_at }}</td>
                            <td>{{ $classification->problems_count }}</td>
                            <td>
                                @if(checkUserPriority($classification->created_by))
                                    <a onclick="changeOne({{$classification->id}});"
                                       class="btn btn-sm btn-info">编辑</a>
                                    <a href="{{ URL::action('Admin\AdminController@deleteClassifications',array('id'=>$classification->id)) }}"
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

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        var button = null;

        function changeOne(id) {
            if (button == null) {
                button = $(this);

                var td = $('#td' + id);
                var name = td.html();
                var inputStr = '<input type="text" class="form-control" id="newName" placeholder="' + name + '">';
                var buttonAc = '<button onclick="acceptChange(' + id + ')" class="btn btn-success">确认修改</button>';
                var buttonCa = '<button onclick="cancelChange(' + id + ',\'' + name + '\')" class="btn btn-warning">放弃修改</button>';
                td.html(inputStr + buttonAc + buttonCa);
            }
        }

        function acceptChange(id) {
            var name = $('#newName').val();
            var id = $('#id_td' + id).text();
            $.post(
                    "{{URL::action('Admin\AdminController@saveClassifications')}}",
                    {name: name, id: id},
                    function (data, status) {
                        alert(data);
                        location.reload();
                    }
            );
        }

        function cancelChange(id, name) {
            var td = $('#td' + id);
            td.empty().html(name);
            button = null;
        }
    </script>
@endsection
