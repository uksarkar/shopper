<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminContent;
use Illuminate\Support\Facades\Cache;

class AdminContentController extends Controller
{
    
    public function index(AdminContent $content)
    {
        $content = $content->where('id',1)->first();
        return $content->products;
    }

    /**
     * storing the product meta data
     */
    public function cacheMeta(Request $request)
    {
      if (!$request->ajax()) return abort(401);

      $expTime = blank($request->all()) ? -5: now()->addMinutes(5);
      Cache::put('tamp_meta_data_'.auth()->id(), $request->all(), $expTime);

      return response()->json('success', 200);
    }

    //end of the controller
}
