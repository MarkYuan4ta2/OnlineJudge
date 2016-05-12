<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    public function submissions()
    {
        return $this->hasMany('App\Submission', 'problem_id', 'id');
    }

    public function acceptedSubmissions()
    {
        return $this->submissions()->where('result', 'Accepted');
    }
}
