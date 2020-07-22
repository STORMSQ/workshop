<?php
namespace App\Repositories\Common;
use Illuminate\Support\Facades\App;
class ModelFactory{
    public static function bind(string $stringName){
        App::bind('Model','App\Models\\'. $stringName);
    }
}