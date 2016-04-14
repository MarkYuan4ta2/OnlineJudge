@extends('layouts.app')

@section('style')
    <link href="{{ asset('themes/default/css/collection.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('themes/default/css/problems.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container main">
        <div class="row">
            <div class="col-md-9 col-lg-9">
                <div class="row">
                    <div class="right">
                        <form class="form-inline" method="get">
                            <div class="form-group-sm">
                                <input name="keyword" class="form-control" value="" placeholder="请输入关键词">
                                <input type="submit" value="搜索" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
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
                                            href="{{ URL::action('User\ProblemsController@problemDetail',array('id'=>$problemList[$i]->id)) }}">{{ $problemList[$i]->title }}</a>
                                </th>
                                <td>{{ $problemList[$i]->difficulty }}</td>
                                <td>
                                    @if($problemList[$i]->total_submit_number == 0 || $problem->total_accepted_number == 0)
                                        0%
                                    @else
                                        {{ floor($problemList[$i]->total_accepted_number/$problem->total_submit_number) }}%
                                        ({{$problemList[$i]->total_accepted_number}}/{{$problemList[$i]->total_submit_number}})
                                    @endif
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                @include('themes.default.User.announcements')
                @include('themes.default.User.classification')
            </div>
        </div>
    </div>
@endsection
