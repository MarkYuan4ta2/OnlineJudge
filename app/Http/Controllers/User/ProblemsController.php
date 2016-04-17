<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Problem;

class ProblemsController extends Controller
{
    //list all the problems
    function index(Request $request)
    {
        $problemList = Problem::where('visible', 1)->get();
        return view('themes.default.User.problems', ['problemList' => $problemList]);
    }

    //go display one certain problems info
    function problemDetail(Request $request)
    {
        $id = $request->id;
        //这里暂时不考虑直接修改链接进来的情况
        $problem = Problem::where(['id' => $id, 'visible' => 1])->first();
        return view('themes.default.User.problem_detail', ['problem' => $problem]);
    }
}
