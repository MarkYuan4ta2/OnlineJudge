<?php

namespace App\Http\Controllers\Admin;

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

    function addProblems(Request $request)
    {
        var_dump('this is add problems page');
    }
}
