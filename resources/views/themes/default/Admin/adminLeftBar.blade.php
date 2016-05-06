    <!-- admin left begin-->
    <div class="col-md-2 col-lg-2">
        <div class="list-group">
            <a class="list-group-item active">
                <h4 class="list-group-item-heading">
                    题目管理
                </h4>
            </a>
            <a href="{{ URL::action('Admin\AdminController@listProblems',array('action'=>'list_problems')) }}"
               class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='list_problems') choose @endif">
                <p class="list-group-item-text">
                    题目列表
                </p>
            </a>
            <a href="{{ URL::action('Admin\AdminController@addProblems',array('action'=>'add_problems')) }}"
               class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='add_problems') choose @endif">
                <p class="list-group-item-text">
                    新增题目
                </p>
            </a>
            <a href="{{ URL::action('Admin\AdminController@listClassifications',array('action'=>'classify')) }}"
               class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='classify') choose @endif">
                <p class="list-group-item-text">
                    题目分类
                </p>
            </a>
        </div>

        <div class="list-group">
            <a class="list-group-item active">
                <h4 class="list-group-item-heading">
                    通用管理
                </h4>
            </a>
            <a href="{{ URL::action('Admin\AdminController@listAnnouncements',array('action'=>'announcements')) }}"
               class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='announcements') choose @endif">
                <p class="list-group-item-text">
                    公告管理
                </p>
            </a>
            <a href="{{ URL::action('Admin\AdminController@listUsers',array('action'=>'user_list')) }}"
               class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='user_list') choose @endif">
                <p class="list-group-item-text">
                    用户管理
                </p>
            </a>
        </div>

        <div class="list-group">
            <a class="list-group-item active">
                <h4 class="list-group-item-heading">
                    比赛管理
                </h4>
            </a>
            <a href="{{ URL::action('Admin\AdminController@listContests',array('action'=>'contest_list')) }}"
               class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='contest_list') choose @endif">
                <p class="list-group-item-text">
                    比赛列表
                </p>
            </a>
            <a href="{{ URL::action('Admin\AdminController@addContest',array('action'=>'add_contest')) }}"
               class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='add_contest') choose @endif">
                <p class="list-group-item-text">
                    新增比赛
                </p>
            </a>
        </div>

        <div class="list-group">
            <a class="list-group-item active">
                <h4 class="list-group-item-heading">
                    小组管理
                </h4>
            </a>
            <a href="{{ URL::action('Admin\AdminController@listGroups',array('action'=>'group_list')) }}"
               class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='group_list') choose @endif">
                <p class="list-group-item-text">
                    小组列表
                </p>
            </a>
            <a href="{{ URL::action('Admin\AdminController@groupApplicationList',array('action'=>'group_request')) }}"
               class="list-group-item @if(isset($_GET['action']) and $_GET['action']=='group_request') choose @endif">
                <p class="list-group-item-text">
                    小组申请
                </p>
            </a>
        </div>
    </div>