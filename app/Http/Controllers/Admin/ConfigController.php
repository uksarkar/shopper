<?php

namespace App\Http\Controllers\Admin;

use App\AdminContent;
use App\Category;
use App\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Spatie\Permission\Models\Role;
use App\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        
        Cache::putMany([
            "site_name"=> $request->site_name,
            "site_logo"=> $request->url,
            "favicon"=> $request->favicon
        ]);

        Cache::put("mSign", $request->money);

        return back()->with('successMassage','Data was successfully updated.');
    }

    /**
     * Header customization
     */
    public function homeCustomization(AdminContent $content, Menu $menu)
    {
        $item = $menu->orderBy('priority')->get();
        $menu = $menu->getHTML($item);
        $contents = $content->where('content','<>','recommended_FoR_HoMe')->with('categories')->get();
        $categories = Category::where('parent_id',0)->with('children')->get();
        $hasContentQuery = DB::select("SELECT 
                                            c.id,
                                            ac.admin_content_id as key_id
                                        FROM categories c
                                        LEFT JOIN admin_content_category ac
                                            ON c.id = ac.category_id");
        $hasContent = [];
        foreach ($hasContentQuery as $item) {
            $hasContent[$item->id] = $item->key_id;
        }

        //this content is required for adding products in the bottom of home page
        $recommendedContent = $content->where('content', 'recommended_FoR_HoMe')->with('products')->first();
        if(blank($recommendedContent)){
            $content->create([
                'content' => 'recommended_FoR_HoMe',
                'title'=>'null',
                'header'=>'Recommended Items',
                'url'=>'not need'
            ]);
            $recommendedContent = $content->where('content', 'recommended_FoR_HoMe')->with('products')->first();
        }
        //end recommended

        return view('admin.configs.homeCustomization', compact('contents','menu','categories','hasContent','recommendedContent'));
    }
    /**
     * Create new content
     */
    public function createContent(Request $request, AdminContent $content){
        $theContent = $content->create($request->all());

        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $imageName = preg_replace("/ /", "-", $imageName);
            $request->file('image')->move(public_path('images'), $imageName);
            $theContent->image()->create(['url'=>$imageName]);
        }

        return back()->with('successMassage','Content was added!');
    }
    /**
     * Updating content
     */
    public function updateContent(Request $request, AdminContent $content){
        $content->update($request->all());

        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $getData = preg_replace('/ /', '-', $imageName);

            if (!empty($content->image)) {
                if (file_exists($oldImage = public_path().$content->image->url)){
                    unlink($oldImage);
                }
                $content->image()->update(['url'=>$getData]);
            } else {
                $content->image()->create(['url'=>$getData]);
            }

            $request->image->move(public_path('images'),$getData);
        }

        return back()->with('successMassage','Content was updated!');
    }
    /**
     * Delete content
     */
    public function deleteContent(AdminContent $content){
        
        //Delete if there are any images
        if (!empty($content->image)) {
            if(file_exists($imageName = public_path().$content->image->url)){
                unlink($imageName);
            }
            $content->image()->delete();
        }

        //Delete if there any categories
        if(!empty($content->categories)){
            $content->categories()->detach();
        }

        $content->delete();

        return back()->with('successMassage', 'Content was deleted!');
    }

    /**
     * Adding the category with content
     */

     public function addCategory(Request $request){
        $data = $request->all();
        $content = AdminContent::where('id',$data['content_id'])->first();
        $store = explode(',',$data['content_ids']);
        $content->categories()->syncWithoutDetaching($store);
        return back()->with('successMassage', 'Categories ware added!');
     }
     /**
      * Removing the category from content
      */
      public function removeCategory(Request $request,AdminContent $content){
        $content->categories()->detach($request->category_id);
        return back()->with('successMassage', 'Category was removed!');
      }

    /**
     * Adding the product with content
     */

     public function addProduct(Request $request){

        $data = $request->all();
        $content = AdminContent::where('id',$data['recommended_content_id'])->first();
        $store = explode(',',$data['product_ids']);
        $content->products()->syncWithoutDetaching($store);

        return back()->with('successMassage', 'Products ware added!');
     }

     /**
      * Removing the product from content
      */
      public function removeProduct(Request $request,AdminContent $content){

        $content->products()->detach($request->product_id);

        return back()->with('successMassage', 'Products was removed!');
      }

      /**
       * Saving menu to database
       */
      public function saveMenu(Request $request, Menu $menu){
        $data_ = $request->all();
        $menu->storeMenu($data_);
        
        return response('Success', 200);
      }

    
    //end of the controller
}
