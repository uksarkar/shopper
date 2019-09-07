<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    public function returnShop(Request $request){
       return auth()->user()->availableShops($request->product_id);
    }
    
    /**
     * storing the product meta data
     */
    public function cacheMeta(Request $request)
    {
      if (!$request->ajax()) return abort(401);

      $expTime = blank($request->all()) ? -5:$request->all();
      Cache::put('tamp_meta_data', $request->all(), $expTime);

      return "success!";
    }

}
