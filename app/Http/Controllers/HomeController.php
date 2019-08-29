<?php

namespace App\Http\Controllers;

use App\AdminContent;
use Illuminate\Http\Request;
use App\Menu;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $contents = AdminContent::where('content','<>','recommended_FoR_HoMe')->orderBy('id')->get();
        $items = AdminContent::where('content','recommended_FoR_HoMe')->with('products')->first();

        return view('home', compact('contents','items'));
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

    public function test(Request $request, Menu $menu){
        // $items 	= $menu->orderBy('priority')->get();
        // $output = $menu->getHTML($items);
        $menu->storeMenu($request->all());
     
        return "success";
    }

    //End of the controller
}
