<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    //get contest's problem list
    public function problems()
    {
        return $this->hasMany('App\Problem', 'contest', 'id');
    }

    public function groups()
    {
//        return $this->hasMany('App\Group', 'leader_id', 'created_by');
        return $this->belongsToMany('App\Group', 'group_contests', 'contest_id', 'group_id');
    }
}
