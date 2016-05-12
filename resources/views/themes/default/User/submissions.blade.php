@extends('layouts.app')

@section('title')
    我的提交列表
@endsection

@section('style')
@endsection

@section('content')
    <div class="container">
        <div class="col-md-12 col-lg-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>题目名称</th>
                    <th>提交时间</th>
                    <th>语言</th>
                    <th>运行时间</th>
                    <th>结果</th>
                </tr>
                </thead>
                <tbody>
                @foreach($submissions as $submission)
                    <tr>
                        <th scope="row">
                            <a href="{{ URL::action('User\ProblemsController@submissionDetail',array('id'=>$submission->id)) }}">
                                {{$submission->id}}
                            </a>
                        </th>
                        <td>
                            <a href="{{ URL::action('User\ProblemsController@problemDetail',array('id'=>$submission->problem_id)) }}">
                                {{ $problemList[$submission->problem_id]->title }}
                            </a>
                        </td>
                        <td>{{ $submission->created_at }}</td>
                        <td>
                            {{ $submission->language }}
                        </td>
                        <td>
                            @if($submission->run_time == -1)
                                该提交尚未运行完毕
                            @else
                                {{ $submission->run_time }}ms
                            @endif
                        </td>
                        <td class=
                            @if($submission->result == 'Accepted')"alert-success"
                        @elseif($submission->result == 'Waiting')"alert-warning"
                        @else"alert-danger"
                        @endif
                        >
                        <strong>{{ $submission->result }}</strong>
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>
            @if(count($submissions) == 0)
                <p>你还没有提交记录!</p>
            @endif
        </div>
    </div>
@endsection
