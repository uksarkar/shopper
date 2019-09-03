<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminContent;
use App\Membership;
use App\User;
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

    /**
     * Membership management
     */
    public function membership()
    {
      $memberships = Membership::all();
      return view('admin.users.membership.index', compact('memberships'));
    }

    /**
     * Membership management
     */
    public function membershipStore(Request $request, Membership $membership)
    {
      $created = $membership->create($request->all());

      if($request->has('image'))
      {
        $created->uploadImage($request->file('image'));
      }

      return back()->with('successMassage','Membership was created!');
    }

    /**
     * Membership management
     */
    public function membershipUpdate(Request $request, Membership $membership)
    {
      $membership->update($request->all());

      if($request->has('image'))
      {
        $membership->uploadImage($request->file('image'));
      }

      return back()->with('successMassage','Membership was updated!');
    }

    /**
     * Membership management
     */
    public function membershipDelete(Membership $membership)
    {

      if(!blank($membership->image))
      {
        $membership->image()->delete();
      }

      $membership->delete();

      return back()->with('successMassage','Membership was deleted!');
    }

    /**
     * Membership management
     */
    public function membershipRequest()
    {
      $memberships = (new User)->memberships()->with('users')->get();

      return view('admin.users.membership.request', compact('memberships'));
    }

    //end of the controller
}
