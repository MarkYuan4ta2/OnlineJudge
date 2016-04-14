<?php

namespace App\Http\Controllers\Admin;

use App\Problem;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function index(Request $request)
    {
        return view('themes.default.Admin.home');
    }

    function listProblems(Request $request)
    {
        $problemList = Problem::all();
        return view('themes.default.Admin.problem_list', ['problemList' => $problemList]);
    }

    function addProblems(Request $request)
    {
        return view('themes.default.Admin.problem_edit');
    }

    function editProblems(Request $request)
    {
        $problem = Problem::where('id', $request->id)->first();
        return view('themes.default.Admin.problem_edit', ['problem' => $problem]);
    }

    function deleteProblems(Request $request)
    {
//        dd($request->id);
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
//        dd($problem_form);

        if (isset($problem_form['id'])){
            $problem = Problem::where('id', $problem_form['id'])->first();
        }else{
            $problem = new Problem;
        }

        $problem->title = $problem_form['title'];
        $problem->description = $problem_form['description'];
        $problem->time_limit = $problem_form['time_limit'];
        $problem->memory_limit = $problem_form['memory_limit'];
        $problem->difficulty = $problem_form['difficulty'];
        isset($problem_form['visible']) and $problem->visible = true or $problem->visible = false;
        $problem->input_description = $problem_form['input_description'];
        $problem->output_description = $problem_form['output_description'];

        $problem->save();

        return redirect()->action('Admin\AdminController@listProblems');
    }
}
