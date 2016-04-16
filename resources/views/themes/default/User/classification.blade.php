<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
            分类
        </h3>
    </div>
    <ul class="list-group">
        @if(isset($classificationList))
        @foreach($classificationList as $item)
        <li class="list-group-item problem-tag"
            onclick="">
            <span class="badge">{{ $item->problems_count }}</span>
            {{ $item->name }}
        </li>
        @endforeach
        @else
            <li class="list-group-item problem-tag">暂无分类</li>
        @endif
    </ul>
</div>