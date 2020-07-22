<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Overview extends Model
{
    protected $table = 'overview';
    protected $primaryKey = 'overview_id';
    public function classes(){
        return $this->belongsTo('App\Model\Classes','classes_id');
    }

}
