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
                @for($i = 0; $i < count($submissions); $i++)
                    <tr>
                        <th scope="row">
                            <a href="{{ URL::action('User\ProblemsController@submissionDetail',array('id'=>$submissions[$i]['id'])) }}">
                                {{$i+1}}
                            </a>
                        </th>
                        <td>
                            <a href="{{ URL::action('User\ProblemsController@problemDetail',array('id'=>$submissions[$i]['problem_id'])) }}">
                                {{ $problems[$submissions[$i]['problem_id']]['title'] }}
                            </a>
                        </td>
                        <td>{{ $submissions[$i]['created_at'] }}</td>
                        <td>
                            {{ $submissions[$i]['language'] }}
                        </td>
                        <td>
                            @if($submissions[$i]['run_time'] == -1)
                                该提交尚未运行完毕
                            @else
                                {{ $submissions[$i]['run_time'] }}ms
                            @endif
                        </td>
                        <td class="alert-{{-- item.result|translate_result_class --}}">
                            <strong>{{ $submissions[$i]['result'] }}</strong>
                        </td>

                    </tr>
                @endfor

                </tbody>
            </table>
            @if(count($submissions) == 0)
                <p>你还没有提交记录!</p>
            @endif
        </div>
    </div>
@endsection
