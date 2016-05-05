<?php

namespace App\Http\Controllers\Admin;

use App\Announcement;
use App\Classification;
use App\Group;
use App\group_user;
use App\Problem;
use App\Submission;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index(Request $request)
    {
        //'Accepted','Time Limit Exceeded','Compile Error','Wrong Answer'
        $accepted = Submission::where('result', 'Accepted')->count();
        $timeExceeded = Submission::where('result', 'Time Limit Exceeded')->count();
        $compileError = Submission::where('result', 'Compile Error')->count();
        $wrongAnswer = Submission::where('result', 'Wrong Answer')->count();

        $customUser = User::where('is_admin', 0)->count();
        $admin = User::where('is_admin', 1)->count();
        $superAdmin = User::where('is_admin', 2)->count();

        $data = [
            'accepted' => $accepted,
            'timeExceeded' => $timeExceeded,
            'compileError' => $compileError,
            'wrongAnswer' => $wrongAnswer,
            'customUser' => $customUser,
            'admin' => $admin,
            'superAdmin' => $superAdmin,
        ];
        return view('themes.default.Admin.home', $data);
    }

    function listProblems(Request $request)
    {
        $problemList = Problem::all();
        //get teacher user list (include admin) index by id
        $teacherList = User::where('is_admin', '>', 0)->get()->keyBy('id');
        $data = [
            'problemList' => $problemList,
            'teacherList' => $teacherList,
        ];
        return view('themes.default.Admin.problem_list', $data);
    }

    function addProblems(Request $request)
    {
        return view('themes.default.Admin.problem_edit');
    }

    function editProblems(Request $request)
    {
        $problem = Problem::where('id', $request->id)->first();
        $data = [
            'problem' => $problem,
        ];
        return view('themes.default.Admin.problem_edit', $data);
    }

    function deleteProblems(Request $request)
    {
        Problem::destroy($request->id);
        //todo:
        //remove files associated with this problem
        //delete test case of this problem
        //delete students' submission record of this problem

        return redirect()->action('Admin\AdminController@listProblems');
    }

    function saveProblems(Request $request)
    {
        $problem_form = $request->all();

        if (isset($problem_form['id'])) {
            $problem = Problem::where('id', $problem_form['id'])->first();
        } else {
            $problem = new Problem;
        }

        $problem->title = $problem_form['title'];
        $problem->description = $problem_form['description'];
        $problem->time_limit = $problem_form['time_limit'];
        $problem->memory_limit = $problem_form['memory_limit'];
        $problem->difficulty = $problem_form['difficulty'];
        //visible field read from a checkbox in web page
        isset($problem_form['visible']) and $problem->visible = true or $problem->visible = false;
        $problem->input_description = $problem_form['input_description'];
        $problem->output_description = $problem_form['output_description'];
        $problem->classification = $problem_form['classification'];
        $problem->test_case_in = $problem_form['test_case_in'];
        $problem->test_case_out = $problem_form['test_case_out'];
        $problem->created_by = $request->user()->id;

        //get random key by md5 created_by field and title field and current time stamp
        //the result of md5 might start with number, so add difficult field as header
        $random_key = $problem->difficulty . md5($problem->created_by . $problem->title . time());
        $problem->random_key = $random_key;

        //todo:add contest
        if ($request->hasFile('final_case_in')) {
//            dd('get final_case_in');
            $case_in = $request->file('final_case_in');
            $problem->final_test_case_address_in = $case_in->move(public_path() . '/uploads/' . $random_key . '/', $case_in->getClientOriginalName());
        }
        if ($request->hasFile('final_case_out')) {
//            dd('get final_case_out');
            $case_out = $request->file('final_case_out');
            $problem->final_test_case_address_out = $case_out->move(public_path() . '/uploads/' . $random_key . '/', $case_out->getClientOriginalName());
        }

        $problem->save();

        return redirect()->action('Admin\AdminController@listProblems');
    }

    function listClassifications()
    {
        //get teacher user list (include admin) index by id
        $teacherList = User::where('is_admin', '>', 0)->get()->keyBy('id');
        $data = [
            'teacherList' => $teacherList
        ];
        return view('themes.default.Admin.classification_list', $data);
    }

    function saveClassifications(Request $request)
    {
        if (isset($request->id)) {//receive request from ajax post
            $classification = Classification::where('id', $request->id)->first();
            $return = 'succeed!';
        } else {//receive request from form post
            $classification = new Classification;
            $return = redirect()->action('Admin\AdminController@listClassifications');
        }

        $classification->name = $request->name;
        $classification->created_by = $request->user()->id;
        $classification->save();

        return $return;
    }

    function deleteClassifications(Request $request)
    {
        Classification::destroy($request->id);

        return redirect()->action('Admin\AdminController@listClassifications');
    }

    function listUsers(Request $request)
    {
        $userType = [
            0 => '普通用户',
            1 => '管理员',
            2 => '超级管理员'
        ];
        $userList = User::all();

        $data = [
            'userType' => $userType,
            'userList' => $userList
        ];

        return view('themes.default.Admin.user_list', $data);
    }

    function saveUserInfo(Request $request)
    {
        isset($request->id) and $id = intval($request->id);
        isset($request->is_admin) and $is_admin = intval($request->is_admin);

        $user = User::where('id', $id)->first();
        $user->is_admin = $is_admin;

        $user->save();
        return '修改成功！';
    }

    function listGroups(Request $request)
    {
        //super admin can get all group info, custom admin can only get his/her own group info
        if ($request->user()->is_admin == 2) {
            $groupList = Group::all();
        } else if ($request->user()->is_admin == 1) {
            $groupList = Group::where('leader_id', $request->user()->id)->get();
        }
        $teacherList = User::where('is_admin', '>', 0)->get()->keyBy('id');

        $data = [
            'groupList' => $groupList,
            'teacherList' => $teacherList,
        ];
        return view('themes.default.Admin.group_list', $data);
    }

    function saveGroup(Request $request)
    {
        isset($request->name) and $name = strval($request->name);
        isset($request->description) and $description = strval($request->description);
        isset($request->leader_id) and $leader_id = intval($request->leader_id);

        if (isset($request->id)) {//modify an old group info
            $group = Group::where('id', $request->id)->first();
        } else {//add a new group info
            if (Group::where('name', $name)->count() != 0) {
                return 'name already exist!';
            }
            $group = new Group;
        }

        $group->name = $name;
        $group->description = $description;
        $group->leader_id = isset($leader_id) ? $leader_id : $request->user()->id;

        $group->save();

        return 'success';
    }

    function groupDetail(Request $request)
    {
        $groupInfo = Group::where(['id' => $request->id, 'leader_id' => $request->user()->id])->first();
        //prevent some admins who want to access someone else's group detail
        if ($groupInfo == null) {
            return redirect()->action('Admin\AdminController@listGroups');
        } else {
            $memberList = group_user::where(['group_id' => $request->id, 'accepted' => true])->get();
            $userList = User::all()->keyBy('id');
            $teacherList = User::where('is_admin', '>', 0)->get()->keyBy('id');
            $data = [
                'groupInfo' => $groupInfo,
                'memberList' => $memberList,
                'userList' => $userList,
                'teacherList' => $teacherList,
            ];
            return view('themes.default.Admin.group_detail', $data);
        }
    }

    function groupApplicationList(Request $request)
    {
        if ($request->user()->is_admin == 2) {
            $applicationList = group_user::where('accepted', false)->get();
        } else {
            $applicationList = group_user::where(['accepted' => false, 'leader_id' => $request->user()->id])->get();
        }
        $groupList = Group::all()->keyBy('id');
        $userList = User::all()->keyBy('id');

        $data = [
            'groupList' => $groupList,
            'applicationList' => $applicationList,
            'userList' => $userList,
        ];

        return view('themes.default.Admin.group_applications_list', $data);
    }

    function replyApplication(Request $request)
    {
        $id = intval($request->id);
        $reply = intval($request->reply);

        if ($reply) {//accept user to join in the group
            $application = group_user::where('id', $id)->first();
            $application->accepted = $reply;
            $application->save();

            //members_count + 1
            $group = Group::where('id', $application->group_id)->first();
            $group->members_count += 1;
            $group->save();
        } else {
            //delete this record
            group_user::destroy($id);
        }

        return 'success';
    }

    function removeMember(Request $request)
    {
        $id = intval($request->id);

        $application = group_user::where('id', $id)->first();
        //members_count - 1
        $group = Group::where('id', $application->group_id)->first();
        if ($group->members_count > 0) {
            $group->members_count -= 1;
        }
        $group->save();

        group_user::destroy($id);

        return 'success';
    }

    function listAnnouncements(Request $request)
    {
        if ($request->user()->is_admin == 2) {
            $announcementList = Announcement::all();
        } else {
            $announcementList = Announcement::where('created_by')->get();
        }
        $teacherList = User::where('is_admin', '>', 0)->get()->keyBy('id');

        $data = [
            'announcementList' => $announcementList,
            'teacherList' => $teacherList,
        ];

        return view('themes.default.Admin.announcements_list', $data);
    }

    function saveAnnouncements(Request $request)
    {
        isset($request->title) and $title = strval($request->title);
        isset($request->contents) and $content = strval($request->contents);

        if (isset($request->id) and $request->id != "") {
            $announcement = Announcement::where('id', intval($request->id))->first();
        } else {
            $announcement = new Announcement;
        }

        $announcement->title = $title;
        $announcement->content = $content;
        $announcement->created_by = $request->user()->id;
        $announcement->save();

        return 'success';
    }
}
