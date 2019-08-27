<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminContent extends Model
{
    
    public function products(){
        return $this->belongsToMany(Product::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    //end of the controller
}
