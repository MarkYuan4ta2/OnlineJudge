@extends('layouts.app')

@section('title')
    {{$groupInfo->name}}
@endsection

@section('style')
@endsection

@section('content')
    <div class="container main">
        <ul class="nav nav-tabs nav-tabs-google">
            <li role="presentation" class="active">
                <a href="">详细信息</a>
            </li>
        </ul>
        <h2 class="text-center">{{ $groupInfo->name }}</h2>

        <p class="text-muted text-center">发布时间 : {{ $groupInfo->created_at }}&nbsp;&nbsp;
            创建者 : {{ $teacherList[$groupInfo->leader_id]->name }}
        </p>

        <div>
            <div class="group-section">
                <label class="group-label">描述</label>

                <p class="group-detail">{{ $groupInfo->description }}</p>
            </div>
        </div>
        @if(!$joined)
            <hr>
            <div>
                <div class="form-group">
                    <input id="groupId" value="{{ $groupInfo->id }}" type="hidden">
                    <label>申请信息</label>
                    <textarea maxlength="30" placeholder="不超过30字" class="form-control" id="applyMessage"
                              rows="2"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="sendApplication">申请加入</button>
                </div>
            </div>
        @endif

    </div>
@endsection

@section('script_before')
@endsection

@section('script')
    <script>
        //post加入小组申请
    </script>
@endsection
