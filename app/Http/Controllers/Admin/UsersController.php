<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return Response
     */
    public function index(User $user)
    {
        $users = $user->with('shops')->with('image')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Role $role
     * @return Response
     */
    public function create()
    {
        $roles = Role::all();
        return view("admin.users.create",['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateUserRequest $request
     * @param User $user
     * @return Response
     */
    public function store(CreateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $User = $user->create($data);
        if($request->hasFile('image'))
        {
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $imageName = preg_replace('/ /','-', $imageName);
            $request->image->move(public_path('images'), $imageName);
            $User->image()->create(["url"=>$imageName]);
        }

        // assign all selected roles for the user
        $User->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('successMassage', 'User has been successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function show(User $user)
    {
        // $products = Product::all();
        return view("admin.users.show", compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view("admin.users.edit", compact("user","roles"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param  User $user
     * @return Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        if($request->hasFile('image')){
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $imageName = preg_replace("/ /", "-", $imageName);
            if($user->image){
                if(file_exists($oldImage = public_path().$user->image->url))
                {
                    unlink($oldImage);
                }
                $user->image()->update(["url"=>$imageName]);
            } else {
                $user->image()->create(["url"=>$imageName]);
            }
            $request->image->move(public_path("images"), $imageName);
        }
        
        // assign all selected roles for the user
        $user->syncRoles($request->input('roles'));

        return redirect()->route("users.show", $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
