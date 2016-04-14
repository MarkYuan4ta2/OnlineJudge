<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
            公告
        </h3></div>
    <div class="panel-body">
        @if(isset($announcements))
            @foreach($announcements as $announcement)
                <p>
                    <a href="" target="_blank">
                        {{ $announcement->title }}
                    </a>
                </p>
            @endforeach
        @else
            <p>暂无可显示的公告</p>
        @endif
    </div>
</div>