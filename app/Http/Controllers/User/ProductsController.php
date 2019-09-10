<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreatePriceRequest;
use App\Price;
use App\Product;
use App\Shop;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('role_or_permission:admin|create product', ['create','store']);
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
        return view('users.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePriceRequest $request, Shop $shop, Product $product)
    {
        try {

            //hold the valid request data
            $data = $request->validated();

            //find if the request product is valid or get fail
            $product = $product->findOrFail($data['product']); 

            
            $price = new Price;

            //save the product to all of the users available shops
            if($data['shop'] == 0 && !blank($shops = auth()->user()->availableShops($product->id))) {
                foreach ($shops as $shop) {
                    $price->create([
                        'amounts'=>$data['amounts'],
                        'product_id'=>$product->id,
                        'shop_id'=>$shop->id
                    ]);
                }

                $price->cacheLeftShop($product->id);

                $price->product_id = $product->id;
                $price->cachePrice();

                return back()->with('successMassage', 'This product is added to your all shops!');
            }

            //find if the request shop is valid or get fail
            $shop = $shop->findOrFail($data['shop']); 

            // abort the request if the user is not the owner of the shop
            if($shop->userNotOwnerOrAdmin()) return abort(401); 

            $price->amounts = $data['amounts'];
            $price->product_id = $product->id;
            $price->shop_id = $shop->id;

            $price->save();

            $price->cacheLeftShop($product->id);
            $price->cachePrice();

            return back()->with('successMassage', 'Product was successfully added!');

        } catch (\Throwable $th) {
            //throw $th;
            return abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePriceRequest $request, Price $price)
    {
        try {
            //hold the valid request data
            $data = $request->validated();

            //find if the request product is valid or get fail
            Product::findOrFail($data['product']);

            //find if the request shop is valid or get fail
            $shop = Shop::findOrFail($data['shop']); 

            // abort the request if the user is not the owner of the shop
            if($shop->userNotOwnerOrAdmin()) return abort(401); 

            // get the price now
            $price = $price->findOrFail($request->price);
            
            // Let's update the price
            $price->update(["amounts"=>$data["amounts"]]);

            // Calculate lowest price and cache it
            $price->cachePrice();

            //return back with massage
            return back()->with('successMassage', 'Product was successfully updated!');
            
        } catch (\Throwable $th) {
            //throw $th;
            return abort(401, "Unrecognized!");
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
