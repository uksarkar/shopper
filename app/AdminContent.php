<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminContent extends Model
{
    /**
     * Allowed modifiable column of this table list
     * 
     * @var array
     */
    protected $fillable = ['title','header','content','url'];

    
    /**
     * Making relationship with Products
     * 
     * @return Collection
     */
    public function products(){
        return $this->belongsToMany(Product::class);
    }

    
    /**
     * Making relationship with user
     * will return the owner of the shop
     * 
     * @return Collection
     */

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    
    /**
     * Making relationship with user
     * will return the owner of the shop
     * 
     * @return Collection
     */

    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }



    
    /**
     * End of the model
     * Shopper is developed by 
     * Utpal Sarkar
     * full stack web developer
     * https://github.com/uksarkar
     */
}
