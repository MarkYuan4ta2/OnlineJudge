<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function groups()
    {
        return $this->belongsToMany('App\Group', 'group_users', 'user_id', 'group_id');
    }

    public function submissions()
    {
        return $this->hasMany('App\Submission', 'student_id', 'id');
    }

    public function hasGroups()
    {
        return $this->hasMany('App\Group', 'leader_id', 'id');
    }
}
