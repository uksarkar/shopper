<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     *  set the fillable column name
     * 
     * @var array
     */
    protected $fillable = ['path'];

    /**
     *  The directory for storing photos
     * 
     * @var string
     */
    protected $dir = "/photos/";

    /**
     *  Making the absolute photo path
     * 
     * @param string $path
     * @return string
     */
    public function getPathAttribute($path)
    {
        return $this->dir.$path;
    }

     /**
     * Get all of the posts that are assigned this tag.
     */
    public function photos()
    {
        return $this->morphedByMany(Photo::class, 'photoable');
    }



    
    /**
     * End of the model
     * Shopper is developed by 
     * Utpal Sarkar
     * full stack web developer
     * https://github.com/uksarkar
     */
}
