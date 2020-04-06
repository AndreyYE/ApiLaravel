<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login;
use App\Http\Requests\Register;
use App\Models\Admin;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:admin')->only(['formLogin','login','formRegister','register']);
    }

    protected function authenticated(Request $request, $user)
    {
        if ( auth()->guard('admin')->user()->id ) {// do your magic here
            return redirect()->route('admin.cabinet');
        }

        return redirect()->route('admin.login');
    }

    public function formRegister()
    {
        return view('admin.auth.registration');
    }
    public function formLogin()
    {
        return view('admin.auth.login');
    }
    public function registration(Register $request)
    {
        try{
            $user = Admin::create(array_merge(request(['name', 'email']),['password'=>Hash::make(\request('password'))]));

            auth()->guard('admin')->login($user);
        }catch (\Exception $exception){
            return redirect()->route('admin.auth.registration')->withErrors('error',$exception->getMessage());
        }

        return redirect()->route('admin.cabinet');
    }
    public function login(Login $request)
    {
        $credentials = $request->only(['email','password']);
       if( Auth::guard('admin')->attempt($credentials, $request->remember)){
            return redirect()->intended(route('admin.cabinet'));
       }
       return redirect()->back()->withInput($request->only(['email','remember']));
    }
    public function logout()
    {
        \Session::flush();
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
