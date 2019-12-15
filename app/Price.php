<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Class Price
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */

class Price extends Model
{
    protected $fillable = ['shop_id', 'product_id', 'user_id'];

    public function product()
    {
        return $this->belongsTo("App\Product");
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function shop()
    {
        return $this->belongsTo("App\Shop");
    }

    /**
     * Making relationship with many prices
     * 
     * @return Collection
     */
    public function variants()
    {
        return $this->morphToMany(Variant::class, "variantable")->withPivot('amounts');
    }

    /**
     * Get all variants for editing
     */
    public function getAvailableVariants(){
        $variants = $this->variants;
        $allVariants = Variant::all();
        $result = [];
        foreach($allVariants as $variant) {
            $price = '';
            foreach($variants as $varia){
                if($varia->id == $variant->id){
                    $price = $varia->pivot->amounts;
                }
            }
            $createdVariant = [
                "variant_name"=>$variant->variant_name,
                "id"=> $variant->id,
                "price" => $price
            ];
            array_push($result, $createdVariant);
        }
        return json_encode($result);
    }
    /**
     * For increasing performance of the application
     * store the most lowest price and shop count with this price
     * on cache
     * Author: Utpal Sarkar
     * Url: https://github.com/uksarkar
     */
    public function cachePrice($delete = false)
    {
        if ($delete) {
            // return Cache::put('product_' . $variant->variant_name . "_" . $this->product_id, 1, -5);
        }

        $variants = Variant::all();
        foreach ($variants as $variant) {
            $price = DB::table('variantables')
                ->where('variantable_id', $this->id)
                ->where('variant_id', $variant->id)
                ->min('amounts');
            if (!blank($price)) {
                $count = DB::table('variantables')
                    ->where('variantable_id', $this->id)
                    ->where('variant_id', $variant->id)
                    ->whereAmounts($price)
                    ->count();

                Cache::put('product_' . $variant->variant_name . "_" . $this->product_id, ['price' => $price, 'variant' => $variant->variant_name, 'count' => $count]);
            }
        }

        // $price = $this->where('product_id', $this->product_id)->min('amounts');
        // $count = $this->where('product_id', $this->product_id)->whereAmounts($price)->count();

        // return Cache::put('product_' . $this->product_id, ['price' => $price, 'count' => $count]);
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

        if (blank($shops)) {
            Cache::put('shop_' . auth()->id() . "_" . $product_id, false);
        } else {
            Cache::put('shop_' . auth()->id() . "_" . $product_id, true, -5);
        }

        return true;
    }

    //end of the model
}
