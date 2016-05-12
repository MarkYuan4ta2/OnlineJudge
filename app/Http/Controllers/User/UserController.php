<?php

namespace App\Http\Controllers\User;

use App\Contest;
use App\Group;
use App\group_user;
//use Illuminate\Foundation\Auth\User;
use App\Problem;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

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
            $avatarName = $request->user()->name . md5($request->user()->email) . '.' . $avatar->getClientOriginalExtension();
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

        $joined = group_user::where(['user_id' => $request->user()->id, 'group_id' => $request->id])->count();
        $joined = ($joined != 0);

        $data = [
            'joined' => $joined,
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

    function contests(Request $request)
    {
        //refresh contest state
        $this->contestStateCheck();
        //获得所有已加入的小组
        $groupList = User::where('id', $request->user()->id)->first()->groups()->where('accepted', true)->get();

        $contestList = collect();
        foreach ($groupList as $group) {
            $contestList = $contestList->merge($group->contests()->get());
        }
        $contestList = $contestList->keyBy('name');

        $teacherList = User::where('is_admin', '>', 0)->get()->keyBy('id');

        $data = [
            'contestList' => $contestList,
            'teacherList' => $teacherList,
        ];

        return view('themes.default.User.contests', $data);
    }

    function contestDetail(Request $request)
    {
        //refresh contest state
        $this->contestStateCheck();
        
        $problemList = Contest::where('id', $request->id)->first()->problems()->get();
        $contest = Contest::where('id', $request->id)->first();
        $teacherList = User::where('is_admin', '>', 0)->get()->keyBy('id');

        $data = [
            'contest' => $contest,
            'teacherList' => $teacherList,
            'problemList' => $problemList,
        ];

        return view('themes.default.User.contest_detail', $data);
    }

    function contestProblemDetail(Request $request)
    {
        $problemId = $request->p_id;
        $contestId = $request->c_id;
        //这里暂时不考虑直接修改链接进来的情况
        $problem = Problem::where(['id' => $problemId])->first();
        $contest = Contest::where(['id' => $contestId])->first();
        $teacher = User::where('id', $contest->created_by)->first();
        $data = [
            'problem' => $problem,
            'contest' => $contest,
            'teacher' => $teacher,
        ];

        return view('themes.default.User.contest_problem_detail', $data);
    }

    function contestRank(Request $request)
    {
        $contest = Contest::where('id', $request->id)->first();
        $groupList = $contest->groups()->get();
        $userList = collect();
        foreach ($groupList as $group) {
            $userList = $userList->merge($group->users()->get());
        }
        $userList = $userList->keyBy('name');

        foreach ($userList as $user) {
            $info = $this->personalContestSubInfo($user, $contest);
            foreach ($info as $k => $v) {
                $userList[$user['name']][$k] = $v;
            }
        }
        $userList = $userList->sortBy('totalAcceptCount');//->keyBy('id');
//        dd($userList);

        $data = [
            'contest' => $contest,
            'userList' => $userList,
        ];

        return view('themes.default.User.contest_rank', $data);
    }

    //刷新other、end之外的比赛状态
    private function contestStateCheck()
    {
        $contestList = Contest::whereNotIn('state', ['other', 'end'])->get();
        foreach ($contestList as $contest) {
            if ($contest->state == 'not_start') {
                if (strtotime($contest->start_time) < time()) {
                    $contest->state = 'start';
                    if (strtotime($contest->end_time) < time()) {
                        $contest->state = 'end';
                    }
                    $contest->save();
                }
            } elseif ($contest->state == 'start') {
                if (strtotime($contest->end_time) < time()) {
                    $contest->state = 'end';
                    $contest->save();
                }
            } else {
                dd('you got something wrong with your contest table!');
            }
        }
    }

    private function personalContestSubInfo(User $user, Contest $contest)
    {
        $submissionList = $user->submissions()
            ->where('created_at', '>', $contest['start_time'])
            ->where('created_at', '<', $contest['end_time'])
            ->get();

        $totalSubmissionsCount = $submissionList->count();
        $totalAcceptCount = $submissionList->where('result', 'Accepted')->keyBy('problem_id')->count();
        $acceptCount = $submissionList->where('result', 'Accepted')->count();
        $waitingCount = $submissionList->where('result', 'Waiting')->count();
        $otherCount = $submissionList->count() - $acceptCount - $waitingCount;

        $info = [
            'totalSubmissionsCount' => $totalSubmissionsCount,
            'totalAccpetCount' => $totalAcceptCount,
            'acceptCount' => $acceptCount,
            'waitingCount' => $waitingCount,
            'otherCount' => $otherCount,
        ];

        return $info;
    }
}
