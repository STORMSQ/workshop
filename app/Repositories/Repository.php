<?php
namespace App\Repositories;
use App\Repositories\ModelFactory;
use DB;
use Carbon\Carbon;
use App\User;
use Log;
class Repository {
    
   
    public function getModel($modelName='')
    {
        $isModel = $this->isModel($modelName);
        
        if($isModel){
            $model = $this->modelSetting($modelName);
            return $model;
        }else{
            return '';
        }
    }
    

    private function isModel($modelName)
    {
        $isModel = app_path().'/Models/'.$modelName.'.php';
        if(!file_exists($isModel)){
           return false;
        }else{
            return true;
        }
    }
    private function modelSetting($modelName)
    {
        $ModelFactory = new ModelFactory;
        $ModelFactory::bind($modelName);
        $model =  app('Model');  
        return $model;
    }   
    
    
    
   
}