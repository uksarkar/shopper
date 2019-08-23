<?php

namespace App\Http\Controllers\Admin;

use App\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Spatie\Permission\Models\Role;
use App\Menu;

class ConfigController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role_or_permission:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.configs.index');
    }

    /**
     * Site Name Update
     */
    public function siteNameLogoUpdate(Request $request)
    {
        config()->set('site.header.name',$request->site_name);
        config()->set('site.header.logo',$request->url);

        return back()->with('successMassage','Logo and Name is successfully updated.');
    }

    /**
     * Header customization
     */
    public function headerCustomization(Role $role, Menu $menu)
    {
        $item = $menu->orderBy('priority')->get();
        $menu = $menu->getHTML($item);
        $roles = $role->all();
        return view('admin.configs.headerCustomization',compact('roles','menu'));
    }
    
    //end of the controller
}
