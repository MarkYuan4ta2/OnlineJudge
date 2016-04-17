@extends('layouts.app')

@section('title')
    {{$problem->title}}
@endsection

@section('style')
    <link href="{{ asset('css/codeMirror/codemirror.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/default/css/problems.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container main">
        <ul class="nav nav-tabs nav-tabs-google">
            <li role="presentation" class="active">
                <a href="">题目</a>
            </li>
            <li role="presentation">
                <a href="">我的提交</a>
            </li>
        </ul>

        <h2 class="text-center">{{$problem->title}}</h2>

        <p class="text-muted text-center">
            发布时间: {!! $problem->created_at !!}&nbsp;&nbsp;
            @if($problem->updated_at)最后更新: {!! $problem->updated_at !!}&nbsp;&nbsp;@endif
            时间限制: {!! $problem->time_limit !!}ms&nbsp;&nbsp;
            内存限制: {!! $problem->memory_limit !!}M
        </p>

        <div class="problem-section">
            <label class="problem-label">描述</label>

            <div class="problem-detail">{!! $problem->description !!}</div>
        </div>
        <div class="problem-section">
            <label class="problem-label">输入</label>

            <p class="problem-detail">{!! $problem->input_description !!}</p>
        </div>
        <div class="problem-section">
            <label class="problem-label">输出</label>

            <p class="problem-detail">{!! $problem->output_description !!}</p>
        </div>
        <div class="problem-section">
            <label class="problem-label case">输入样例</label>

            <p class="problem-detail">{!! $problem->test_case_in !!}</p>
        </div>

        <div class="problem-section">
            <label class="problem-label">输出样例</label>

            <p class="problem-detail">{!! $problem->test_case_out !!}</p>
        </div>
        <br>
        <div>
            <label>选择语言</label>
            <div>
                <label class="radio-inline">
                    <input type="radio" name="language" value="1" checked> C (GCC 4.8)
                </label>
                <label class="radio-inline">
                    <input type="radio" name="language" value="2"> C++ (G++ 4.3)
                </label>
                <label class="radio-inline">
                    <input type="radio" name="language" value="3"> Java (Oracle JDK 1.7)
                </label>
            </div>
        </div>
        <br>
        <div id="code-field">
            <label class="problem-label">提交代码</label>
            <textarea id="editor" name="editor"></textarea>
        </div>
        <hr>
        <div id="submit-code">
            <button type="button" class="btn btn-primary" id="submit-code-button" onclick="submitCode()">
                提交代码
            </button>
            <img src="{{asset('images/loading.gif')}}" id="loading-gif">
        </div>

    </div>
    <hr>
@endsection

@section('script_before')
    <script src="{{ asset('js/codeMirror/codemirror.js') }}"></script>
    <script src="{{ asset('js/codeMirror/language/clike.js') }}"></script>
@endsection
@section('script')
    <script>
        var CodeMirrorEditor = CodeMirror.fromTextArea(document.getElementById('editor'), {
            lineNumbers: true,
            matchBrackets: true,
            mode: "text/x-csrc"
        });

        function submitCode() {
            var code = CodeMirrorEditor.getValue();
            $('#loading-gif').css('display','inline');
            //
        }
    </script>
@endsection
