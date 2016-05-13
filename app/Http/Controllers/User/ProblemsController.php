<?php

namespace App\Http\Controllers\User;

use App\Submission;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Problem;

class ProblemsController extends Controller
{
    //list all the problems
    function index(Request $request)
    {
        $this->refreshProblemSubmissionsCount();
        $problemList = Problem::where('visible', 1)->orderBy('id', 'desc')->get();

        for ($i = 0; $i < count($problemList); $i++) {
            $problemList[$i]['accepted'] = 0;

            if ($problemList[$i]->total_accepted_number > 0) {
                $problemList[$i]['accepted'] = 1;
            }
        }

        $data = [
            'problemList' => $problemList,
        ];
        return view('themes.default.User.problems', $data);
    }

    function refreshProblemSubmissionsCount()
    {
        $problemList = Problem::all();
        foreach ($problemList as $problem) {
            if ($problem->total_submit_number != $problem->submissions()->get()->count()) {
                $problem->total_submit_number = $problem->submissions()->get()->count();
                $problem->save();
            }
            if ($problem->total_accepted_number != $problem->acceptedSubmissions()->get()->count()) {
                $problem->total_accepted_number = $problem->acceptedSubmissions()->get()->count();
                $problem->save();
            }
        }
    }

    //go display one certain problems info
    function problemDetail(Request $request)
    {
        $id = $request->id;
        //这里暂时不考虑直接修改链接进来的情况
        $problem = Problem::where(['id' => $id, 'visible' => 1])->first();
        return view('themes.default.User.problem_detail', ['problem' => $problem]);
    }

    function receiveCode(Request $request)
    {
        $code = $request->code;
        $language = $request->language;
        $problemId = $request->problemId;
        $id = $request->user()->id;

        $submission = new Submission;
        $submission->student_id = $id;
        $submission->problem_id = $problemId;
        $submission->language = $language;
        $submission->code = $code;
        $submission->run_time = -1;
        $submission->save();

        $submissionId = $submission->id;
        $return = array(
            'submissionId' => $submissionId,
        );
        return json_encode($return);
    }

    function submissionResult(Request $request)
    {
        $sub = Submission::where('id', $request->id)->first();
        if ($sub->run_time == -1) {
            //judge not yet
            return json_encode(array('result' => -1));
        } else {
            $return = array(
                'result' => $sub->result,
                'time' => $sub->run_time,
                'submissionId' => $sub->id,
            );
            return json_encode($return);
        }
    }

    function userSubmissions(Request $request)
    {
        if (isset($request->problemId)) {
            $filter = ['problem_id' => intval($request->problemId), 'student_id' => $request->user()->id];
        } else {
            $filter = ['student_id' => $request->user()->id];
        }
        $submissions = Submission::where($filter)->get();
        $problemList = Problem::all()->keyBy('id');
//        dd($problemList);
        $data = [
            'submissions' => $submissions,
            'problemList' => $problemList
        ];

        return view('themes.default.User.submissions', $data);
    }

    function submissionDetail(Request $request)
    {
        $submission = Submission::where(['id' => intval($request->id)])->first();
        $problem = Problem::where(['id' => $submission->problem_id])->first();

        $data = [
            'submission' => $submission,
            'problem' => $problem
        ];

        return view('themes.default.User.submission_detail', $data);
    }
}
