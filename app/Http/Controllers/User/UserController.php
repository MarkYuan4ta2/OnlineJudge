<?php

namespace App\Http\Controllers\User;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    function homePage(Request $request)
    {
        $UserInfo = User::where('id', $request->user()->id)->first();
        return view('themes.default.User.user_page', ['UserInfo' => $UserInfo]);
    }

    function saveAvatar(Request $request)
    {
        if ($request->hasFile('fileToUpload')) {
            $avatar = $request->file('fileToUpload');
            $avatarName = $request->user()->name . md5($request->user()->email) .'.' . $avatar->getClientOriginalExtension();
            $avatarPath = $avatar->move(public_path() . '/uploads/avatars/', $avatarName);

            $UserInfo = User::where('id', $request->user()->id)->first();
            $UserInfo->avatar = 'uploads/avatars/' . $avatarName;
            $UserInfo->save();

            return $avatarPath;
        }
        return 'No files received';
    }
}
