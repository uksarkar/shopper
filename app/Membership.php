<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{

    protected $fillable = ['name','price', 'shop_limit'];
    
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->as('request')->withPivot('status')->withTimestamps();
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
     * End of the model
     * Shopper is developed by 
     * Utpal Sarkar
     * full stack web developer
     * https://github.com/uksarkar
     */
}
