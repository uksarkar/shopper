<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Photo;
use Illuminate\Support\Facades\DB;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!$request->ajax(), 401, "Unsupported request type.");

        request()->validate([
            "photo" => "required|image|mimes:jpeg,jpg,png"
        ]);

        $photoName = time() . "_" . $request->file('photo')->getBasename();
        $photoName = Str::slug($photoName) . '.' . $request->file('photo')->getClientOriginalExtension();

        if ($request->file('photo')->move(public_path("photos"), $photoName)) {

            $photo = Photo::create(['path' => $photoName]);

            return response()->json(["msg" => "success", "photo" => ["id" => $photo->id, "path" => $photo->path]]);
        }

        return abort(401, "Something wrong.");
    }

    /**
     * 
     * Get all photos
     */

    public function getPhotos()
    {
        $photos = Photo::latest()->simplePaginate(25);

        return $photos;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Photo $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        if (file_exists(\public_path() . $photo->path)) {
            
            unlink(\public_path() . $photo->path);  //delete the file
            DB::table('photoables')->where('photo_id', $photo->id)->delete(); // delete relationship
            $photo->delete(); // delete photo from database

            return back()->with('successMassage', 'Photo was deleted.');
        } else {
            abort(404);
        }
    }
}
