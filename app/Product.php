<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
    protected $fillable = ['name','slug','description','category_id','user_id','shope_id'];

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
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function image(){
        return $this->morphOne('App\Image', 'imageable');
    }
    public function test_shops(){
        return $this->hasManyThrough(Shop::class, Price::class , 'product_id','id','id','shop_id');
    }
    public function shops(){
        return $this->belongsToMany("App\Shop");
    }
    public function prices(){
        return $this->hasMany("App\Price");
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
