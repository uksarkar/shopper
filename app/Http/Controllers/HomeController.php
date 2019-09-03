<?php

namespace App\Http\Controllers;

use App\AdminContent;
use App\Category;
use Illuminate\Http\Request;
use App\Menu;
use App\Search;

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
        $categories = Category::all();

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

    public function search(Request $request){
        $request->flash();
        $products = Search::apply($request);

        // return $products;
        
        return view('search',compact('products'));
    }

    //End of the controller
}
