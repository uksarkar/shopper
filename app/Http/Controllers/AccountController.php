<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Variant;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the users shops
     *
     * @return \Illuminate\Http\Response
     */
    public function shops()
    {
        return view('users.shops');
    }

    /**
     * Show the users products
     *
     * @return \Illuminate\Http\Response
     */
    public function products()
    {
        $user_id = auth()->id();
        $products = Product::whereHas('prices', function($q) use($user_id){
            $q->where('user_id', $user_id);
        })->with('prices','prices.shop')->paginate(25);
        $variants = Variant::all();
        
        return view('users.products', compact("products","variants"));
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
    public function update(Request $request, $id)
    {
        //
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
