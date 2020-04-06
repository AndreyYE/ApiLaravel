<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function cabinet()
    {
       $admin =  \Auth::guard('admin')->user();
       return view('admin.cabinet', compact('admin'));
    }
}
