<div class="container">
    <div class="row">
        <!-- admin left begin-->
        <div class="col-md-2">
            <div class="list-group">
                <a class="list-group-item active">
                    <h4 class="list-group-item-heading">
                        题目管理
                    </h4>
                </a>
                <a href="{{ URL::action('Admin\AdminController@index',array('action'=>'list')) }}" class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='list') choose @endif">
                    <p class="list-group-item-text">
                        题目列表
                    </p>
                </a>
                <a href="{{ URL::action('Admin\AdminController@index',array('action'=>'add')) }}" class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='add') choose @endif">
                    <p class="list-group-item-text">
                        新增题目
                    </p>
                </a>
                <a href="{{ URL::action('Admin\AdminController@index',array('action'=>'classify')) }}" class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='classify') choose @endif">
                    <p class="list-group-item-text">
                        题目分类
                    </p>
                </a>
            </div>
        </div>
    </div>
</div>