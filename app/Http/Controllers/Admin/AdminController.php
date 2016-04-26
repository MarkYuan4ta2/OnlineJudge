<?php

namespace App\Http\Controllers\Admin;

use App\Classification;
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
        $submissions = Submission::all();
        $data = [
            'submissions' => $submissions,
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
}
