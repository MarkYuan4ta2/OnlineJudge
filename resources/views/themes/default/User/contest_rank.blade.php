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
                            <th>#</th>
                            <th class="text-center">用户名</th>
                            <th class="text-center">AC / 总提交</th>
                        </tr>
                        </thead>
                        <tbody class="rank">
                        @for($i = 1; $i < count($userList)+1; $i++)
                            <tr>
                                <th scope="row">{{$i}}</th>
                                <td>
                                    <a>
                                        {{ $userList[$i]->name }}
                                    </a>
                                </td>
                                <td>{{ $userList[$i]->totalAccpetCount }} / {{ $userList[$i]->totalSubmissionsCount }}</td>
                            </tr>
                        @endfor
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
