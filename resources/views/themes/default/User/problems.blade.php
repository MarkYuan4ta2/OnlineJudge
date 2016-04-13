@extends('layouts.app')

@section('style')
    <link href="{{ asset('themes/default/css/index.css') }}" rel="stylesheet" type="text/css">
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
                        @foreach($problemList as $problem)
                            <tr>
                                <th>
                                    <span class="">{{ $problem->id }}</span>
                                </th>
                                <th scope="row"><a href="{{ URL::action('User\ProblemsController@problemDetail',array('id'=>$problem->id)) }}">{{ $problem->title }}</a></th>
                                <td>{{ $problem->difficulty }}</td>
                                <td>
                                    @if($problem->total_submit_number == 0 || $problem->total_accepted_number == 0)
                                        0%
                                    @else
                                        {{ floor($problem->total_accepted_number/$problem->total_submit_number) }}%  ({{$problem->total_accepted_number}}/{{$problem->total_submit_number}})
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
