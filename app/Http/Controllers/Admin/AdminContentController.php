<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminContent;
use App\Membership;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

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
      $requests = DB::table('membership_user')
                ->select(
                  'membership_user.id',
                  'memberships.name',
                  'users.name as requester',
                  'memberships.price',
                  'memberships.shop_limit',
                  'membership_user.status',
                  'users.id as user_id',
                  'membership_user.created_at',
                  'membership_user.updated_at')
                ->join('users','users.id', '=', 'membership_user.user_id')
                ->join('memberships', 'memberships.id', '=', 'membership_user.membership_id')
                ->simplePaginate(5);

      return view('admin.users.membership.request', compact('requests'));
    }

    /**
     * Membership management
     */
    public function membershipRequestAction(Request $request)
    {
      try {
        
        DB::table('membership_user')
        ->where('id', $request->id)
        ->update(['status'=>$request->status]);

      } catch (\Throwable $th) {
        throw $th;
        // throw abort(401);
      }

      $msg = "approved.";
      $user = User::find($request->user_id);
      $permission = Permission::findOrCreate('create shop', 'web');

      switch ($request->status) {
        case 0:
          $msg = "pending.";
          break;
        case 1:
          $user->givePermissionTo($permission);
          $msg = "approved.";
          break;
        
        default:
          $user->revokePermissionTo($permission);
          $msg = "rejected.";
          break;
      }
      
      return back()->with('successMassage', 'Membership request was sat to '.$msg);
    }

    //end of the controller
}
