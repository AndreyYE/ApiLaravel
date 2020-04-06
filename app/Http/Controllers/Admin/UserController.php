<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list()
    {
        $users = User::paginate(10);
        return view('admin.user.users',compact('users'));
    }
    public function user(User $user)
    {
      $user->loadCount('posts');
        return view('admin.user.user',compact('user'));
    }
}
