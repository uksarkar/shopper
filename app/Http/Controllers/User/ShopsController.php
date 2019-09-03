<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateShopRequest;
use App\Shop;
use Illuminate\Support\Str;

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
        $shop->location = $data['shop_location'];
        $shop->description = $data['shop_description'];
        $shop->user_id = auth()->id();

        //save the shop to database 
        $shop->save();

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
        $shop->location = $data['shop_location'];
        $shop->description = $data['shop_description'];

        //update the shop to database 
        $shop->save();

        //upload the image of the shop if has any image on the request
        if($request->hasFile('shop_image'))
        {
            $shop->uploadImage($request->file('shop_image'));
        }

        //redirect the user to shop index page with massage
        return redirect()->route('home.account.shops')->with('successMassage','Your shop was successfully updated.');
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
    }
}
