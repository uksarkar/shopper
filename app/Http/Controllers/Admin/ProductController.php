<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProductRequest;
use App\Http\Controllers\Controller;
use App\Photo;
use App\ProductMeta;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this ->middleware('role_or_permission:admin|view admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('image')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        $category_output = $category->outputTree();
        return view('admin.products.create', compact('category_output'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request, Product $product)
    {
        $getData = $request->validated();
        $getData['user_id'] = auth()->user()->id;
        $getData['slug'] = $product->makeSlugFromTitle($request->name);
        $product = Product::create($getData);
        if ($request->hasFile('image')) {
            $imageName = time().'_'.$getData['image']->getClientOriginalName();
            $imageName = preg_replace("/ /", "-", $imageName);
            $getData['image']->move(public_path('images'), $imageName);
            $getData['url'] = $imageName;
            $product->image()->create($getData);
        }

        // FIXME: should fix this letter
        // Cache::put('product_'.$product->id, ['price'=>$request->expected_price,'count'=>0]);

        //creating metas data if there is any
        (new ProductMeta)->storeMeta($product->id);
        
        //create if has any photos
        if($request->has('photos') && !blank($request->photos)){
            $photos = explode(",",$request->photos);
            $product->photos()->sync($photos);
        }
        
        return redirect()->route('products.index')->with('successMassage','Product was added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, Category $category)
    {
        $category_output = $category->outputTree($product->category_id);
        return view('admin.products.edit', compact('product','category_output'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(CreateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $getData = preg_replace('/ /', '-', $imageName);

            if (!empty($product->image)) {
                if (file_exists($oldImage = public_path().$product->image->url)){
                    unlink($oldImage);
                }
                $product->image()->update(['url'=>$getData]);
            } else {
                $product->image()->create(['url'=>$getData]);
            }

            $request->image->move(public_path('images'),$getData);
        }
        //Create and update meta data if there is any
        (new ProductMeta)->storeMeta($product->id);

        //create if has any photos
        if($request->has('photos') && !blank($request->photos)){
            $photos = explode(",",$request->photos);
            $product->photos()->sync($photos);
        } else {
            $product->photos()->detach();
        }

        return redirect()->route('products.index')->with('successMassage', 'The product has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        //Delete if there is any image
        if (!blank($product->image)) 
        {
            if(file_exists($imageName = public_path().$product->image->url))
            {
                unlink($imageName);
            }
            $product->image()->delete();
        }

        // Delete all of prices of this product
        if(!blank($product->prices))
        {
            $product->prices()->delete();
        }

        //delete all of the metas of this product
        if(!blank($product->metas))
        {
            $product->metas()->delete();
        }

        //delete all of the photos of the product
        if(!blank($product->photos))
        {
            $product->photos()->detach();
        }

        // Delete the cache price of this product
        Cache::put('product_'.$product->id, 1, -5);

        //Delete the product now
        $product->delete();

        //return the response
        return redirect()->route('products.index')->with('successMassage','The product has been successfully deleted.');
    }
}
