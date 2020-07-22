<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
//use App\Services\Interfaces\DirectoryService;

trait Requests{
   /* protected $DirectoryService;
    public function __construct(DirectoryService $DirectoryService){
        $this->DirectoryService = $DirectoryService;
    }*/
   

    public function get_request_array(Request $request,array $data=[]){
        if(count($data)==0){
            $data=array();
        }
        //dd($request);
        if($request->hasFile('file')){
         
           $request->file->store('images','public');
           $fileName = $request->file->hashName();
           $data['uploadFile'] = $fileName;
           $data['originalFile'] = $request->file->getClientOriginalName();
           
        }
        if($request->hasFile('document')){
            //dd($request->document);
            $request->document->store('documents','public');
            $fileName = $request->document->hashName();
            $data['uploadFile'] = $fileName;
            $data['originalFile'] = $request->document->getClientOriginalName();
        }
        if($request->hasFile('upload')){
            $request->upload->store('upload','public');
            $fileName = $request->upload->hashName();
            $data['uploadFile'] = $fileName;
        }
        foreach($request->except(['_token','banner']) as $key=> $row){
            
               if($row=='--disable--'){
                  
                unset($data[$key]);
               }else{
                unset($data[$key]);
                $data[$key]=$row;
               }

        }
        return $data;
    }
   
    
}