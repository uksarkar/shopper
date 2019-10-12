<?php

namespace App\Http\Controllers\Admin;

use App\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\CreateShopRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Permission;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $shops = Shop::with('image')->with('user')->latest()->paginate(15);
        return view('admin.shops.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.shops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateShopRequest $request
     * @param Shop $shop
     * @return Response
     */
    public function store(CreateShopRequest $request, Shop $shop)
    {
        $getData = $request->validated();

        $shop->user_id = auth()->id();
        $shop->name = $getData['shop_name'];
        $shop->url = $getData['shop_url'];
        $shop->save();

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '-', $imageName);
            $imageName = preg_replace('/-+/', '-', $imageName);
            $request->image->move(public_path('images'), $imageName);
            $shop->image()->create(['url' => $imageName]);
        }

        return redirect()->route('shops.index')->with('successMassage', 'Shop was successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return Response
     */
    public function show(Shop $shop)
    {
        return view('admin.shops.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return Response
     */
    public function edit(Shop $shop)
    {
        return view('admin.shops.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateShopRequest $request
     * @param \App\Shop $shop
     * @return Response
     */
    public function update(CreateShopRequest $request, Shop $shop)
    {
        $getData = $request->validated();

        $shop->name = $getData['shop_name'];
        $shop->url = $getData['shop_url'];
        $shop->save();

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $getData = preg_replace('/ /', '-', $imageName);

            if (!empty($shop->image)) {
                if (file_exists($oldImage = public_path() . $shop->image->url)) {
                    unlink($oldImage);
                }
                $shop->image()->update(['url' => $getData]);
            } else {
                $shop->image()->create(['url' => $getData]);
            }
            $request->image->move(public_path('images'), $getData);
        }
        return redirect()->route('shops.index')->with('successMassage', 'The shop has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Shop $shop
     * @return Response
     * @throws \Exception
     */
    public function destroy(Shop $shop)
    {
        //delete all of the prices first
        if (!blank($shop->prices)) {
            foreach ($shop->prices as $price) {
                //find the price
                $thePrice = $shop->prices()->find($price->id);

                //Let's delete the price
                $thePrice->delete();

                //Update product's price
                $thePrice->cachePrice();
            }
        }

        //Delete if there are any images
        if (!empty($shop->image) && file_exists($imageName = public_path() . $shop->image->url)) {
            unlink($imageName);
            $shop->image()->delete();
        }

        //find the shops user
        $user  = User::find($shop->user_id);

        //Delete the shop now
        $shop->delete();

        //Let's give the user create shop permission, if have any left
        $shops = $user->shops->count();
        $shops_limit = $user->memberships()->wherePivot('status', 1)->get()->sum('shop_limit');

        // If user reach the limit of shop creation then remove the permission
        if ($shops < $shops_limit) {
            $permission = Permission::findByName('create shop');
            $user->givePermissionTo($permission);
        }

        //return the response
        return redirect()->route('shops.index')->with('successMassage', 'The shop has been successfully deleted.');
    }
}
