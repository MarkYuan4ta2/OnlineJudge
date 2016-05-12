@extends('layouts.app')

@section('title')
    {{$contest->name}}
@endsection

@section('style')
@endsection

@section('content')
    <div class="container main">
        <ul class="nav nav-tabs nav-tabs-google">
            <li role="presentation" class="active">
                <a href="">比赛详情</a>
            </li>
            <li role="presentation">
                <a href="{{ URL::action('User\UserController@contestRank',array('id'=>$_GET['id'])) }}">排名</a>
            </li>
        </ul>
        <h2 class="text-center">{{ $contest->name }}</h2>

        <hr>
        <div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>开始时间</th>
                    <th>结束时间</th>
                    <th>状态</th>
                    <th>创建者</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $contest->start_time }}</td>
                    <td>{{ $contest->end_time }}</td>
                    <td>{{ trans('messages.'.$contest->state) }}</td>
                    <td>{{ $teacherList[$contest->created_by]->name }}</td>
                </tr>
                </tbody>
            </table>
            <hr>
            <div class="text-center">{!! $contest->description !!}</div>
        </div>

        <hr>
        @if($contest->state != 'not_start' and $contest->state != 'other')
            <h2 class="text-center">题目列表</h2>
            <div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>题目</th>
                        <th>难度</th>
                        <th>通过率</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($problemList); $i++)
                        <tr>
                            <th>
                                <span class="">{{$i+1}}</span>
                            </th>
                            <th scope="row"><a
                                        href="{{ URL::action('User\UserController@contestProblemDetail',array('p_id'=>$problemList[$i]->id, 'c_id'=>$contest->id)) }}">{{ $problemList[$i]->title }}</a>
                            </th>
                            <td>{{ $problemList[$i]->difficulty }}</td>
                            <td>
                                @if($problemList[$i]->total_submit_number == 0 || $problemList[$i]->total_accepted_number == 0)
                                    0%
                                @else
                                    {{ floor($problemList[$i]->total_accepted_number/$problemList[$i]->total_submit_number) }}
                                    %
                                @endif
                            </td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                <p>当前题目还未揭晓</p>
            </div>
        @endif

    </div>
@endsection

@section('script')
@endsection
