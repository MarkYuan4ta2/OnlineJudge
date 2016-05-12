@extends('layouts.app')

@section('title')
    {{$contest->name}}
@endsection

@section('style')
@endsection

@section('content')
    <div class="container main">
        <ul class="nav nav-tabs nav-tabs-google">
            <li role="presentation">
                <a href="{{ URL::action('User\UserController@contestDetail',array('id'=>$_GET['id'])) }}">比赛详情</a>
            </li>
            <li role="presentation" class="active">
                <a href="">排名</a>
            </li>
        </ul>

        <h2 class="text-center">{{ $contest->name }}&nbsp;&nbsp;排名</h2>
        <div class="row">
            <div class="col-lg-12 table-responsive">
                @if(isset($userList) and count($userList) != 0)
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th class="text-center">用户名</th>
                            <th class="text-center">通过数</th>
                            <th class="text-center">总提交</th>
                        </tr>
                        </thead>
                        <tbody class="rank">
                        @foreach($userList as $user)
                            <tr>
                                <th scope="row">{{$user->id}}</th>
                                <td>
                                    <a>
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td>{{ $user->totalAccpetCount }}</td>
                                <td>{{ $user->totalSubmissionsCount }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p>还没有结果</p>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
