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
//        dump($id);
    }
}
