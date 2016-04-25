@extends('layouts.app')

@section('title')
    {{$problem->title}}
@endsection

@section('style')
    <link href="{{ asset('themes/default/css/problems.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/codeMirror/codemirror.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container main">
        <ul class="nav nav-tabs nav-tabs-google">
            <li role="presentation">
                <a href="">题目</a>
            </li>
            <li role="presentation" class="active">
                <a href="">我的提交</a>
            </li>
        </ul>

        <h2 class="text-center">{{$problem->title}}</h2>

        <p class="text-muted text-center">
            发布时间: {{ $problem->created_at }}&nbsp;&nbsp;
            @if($problem->updated_at)最后更新: {{ $problem->updated_at }}&nbsp;&nbsp;@endif
            时间限制: {!! $problem->time_limit !!}ms&nbsp;&nbsp;
            内存限制: {!! $problem->memory_limit !!}M
        </p>

        <div class="panel panel-default">
            <div class="panel-body">
                <h4>运行结果: <span class="text-{{-- submission.result|translate_result_class --}}">
                    {{ $submission->result }}
                </span>
                </h4>
                <p>
                    @if($submission->run_time > 0)
                        时间 : {{ $submission->run_time }}ms
                    @endif
                    语言 : {{ $submission->language }}
                </p>
                <p>提交时间: {{ $submission->created_at }}</p>
            </div>
        </div>

        @if($submission->compile_result)
        <div class="panel panel-default">
            <div class="panel-body">
                <h4>Compile result</h4>
                <pre>{{ $submission->compile_result }}</pre>
            </div>
        </div>
        @endif

        <div class="code-field">
            <textarea id="editor" name="editor">{{ $submission->code }}</textarea>
        </div>
        <hr>
    </div>
@endsection

@section('script_before')
    <script src="{{ asset('js/codeMirror/codemirror.js') }}"></script>
    <script src="{{ asset('js/codeMirror/language/clike.js') }}"></script>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var CodeMirrorEditor = CodeMirror.fromTextArea(document.getElementById('editor'), {
                lineNumbers: true,
                matchBrackets: true,
                mode: "text/x-csrc"
            });
            {{--CodeMirrorEditor.setValue("{{ $submission->code }}");--}}
        })
    </script>
@endsection
