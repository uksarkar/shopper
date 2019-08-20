<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the absolute view for admin
     */
    public function admin(){
        if(auth()->check() && auth()->user()->hasRole('admin')) {
            return view('admin.index');
        }
        elseif(auth()->check() && auth()->user()->can('view admin')){
            return view('admin.index');
        }
        elseif(auth()->check()) {
            return redirect('/');
        }
        return view('admin.login');
        
    }

    //End of the controller
}
