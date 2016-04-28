<ul class="dropdown-menu" role="menu">
    @if(Auth::user()->is_admin)
        <li><a href="{{ url('/admin') }}"><i class="fa fa-btn"></i>管理员后台</a></li>
        <li role="separator" class="divider"></li>
    @endif
    <li><a href="{{ url('/home') }}"><i class="fa fa-btn"></i>个人主页</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="{{ url('/logout') }}"><i
                    class="fa fa-btn fa-sign-out"></i>{{ trans('messages.logout') }}</a></li>
</ul>