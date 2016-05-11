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
                @if()
                <table class="table table-bordered text-center">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">用户名</th>
                        <th class="text-center">AC / 总提交</th>
                    </tr>
                    </thead>
                    <tbody class="rank">
                    {% for item in rank %}
                    <tr>
                        <th scope="row">{% if item.total_ac_number %}{{ forloop.counter}}{% else %}-{% endif %}</th>
                        <td>
                            <a href="/contest/{{ contest.id }}/submissions/?user_id={{ item.user__id }}">
                                {{ item.user__username }}
                            </a>
                            {% if show_real_name %}
                            （{{ item.user__real_name }}）
                            {% endif %}
                        </td>
                        <td>{{ item.total_ac_number }} / {{ item.total_submission_number }}</td>
                        <td>{% if item.total_time %}{{ item.total_time|format_seconds }}{% else %}--{% endif %}</td>
                        {% autoescape off %}
                        {% for problem in contest_problems %}
                        <td class="{% get_submission_class item problem %}">
                            {% get_submission_content item problem %}
                        </td>
                        {% endfor %}
                        {% endautoescape %}
                    </tr>
                    {% endfor %}
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
