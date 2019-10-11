<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateShopRequest;
use App\Shop;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class ShopsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:admin|create shop',['create','store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.shop.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserCreateShopRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateShopRequest $request)
    {
        //store all of the valid input to $data
        $data = $request->validated();

        //creating the shop data from request data
        $shop = new Shop();
        $shop->name = $data['shop_name'];
        $shop->url = $data['shop_url'];
        $shop->user_id = auth()->id();

        //save the shop to database 
        $shop->save();

        //Lets enable product plus button for the user if it is disabled
        $userProducts = $request->user()->prices()->pluck('product_id');
        foreach ($userProducts as $value) {
            Cache::put('shop_'.auth()->id()."_".$value, true, -5);
        }

        //check user membership ability
        $shops = $request->user()->shops->count();
        $shops_limit = $request->user()->memberships()->wherePivot('status',1)->get()->sum('shop_limit');

        // If user reach the limit of shop creation then remove the permission
        if($shops >= $shops_limit)
        {
            $permission = Permission::findByName('create shop');
            $request->user()->revokePermissionTo($permission);
        }

        // If user create this shop first time then give product creation permission
        if(!$request->user()->can('create product') && $shops > 0)
        {
            $perm =  Permission::findOrCreate('create product','web');
            $request->user()->givePermissionTo($perm);
        }

        //upload the image of the shop, if has any image on the request
        if($request->hasFile('shop_image'))
        {
            $shop->uploadImage($request->file('shop_image'));
        }

        //redirect the user to shop index page with massage
        return redirect()->route('home.account.shops')->with('successMassage','Your shop was successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        return view('users.shop.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //abort the request if the user is not the owner of this shop and not any admin
        if($shop->userNotOwnerOrAdmin()) return abort(401);

        return view('users.shop.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserCreateShopRequest  $request
     * @param  Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function update(UserCreateShopRequest $request, Shop $shop)
    {
        //abort the request if the user is not the owner of this shop and not any admin
        if($shop->userNotOwnerOrAdmin()) return abort(401);

        //store all of the valid input to $data
        $data = $request->validated();

        //creating the shop data from request data
        $shop->name = $data['shop_name'];
        $shop->url = $data['shop_url'];

        //update the shop to database 
        $shop->save();

        //upload the image of the shop if has any image on the request
        if($request->hasFile('shop_image'))
        {
            $shop->uploadImage($request->file('shop_image'));
        }

        //redirect the user to shop index page with massage
        return redirect()->route('home.account.shops')->with('successMassage','The shop was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //abort the request if the user is not the owner of this shop and not any admin
        if($shop->userNotOwnerOrAdmin()) return abort(401);

        
        //delete all of price first
        if (!blank($shop->prices)){
            foreach ($shop->prices as $price){
                //find the price first
                $thePrice = $shop->prices()->where("id",$price->id)->first();

                //Update the cache
                $thePrice->cacheLeftShop($thePrice->product_id);
                
                //Update product's price
                $thePrice->cachePrice();

                //Let's delete the price
                $thePrice->delete();
            }
        }

        //Delete if there are any images
        if (!empty($shop->image) && file_exists($imageName = public_path().$shop->image->url)) {
            unlink($imageName);
            $shop->image()->delete();
        }

        //Delete the shop now
        $shop->delete();

        //return the response
        return redirect()->route('home.account.shops')->with('successMassage','The shop has been successfully deleted.');
    }
}
