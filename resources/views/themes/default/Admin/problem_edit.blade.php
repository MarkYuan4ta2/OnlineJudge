@extends('layouts.appAdmin')

@section('title')
    @if(isset($_GET['id']))编辑题目@else新增题目@endif
@endsection

@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.9.6/trix.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/0.9.6/trix.js" type="text/javascript"></script>
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('themes.default.Admin.adminLeftBar')
            <div class="col-md-9 col-lg-9">
                <h1>@if(isset($_GET['id']))编辑题目@else新增题目@endif</h1>
                <form id="problem_form" name="problem_form" method="post" enctype="multipart/form-data"
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
                        {{--<textarea class="form-control"--}}
                        {{--name="description"></textarea>--}}
                        <input type="hidden" id="description" name="description"
                               value="@if(isset($problem)){{$problem->description}}@endif">
                        <trix-editor input="description"></trix-editor>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group"><label>时间限制(ms, 范围1-10000ms)</label>
                            <input type="number" name="time_limit" class="form-control"
                                   value="@if(isset($problem)){{$problem->time_limit}}@endif">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group"><label>内存限制(MB, 最低16M, Java不能低于32M)</label>
                            <input type="number" name="memory_limit" class="form-control"
                                   value="@if(isset($problem)){{$problem->memory_limit}}@endif">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class=" form-group">
                            <label>前台是否可见</label><br>
                            <label><input type="checkbox" name="visible"
                                          @if(isset($problem) and $problem->visible==1)checked="checked"@endif>
                                <small>可见</small>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group"><label>难度</label>
                            <select name="difficulty" class="form-control">
                                <option value="easy"
                                        @if(isset($problem) and $problem->difficult=='easy') selected="selected"@endif>
                                    简单
                                </option>
                                <option value="middle"
                                        @if(isset($problem) and $problem->difficult=='middle') selected="selected"@endif>
                                    中等
                                </option>
                                <option value="hard"
                                        @if(isset($problem) and $problem->difficult=='hard') selected="selected"@endif>难
                                </option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div id="tag" class="col-md-4">
                        <label>分类</label>
                        <select name="classification" class="form-control">
                            {{--classificationList 来自appprovider--}}
                            @foreach($classificationList as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="tag" class="col-md-4">
                        <label>比赛</label>
                        <select name="contest" class="form-control">
                            <option value="0">无</option>
                            @foreach($contestList as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>输入描述</label><br>
                        <input type="hidden" id="input_description" name="input_description"
                               value="@if(isset($problem)){{$problem->input_description}}@endif">
                        <trix-editor input="input_description"></trix-editor>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>输出描述</label><br>
                        <input type="hidden" id="output_description" name="output_description"
                               value="@if(isset($problem)){{$problem->output_description}}@endif">
                        <trix-editor input="output_description"></trix-editor>
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>样例输入</label>
                        <input type="hidden" id="test_case_in" name="test_case_in"
                               value="@if(isset($problem)){{$problem->test_case_in}}@endif">
                        <trix-editor input="test_case_in"></trix-editor>
                    </div>
                    <div class="form-group col-md-12">
                        <label>样例输出</label>
                        <input type="hidden" id="test_case_out" name="test_case_out"
                               value="@if(isset($problem)){{$problem->test_case_out}}@endif">
                        <trix-editor input="test_case_out"></trix-editor>
                    </div>

                    <div class="form-group col-md-12">
                        <label>上传最终测试用例</label>
                        <h5>输入<span class="warning">(文件名中不能含有中文)</span></h5>
                        @if(isset($problem->final_test_case_address_in))
                            已上传:<a class="info">{{$problem->final_test_case_address_in}}</a>
                        @endif
                        <input type="file" class="form-control" name="final_case_in">
                        <h5>输出<span class="warning">(文件名中不能含有中文)</span></h5>
                        @if(isset($problem->final_test_case_address_out))
                            已上传:<a class="info">{{$problem->final_test_case_address_out}}</a>
                        @endif
                        <input type="file" class="form-control" name="final_case_out">
                        <div class="help-block with-errors"></div>
                    </div>

                    <div class="form-group col-md-12">
                        <input type="submit" class="btn btn-success btn-lg"
                               value="@if(isset($_GET['id']))确认编辑@else确认发布@endif" id="submitBtn">
                    </div>

                    @if(isset($_GET['id']))
                        <input type="hidden" name="id" value="{{$problem->id}}">
                    @endif

                    {{--laravel身份认证--}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
@endsection
