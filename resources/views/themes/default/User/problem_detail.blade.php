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
                <a href="{{URL::action('User\ProblemsController@userSubmissions', array('problemId'=>$problem->id))}}">我的提交</a>
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
        <div class="row" style="margin: 0px;">
            <div class="w4">
                <label>选择语言</label>
                <div>
                    <select class="form-control" id="language">
                        <option value="c">C (GCC 4.8)</option>
                        <option value="cpp">C++ (G++ 4.3)</option>
                        {{--<option value="java">Java (Oracle JDK 1.7)</option>--}}
                        {{--<option value="4">Python</option>--}}
                        {{--<option value="5">JavaScript</option>--}}
                    </select>
                </div>
            </div>
            <div class="w4" style="margin-left: 20px">
                <label>编辑器主题</label>
                <div>
                    <select class="form-control">
                        <option value="1">Eclipse</option>
                        <option value="2">Xcode</option>
                        <option value="3">Darcula</option>
                        <option value="4">Twilight</option>
                    </select>
                </div>
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
        <div id="result">
            <div class="result-box">

            </div>
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
        var submitted = false;
        var submissionId;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        var CodeMirrorEditor = CodeMirror.fromTextArea(document.getElementById('editor'), {
            lineNumbers: true,
            matchBrackets: true,
            mode: "text/x-csrc"
        });

        function submitCode() {
            if (!submitted) {
                submitted = true;
                $('.result-box').css('display', 'none');
            } else {
                return;
            }
            var code = CodeMirrorEditor.getValue();
            var language = $('#language').val();
            var problemId = {{$problem->id}};
            $('#loading-gif').css('display', 'inline');
            $.ajax({
                type: 'post',
                url: "{{URL::action('User\ProblemsController@receiveCode')}}",
                data: {code: code, language: language, problemId: problemId},
                dataType: 'json',
                success: function (data) {
                    //todo data should contain the run time, result
                    console.log(data);
                    submissionId = data.submissionId;
                    //5秒后去查看
                    setTimeout(askForResult, 5000);
                }
            });
        }

        function askForResult() {
            var id = submissionId;
            $.ajax({
                type: 'post',
                url: "{{URL::action('User\ProblemsController@submissionResult')}}",
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    $('#loading-gif').css('display', 'none');
                    if (data.result != -1) {
                        afterSubmit(data);
                    }else{
                        alert("抱歉，服务器正在紧张判题中，请稍后到我的提交列表中查看");
                    }
                    //允许重新提交
                    submitted = false;
                }
            });
        }

        function afterSubmit(data) {
            //todo display the result
            var resultBox = $('.result-box');
            var resultLink = '<a href="{{URL::action('User\ProblemsController@submissionDetail')}}?id=' + data.submissionId + '">查看详情</a>';
            resultBox.html(data.result + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Run time:&nbsp;&nbsp;' + data.time + 'ms&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + resultLink);
            resultBox.css('display', 'block');
            switch (data.result) {
                case 'Accepted!':
                    resultBox.addClass('success');
                    break;
                case 'Failed!':
                    resultBox.addClass('failed');
                    break;
            }
        }

    </script>
@endsection
