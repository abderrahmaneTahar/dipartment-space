<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class AdminLoginController extends Controller
{
   public function __construct()
   {
   	$this->middleware('guest:admin',['except' => ['logout']]);
   }

   public function showLoginForm()
    {
    	return view('auth.admin-login');
    }
    public function Login(Request $request)
  {

     $this->validate($request,[
     	'email'=>'required|email', 
        'password'=>'required|min:6'
      ]);

    if (auth::guard('admin')->attempt(['email'=> $request->email, 'password' => $request->password], $request->remember)) {
    	return redirect()->intended(route('admin.dashboard'));
    }

    return redirect()->back()->withInput($request->only('email','remember'));
  }

  public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('/');
    }
}
