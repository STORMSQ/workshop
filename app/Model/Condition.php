<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    //
    protected $table = 'condition';

    public function classes(){

        return $this->belongsTo('App\Model\Classes');
    }
    
}
