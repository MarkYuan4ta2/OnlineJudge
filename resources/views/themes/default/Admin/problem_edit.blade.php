@extends('layouts.appAdmin')

@section('title')
    @if(isset($_GET['id']))编辑题目@else新增题目@endif
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h1>@if(isset($_GET['id']))编辑题目@else新增题目@endif</h1>
                <form id="problem_form" name="problem_form" method="post"
                      action="{{ URL::action('Admin\AdminController@saveProblems')}}">

                    <div class="form-group col-md-12">
                        <label>题目标题</label>
                        <input type="text" name="title" class="form-control"
                               data-error="请填写题目名称(名称不能超过30个字)"
                               maxlength="30"
                               value="@if(isset($problem)){{$problem->title}}@endif">
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group col-md-12">
                        <label>题目描述</label>
                        <textarea class="form-control"
                                  name="description">@if(isset($problem)){{$problem->description}}@endif</textarea>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group"><label>时间限制(ms, 范围1-10000ms)</label>
                            <input type="number" name="time_limit" class="form-control"
                                   value="@if(isset($problem)){{$problem->time_limit}}@endif">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>内存限制(MB, 最低16M, Java不能低于32M)</label>
                            <input type="number" name="memory_limit" class="form-control"
                                   value="@if(isset($problem)){{$problem->memory_limit}}@endif">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group"><label>难度</label>
                            <select name="difficulty" class="form-control">
                                <option value="easy"@if(isset($problem) and $problem->difficult=='easy') selected="selected"@endif>简单</option>
                                <option value="middle"@if(isset($problem) and $problem->difficult=='middle') selected="selected"@endif>中等</option>
                                <option value="hard"@if(isset($problem) and $problem->difficult=='hard') selected="selected"@endif>难</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div id="tag" class="col-md-4">
                        <label>分类</label>
                        <select name="classification" class="form-control">
                            <option value="1">简单</option>
                            <option value="2">中等</option>
                            <option value="3">难</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>前台是否可见</label><br>
                        <label><input type="checkbox" name="visible"
                                      @if(isset($problem) and $problem->visible==1)checked="checked"@endif>
                            <small>可见</small>
                        </label>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>输入描述</label><br>
                        <textarea class="form-control" rows="5" name="input_description"
                                  maxlength="10000">@if(isset($problem)){{$problem->input_description}}@endif</textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>输出描述</label><br>
                        <textarea class="form-control" rows="5"
                                  name="output_description">@if(isset($problem)){{$problem->output_description}}@endif</textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-12"><br>
                        <label>基本样例</label>
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm">添加</a>

                        <div class="sample">
                            <div class="panel panel-default sample-panel">
                                <div class="panel-heading">
                                    <span class="panel-title">样例 i</span>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm">
                                        删除
                                    </a>
                                </div>
                                <div class="panel-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>样例输入</label>
                                            <textarea class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>样例输出</label>
                                            <textarea class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label>上传最终测试用例</label>
                        <input type="text" class="form-control"
                               value="@if(isset($problem)){{$problem->final_test_case_address}}@endif">
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="col-md-12">
                        <input type="submit" class="btn btn-success btn-lg"
                               value="@if(isset($_GET['id']))确认编辑@else确认发布@endif" id="submitBtn">
                    </div>

                    @if(isset($_GET['id']))
                        <input type="hidden" name="id" value="{{$problem->id}}">
                    @endif

                    {{--laravel身份认证--}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-12 cl"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
