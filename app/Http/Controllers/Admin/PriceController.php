<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreatePriceRequest;
use App\Http\Requests\PriceUpdateRequest;
use App\Price;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePriceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePriceRequest $request)
    {
        $data = $request->validated();
        $data['shop_id'] = $request->shop;
        $data['user_id'] = auth()->user()->id;
        $data['product_id'] = $request->product;
        
        $price = Price::create($data);

        $price->cachePrice();

        return back()->with('successMassage','Product was successfully added.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(PriceUpdateRequest $request, Price $price)
    {
        $data = $request->all();
        $data['old'] = $price->amounts;
        
        $price->update($data);

        $price->cachePrice();

        return back()->with('successMessage','Price was updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price)
    {
        $price->cachePrice(true);
        $price->delete();

        return back()->with('successMessage','Product was removed.');
    }
}
