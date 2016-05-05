<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
            公告
        </h3></div>
    {{--<div class="panel-body">--}}
    <ul class="list-group">
        @if(isset($announcements))
            @for($i = 0; $i < count($announcements); $i++)
                {{--<p style="margin-bottom: 10px;">{{ $i+1 }}.&nbsp;&nbsp;--}}
                {{--<a href="" target="_blank">--}}
                {{--{{ $announcements[$i]->title }}--}}
                {{--</a>--}}
                {{--</p>--}}
                <li class="list-group-item" onclick="">
                    {{ $i+1 }}.&nbsp;&nbsp;
                    <a href="" target="_blank">
                        {{ $announcements[$i]->title }}
                    </a>
                </li>
            @endfor
        @else
            <li class="list-group-item">暂无可显示的公告</li>
        @endif
    </ul>
    {{--</div>--}}
</div>