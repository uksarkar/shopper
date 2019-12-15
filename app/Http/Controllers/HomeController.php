<?php

namespace App\Http\Controllers;

use App\AdminContent;
use App\Category;
use Illuminate\Http\Request;
use App\Menu;
use App\Search;
use App\Variant;
use App\Product;
use App\Shop;
use App\User;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $contents = AdminContent::where('content', '<>', 'recommended_FoR_HoMe')->orderBy('id')->get();
        $items = AdminContent::where('content', 'recommended_FoR_HoMe')->with('products')->first();
        $categories = Category::all();

        return view('home', compact('contents', 'items'));
    }

    /**
     * Show the absolute view for admin
     */
    public function admin()
    {
        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return view('admin.index');
        } elseif (auth()->check() && auth()->user()->can('view admin')) {
            return view('admin.index');
        } elseif (auth()->check()) {
            return redirect('/');
        }
        return view('admin.login');
    }

    public function search(Request $request)
    {
        $request->flash();
        $products = Search::apply($request);
        $variants = Variant::all();

        // return $products;

        return view('search', compact('products', 'variants'));
    }

    public function searchFeckShops(Request $request)
    {
        $request->flash();
        $shops = null;
        if($request->has('q') && !blank($request->q)) {
            $shops = Shop::where("name","RLIKE",$request->q)->paginate(25);
        }

        return view('feck.feckShops', compact('shops'));
    }

    public function searchFeckUsers(Request $request)
    {
        $request->flush();
        $users = null;
        if($request->has('q') && !blank($request->q)){
            $users = User::where("name","RLIKE",$request->q)->paginate(25);
        }
        return view('feck.feckUsers', compact('users'));
    }

    public function viewShop(Shop $shop)
    {
        return view('feck.shop', compact('shop'));
    }

    public function viewUser(User $user)
    {
        return view('feck.user', compact('user'));
    }

    public function getAllPrices(Request $request) {
        if($request->has('product_id')) {
            $product = Product::find($request->product_id);
            return $product->getShops();
        }
    }

    //End of the controller
}
