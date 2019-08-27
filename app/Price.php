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
     * Url: https://github.com/utpalongit
     */
    public function cachePrice($product_id, $delete = false) {
        if($delete){return Cache::put('product_'.$product_id, 1, -5);}
        $price = $this->where('product_id', $product_id)->orderBy('amounts')->pluck('amounts')->first();
        $count = $this->whereAmounts($price)->get()->count();
        return Cache::put('product_'.$product_id, ['price'=>$price,'count'=>$count]);
    }

    //end of the model
}
