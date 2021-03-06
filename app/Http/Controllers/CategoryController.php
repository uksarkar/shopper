<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Variant;

class CategoryController extends Controller
{
    //Creating index

    public function index($slug)
    {
        $categoryClass = new Category;
        $category = $categoryClass->findCategoryBySlug($slug);
        $variants = Variant::all();

        if ($category) {
            $products = $category->products()->paginate(25);
            return view('category', compact('category', 'variants', 'products'));
        } else {
            $product = $categoryClass->findProductBySlug($slug);

            //send 404 page if product is not available
            if (!$product) {
                return abort(404);
            }

            //getting the similar type of products
            $price = blank($product->price) ? 0 : $product->price;

            $similar_products = Product::where('id', '<>', $product->id)->where('category_id', $product->category_id)
                ->orWhereHas('prices', function ($q) use ($price, $product) {
                    $q->Where('name', 'RLIKE', $product->name)
                        ->where('product_id', '<>', $product->id);
                })
                ->orWhere('id', '<>', $product->id)
                ->limit(10)
                ->get();

            $prices = $product->prices()->with("variants")->paginate(25);

            //return the view
            return view('product', compact('product', 'similar_products', 'prices'));
        }
        return abort(404);
    }




    //End Category Controller
}
