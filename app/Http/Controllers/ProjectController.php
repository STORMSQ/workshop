<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function project_home()
    {
        return view('admin.project.index');
    }
    public function project_add()
    {
        return view('admin.project.add');
    }
}
