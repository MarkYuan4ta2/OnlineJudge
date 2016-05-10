@extends('layouts.appAdmin')

@section('title')
    @if(isset($_GET['id']))编辑比赛内容@else新增比赛@endif
@endsection

@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
          rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.9.6/trix.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h1>@if(isset($_GET['id']))编辑比赛内容@else新增比赛@endif</h1>
                <form id="contest_form" name="contest_form" method="post"
                      action="{{ URL::action('Admin\AdminController@saveContest')}}">

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control"
                                   data-error="请填写比赛名称(名称不能超过50个字)"
                                   value="@if(isset($contest)){{$contest->name}}@endif">
                            <div class=" help-block with-errors">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>说明</label>
                        <div class="form-group">
                            <input type="hidden" id="input_description" name="description"
                                   value="@if(isset($contest)){{$contest->description}}@endif">
                            <trix-editor input="input_description"></trix-editor>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>开始时间</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="start_time" id="contest_start_time"
                                   value="@if(isset($contest)){{$contest->start_time}}@endif">
                            <div class=" help-block with-errors">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>结束时间</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="end_time" id="contest_end_time"
                                   value="@if(isset($contest)){{$contest->end_time}}@endif">
                            <div class=" help-block with-errors">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>

                    <div class="col-md-12">
                        @if(isset($_GET['id']))<input type="hidden" value="{{$_GET['id']}}" name="contest_id">@endif
                        <input type="submit" class="btn btn-success btn-lg" value="@if(isset($_GET['id']))提交修改@else发布比赛@endif">
                    </div>

                    {{--laravel身份认证--}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/0.9.6/trix.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/locale/zh-cn.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"
            type="text/javascript"></script>
    <script>
        $('#contest_start_time').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss'});
        $('#contest_end_time').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss'});
    </script>
@endsection