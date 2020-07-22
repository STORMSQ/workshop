<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    //
    protected $table = 'classes';
    protected $primaryKey = 'classes_id';

    public function users(){
        return $this->belongsToMany('App\Model\Users','overview','classes_id','user_id');

    }

    public function semester(){

        return $this->belongsTo('App\Model\Semester');
    }
    public function overview(){
        return $this->hasMany('App\Model\Overview','classes_id');
    }

    public function condition(){
        return $this->hasMany('App\Model\Condition','classes_id');
    }

    public function condition2(){
        return $this->hasMany('App\Model\Condition','key2');
    }


}
