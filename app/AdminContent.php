<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminContent extends Model
{
    protected $fillable = ['title','header','content','url'];
    public function products(){
        return $this->belongsToMany(Product::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }

    //end of the controller
}
