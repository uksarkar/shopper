<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{

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
        $theCategory = $category->create($data);
        $category->updateCache();

        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $imageName = preg_replace("/ /", "-", $imageName);
            $request->file('image')->move(public_path('images'), $imageName);
            $theCategory->image()->create(['url'=>$imageName]);
        }

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
        $category->updateCache();
        
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $getData = preg_replace('/ /', '-', $imageName);

            if (!empty($category->image)) {
                if (file_exists($oldImage = public_path().$category->image->url)){
                    unlink($oldImage);
                }
                $category->image()->update(['url'=>$getData]);
            } else {
                $category->image()->create(['url'=>$getData]);
            }

            $request->image->move(public_path('images'),$getData);
        }


        return redirect()->route('config.category')->with('successMassage', 'The category was updated!');
    }
    /**
     * delete category
     */
    public function deleteCategory(Category $category){

        //Deleting all of the children of this category
        if($category->children){
            $category->children()->delete();
        }
        
        //Delete if there are any images
        if (!empty($category->image)) {
            if(file_exists($imageName = public_path().$category->image->url))
            {
                unlink($imageName);
            }
            $category->image()->delete();
        }

        $category->delete();
        $category->updateCache();

        return back()->with('successMassage', 'The category was deleted, with its sub-category.');
    }



    //end of the model
}
