<?php

namespace App\Http\Controllers\Admin;

use App\Category;
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

    /**
     * Creating deleting and editing category
     */
    public function customizeCategory(Category $category){
        $categories = $category->where('parent_id',0)->with('children')->get();
        return view('admin.configs.category', compact('categories'));
    }
    /**
     * Creating category
     */
    public function createCategory(Request $request, Category $category){
        $data = $request->all();
        $title = isset($request->slug) ? $request->slug:$request->name;
        $data['slug'] = $category->makeSlugFromTitle($title);
        $category->create($data);
        return back()->with('successMassage', 'The category was created!');
    }
    /**
     * edit page for category
     */
    public function editCategory(Category $category){
        $categories = Category::where('parent_id',0)->with('children')->get();
        return view('admin.configs.editCategory', compact('categories', 'category'));
    }
    /**
     * delete category
     */
    public function updateCategory(Category $category, Request $request){
        $data = $request->all();
        $title = isset($request->slug) ? $request->slug:$request->name;
        $data['slug'] = $title == $category->slug ? $title: $category->makeSlugFromTitle($title);
        $category->update($data);
        return redirect()->route('config.category')->with('successMassage', 'The category was updated!');
    }
    /**
     * delete category
     */
    public function deleteCategory(Category $category){
        if($category->children){
            $category->children()->delete();
        }
        $category->delete();
        return back()->with('successMassage', 'The category was deleted, with its sub-category.');
    }
    
    //end of the controller
}
