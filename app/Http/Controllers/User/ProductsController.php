<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreatePriceRequest;
use App\Price;
use App\Product;
use App\Shop;
use App\Variant;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('role_or_permission:admin|create product', ['create', 'store']);
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
    public function store(CreatePriceRequest $request, Shop $shop, Product $product, Variant $variant)
    {
        try {

            //hold the valid request data
            $data = $request->validated();

            //find if the request product is valid or get fail
            $product = $product->findOrFail($data['product']);


            $price = new Price;

            $isSuccess = false;

            //save the product to all of the users available shops
            if ($data['shop'] == 0 && !blank($shops = auth()->user()->availableShops($product->id))) {
                foreach ($shops as $shop) {
                    $newPrice = null;

                    if ($request->has('name') && $request->has('price')) {
                        $newPrice = $price->create([
                            'product_id' => $product->id,
                            'shop_id' => $shop->id,
                            'user_id' => auth()->id()
                        ]);
                        $variant->createNewVariants($request->name, $request->price, $newPrice->id);
                        $isSuccess = true;
                    }
                    if (!blank($request->variants)) {
                        foreach ($request->variants as $key => $item) {
                            if (!blank($item)) {

                                if (!$newPrice) {
                                    $newPrice = $price->create([
                                        'product_id' => $product->id,
                                        'shop_id' => $shop->id,
                                        'user_id' => auth()->id()
                                    ]);
                                    $isSuccess = true;
                                }

                                $newPrice->Variants()->attach([$key => ["amounts" => $item]]);
                            }
                        }
                    }
                }

                $price->cacheLeftShop($product->id);

                $price->product_id = $product->id;
                $price->cachePrice();
                if ($isSuccess) {
                    return back()->with('successMassage', 'This product is added to your all shops!');
                } else {
                    return back()->with('failedMassage', 'Please provide valid price!');
                }
            } else if ($data['shop'] == 0 && blank($shops = auth()->user()->availableShops($product->id))) {
                return abort(401);
            }

            //save the product to one shop__________________________________

            //find if the request shop is valid or get fail
            $shop = $shop->findOrFail($data['shop']);

            // abort the request if the user is not the owner of the shop
            if ($shop->userNotOwnerOrAdmin()) return abort(401);

            $price->product_id = $product->id;
            $price->shop_id = $shop->id;
            $price->user_id = auth()->id();

            if ($request->has('name') && $request->has('price')) {
                $isSuccess = $price->save();
                $variant->createNewVariants($request->name, $request->price, $price->id);
            }
            if (!blank($request->variants)) {
                foreach ($request->variants as $key => $item) {
                    if (!blank($item)) {
                        if (!$isSuccess) {
                            $isSuccess = $price->save();
                        }
                        $price->Variants()->attach([$key => ["amounts" => $item]]);
                    }
                }
            }

            $price->cacheLeftShop($product->id);
            $price->cachePrice();

            if ($isSuccess) {
                return back()->with('successMassage', 'Product was successfully added!');
            } else {
                return back()->with('failedMassage', 'Please provide valid price!');
            }
        } catch (\Throwable $th) {
            throw $th;
            // return abort(403);
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
            if ($shop->userNotOwnerOrAdmin()) return abort(401);

            // get the price now
            $price = $price->findOrFail($request->price);

            // Let's update the price
            $isUpdating = false;
            if (!blank($request->variants)) {
                foreach ($request->variants as $key => $item) {
                    if (!blank($item)) {
                        if(!$isUpdating) {
                            $price->variants()->detach();
                            $isUpdating = true;
                        }
                        $price->Variants()->attach([$key => ["amounts" => $item]]);
                    }
                }
            }

            // Calculate lowest price and cache it
            $price->cachePrice();

            //return back with massage
            return back()->with('successMassage', 'Product was successfully updated!');
        } catch (\Throwable $th) {
            throw $th;
            // return abort(401, "Unrecognized!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price)
    {
        try {

            //Take the product of this price for cache updating
            $product_id = $price->product_id;

            // Detach all variants
            $price->variants()->detach();

            //Let's delete the price
            $price->delete();

            //Update cache now 
            $price->cacheLeftShop($product_id);
            $price->product_id = $product_id;
            $price->cachePrice();

            //Let's send the response to the user
            return back()->with("successMassage", "Product was successfully deleted.");
        } catch (\Throwable $th) {
            // throw $th;
            return abort(501);
        }
    }
}
