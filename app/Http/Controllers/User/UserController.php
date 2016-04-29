<?php

namespace App\Http\Controllers\User;

use App\Group;
use App\group_user;
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

    function groups(Request $request)
    {
        $groupList = Group::all();
        $teacherList = User::where('is_admin', '>', 0)->get()->keyBy('id');
        $data = [
            'groupList' => $groupList,
            'teacherList' => $teacherList,
        ];

        return view('themes.default.User.groups', $data);
    }

    function groupDetail(Request $request)
    {
        $groupInfo = Group::where('id', $request->id)->first();
        $teacherList = User::where('is_admin', '>', 0)->get()->keyBy('id');

        $joined = group_user::where(['user_id'=> $request->user()->id, 'group_id'=>$request->id])->count();
        $joined = ($joined!=0);

        $data = [
            'joined'=>$joined,
            'groupInfo' => $groupInfo,
            'teacherList' => $teacherList,
        ];

        return view('themes.default.User.group_detail', $data);
    }

    function groupApplication(Request $request)
    {
        isset($request->user_id) and $user_id = intval($request->user_id);
        isset($request->group_id) and $group_id = intval($request->group_id);
        isset($request->addition_info) and $addition_info = strval($request->addition_info);

        $application = new group_user;
        $application->user_id = $user_id;
        $application->group_id = $group_id;
        $application->addition_info = $addition_info;

        $application->save();

        return 'success';
    }
}
