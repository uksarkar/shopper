<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Category;

/**
 * App\Product
 *
 * @property-read \App\Image $image
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product query()
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $user_id
 * @property int $shope_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereShopeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUserId($value)
 */
class Product extends Model
{
    protected $fillable = ['name','slug','description','expected_price','category_id','user_id','shope_id'];

    /**
     * Create a product slug.
     *
     * @param  string $title
     * @return string
     */
    public function makeSlugFromTitle($title)
    {
        $slug = Str::slug($title);
        $count = $this->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
    /**
     * Making relationship with user
     * 
     * @return Collection
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    /**
     * Making relationship with one image
     * 
     * @return Collection
     */
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    /**
     *  Making relationship with photos
     * 
     * @return Collection
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }
    
    /**
     * Making relationship with many prices
     * 
     * @return Collection
     */
    public function prices()
    {
        return $this->hasMany("App\Price");
    }
    /**
     * Making relationship with one category
     * 
     * @return Collection
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * Making relationship with many pProductMeta
     * 
     * @return Collection
     */
    public function metas()
    {
        return $this->hasMany(ProductMeta::class);
    }

    /**
     * Getting the lowest price and shops count from cache
     * 
     * @return array
     */
    public function lowestPrice()
    {
        return Cache::get('product_'.$this->id);
    }
    
    /**
     * Check if the user left any shop for add this product
     * 
     * @return bool
     */
    public function hasShop()
    {
        return !Cache::has('shop_'.auth()->id()."_".$this->id);
    }

    /**
     * Creating the full url of product
     * 
     * @return string
     */
    public function slug()
    {
        $category = new Category;
        $category_slug = $category->getRoute($this->category_id);
        return $category_slug.'/'.$this->slug;
    }
    /**
     * Getting the price money sing default is `$`
     * 
     * @return string
     */
    public function monySign()
    {
        $sign = Cache::has('mSign') ? Cache::get('mSign'):"$";
        return $sign;
    }

    /**
     * End of the model
     * Shopper is developed by 
     * Utpal Sarkar
     * full stack web developer
     * https://github.com/uksarkar
     */
}
