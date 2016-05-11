<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'group_users', 'group_id', 'user_id');
    }

    public function contests()
    {
        return $this->belongsToMany('App\Contest', 'group_contests', 'group_id', 'contest_id');
    }
}
