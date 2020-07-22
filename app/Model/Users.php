<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public function classes(){

        return $this->belongsToMany('App\Model\Classes','overview','user_id','classes_id')->withPivot('user_id','date_due1','date_due2');

    }

    public function semester(){

        return $this->hasManyThrough('App\Model\Semester', 'App\Model\Classes', 'classes_id', 'semester_id');
    }

}
