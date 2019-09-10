<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class Price
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */

class Price extends Model
{
    protected $fillable = ['shop_id','product_id','user_id','amounts','description'];

    public function product(){
        return $this->belongsTo("App\Product");
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function shop(){
        return $this->belongsTo("App\Shop");
    }
    /**
     * For increasing performance of the application
     * store the most lowest price and shop count with this price
     * on cache
     * Author: Utpal Sarkar
     * Url: https://github.com/uksarkar
     */
    public function cachePrice($delete = false) {
        
        if($delete){return Cache::put('product_'.$this->product_id, 1, -5);}

        $price = $this->where('product_id', $this->product_id)->min('amounts');
        $count = $this->where('product_id', $this->product_id)->whereAmounts($price)->count();
        
        return Cache::put('product_'.$this->product_id, ['price'=>$price,'count'=>$count]);
    }

    /**
     * Cache if user has any shop left for add with this product
     * 
     * @param Product $product_id
     * @return bool
     */
    public function cacheLeftShop($product_id)
    {
        $shops = auth()->user()->availableShops($product_id);

        if(blank($shops))
        {
            Cache::put('shop_'.auth()->id()."_".$product_id, false);
        } else {
            Cache::put('shop_'.auth()->id()."_".$product_id, true, -5);
        }

        return true;
    }

    //end of the model
}
