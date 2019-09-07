<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Photo;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::latest()->simplePaginate(30);


        return view('admin.photos.index', compact('photos'));
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
        abort_if(!$request->ajax(),401,"Unsupported request type.");

        request()->validate([
            "photo" => "required|image|mimes:jpeg,jpg,png"
        ]);

        $photoName = time()."_".$request->file('photo')->getBasename();
        $photoName = Str::slug($photoName).$request->file('photo')->getClientOriginalExtension();

        if($request->file('photo')->move(public_path("photos"), $photoName)){

            $photo = Photo::create(['path'=>$photoName]);

            return response()->json(["msg"=>"success","photo"=>["id"=>$photo->id,"path"=>$photo->path]]);
        }

        return abort(401, "Something wrong.");
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
     * 
     * Get all photos
     */

     public function getPhotos(){
       $photos = Photo::latest()->simplePaginate(25);

       return $photos;
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
