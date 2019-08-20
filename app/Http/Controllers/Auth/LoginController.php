<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    
    /**
     * The user has been authenticated.
     *
     * @param  mixed  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated($request, $user)
    {
        $url = str_ireplace(url('/'), '', url()->previous());
        if($url == '/admin' && $user->hasRole('admin'))
        {
            return redirect()->route('admin');
        }
        elseif($url == '/admin' && $user->can('view admin'))
        {
            return redirect()->route('admin');
        }
        return redirect($this->redirectTo);
    }

    //End of this controller
}
