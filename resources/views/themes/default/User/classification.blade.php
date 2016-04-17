<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
            分类
        </h3>
    </div>
    <ul class="list-group">
        @if(isset($classificationList))
            @for($i = 0; $i<(count($classificationList)<10?count($classificationList):10);$i++)
                <li class="list-group-item problem-tag"
                    onclick="">
                    <span class="badge">{{ $classificationList[$i]->problems_count }}</span>
                    {{ $classificationList[$i]->name }}
                </li>
            @endfor
        @else
            <li class="list-group-item problem-tag">暂无分类</li>
        @endif
    </ul>
</div>