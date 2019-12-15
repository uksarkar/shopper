<?php

namespace App\Http\Controllers;

use App\Review;
use App\Shop;
use App\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "body" => "required|string",
            "rating" => "required|numeric"
        ]);
        $data["user_id"] = auth()->id();
        try {
            if($request->has('shop') && $data['rating'] > 0 && $data['rating'] <= 5){
                $shop = Shop::find($request->shop);
                $shop->reviews()->create($data);
                return back()->with("successMassage","Successfully stored review.");
            } elseif ($request->has('user') && $data['rating'] > 0 && $data['rating'] <= 5) {
                $user = User::find($request->user);
                $user->reviews()->create($data);
                return back()->with("successMassage","Successfully stored review.");
            }
        } catch (\Throwable $th) {
            throw $th;
            // return back()->with("failedMassage","Something wrong!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
