<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    /**
     * set the fillable column name
     * 
     * @var array
     */
    protected $fillable = ["name","user_id","url"];

    
    /**
     * Making relationship with user
     * will return the owner of the shop
     * 
     * @return Collection
     */
    public function user(){
        return $this->belongsTo("App\User");
    }


    /**
     * Making relationship with reviews
     * 
     * @return Collection
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
    
    /**
     * Making relationship with many prices
     * 
     * @return Collection
     */
    public function prices(){
        return $this->hasMany("App\Price");
    }
    
    /**
     * Making relationship with images
     * 
     * @return Collection
     */
    public function image(){
        return $this->morphOne('App\Image', 'imageable');
    }

    /**
     * Upload the shop image and make relationship with models
     * 
     * @param file $image
     * 
     * @return bool
     */
    public function uploadImage($image){

        //creating the image name like time()+original file name
        $imageName = time().'_'.$image->getClientOriginalName();

        //removing whitespace from image name
        $getData = preg_replace('/ /', '-', $imageName);

        //checking if the shop already has any image, if then remove it and update with new
        //or create new image for the shop
        if (!empty($this->image)) {
            if (file_exists($oldImage = public_path().$this->image->url)){
                unlink($oldImage);
            }
            $this->image()->update(['url'=>$getData]);
        } else {
            $this->image()->create(['url'=>$getData]);
        }

        //now store the to /images dir
        $image->move(public_path('images'),$getData);

        //return a bool 
        return true;
    }

    /**
     * Check if the user is not the owner of the shop or not any admin
     * then return true or false
     * 
     * @return bool
     */

     public function userNotOwnerOrAdmin()
     {
        if(auth()->id() != $this->user_id && !auth()->user()->hasRole('admin')) return true;
        return false;
     }



    
    /**
     * End of the model
     * Shopper is developed by 
     * Utpal Sarkar
     * full stack web developer
     * https://github.com/uksarkar
     */
}
