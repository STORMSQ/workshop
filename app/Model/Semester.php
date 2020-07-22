<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';
    protected $primaryKey = 'semester_id';
    public function classes(){
        return $this->hasMany('App\Model\Classes');
    }

    public function overview(){

        return $this->hasManyThrough('App\Model\Overview', 'App\Model\Classes','classes_id','classes_id');
    }

}
