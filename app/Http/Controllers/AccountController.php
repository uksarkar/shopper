<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Variant;
use App\Http\Requests\Account\updateUserRequest;
use App\Http\Requests\Account\changePasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return view('users.index')->with("user",$user);
    }

    /**
     * Show the users shops
     *
     * @return \Illuminate\Http\Response
     */
    public function shops()
    {
        $shops = auth()->user()->shops()->paginate(25);
        return view('users.shops',compact('shops'));
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
     * Update user avatar image
     *
     *@param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfileImage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:2048'
        ]);
        $msg = $validator->messages();
        if ($validator->fails()) {
            return response()->json(["error" => $msg]);
        }

        $e = null;
        $img = null;
        try {
            $user = $request->user();
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $imageName = preg_replace("/ /", "-", $imageName);
                if ($user->image) {
                    if (file_exists($oldImage = public_path() . $user->image->url)) {
                        unlink($oldImage);
                    }
                    $user->image()->update(["url" => $imageName]);
                } else {
                    $user->image()->create(["url" => $imageName]);
                }
                $request->image->move(public_path("images"), $imageName);
                $img = "/images/$imageName";
            } else {
                $e = "No image found!";
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(["error"=>"Something wrong!"]);
        }
        return response()->json(["success" => "Avatar was saved!","image" => $img,"error" => $e]);
    }

    public function updateUserBio(updateUserRequest $request, User $user)
    {
        try {
            if($request->email !== $user->email){
                $user->email_verified_at = null;
                $user->save();
            }
            $user->update($request->validated());
            //code...
            return back()->with("successMassage","Your bio was successfully updated.");
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with("failedMassage","Failed to update your bio.");
        }
    }

    public function changePassword(changePasswordRequest $request, User $user)
    {
        if(Hash::check($request->current_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password)
                ])->save();
            return back()->with("successMassage","Your password was successfully updated.");
        } else {
            return back()->with("failedMassage","You enter wrong password.");
        }
        return back()->with("failedMassage","Failed to change your password.");
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
