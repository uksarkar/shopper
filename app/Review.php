<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ["body","rating","user_id"];

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userImage()
    {
        if($image = $this->user->image) {
            return $image->url;
        }
        return "https://via.placeholder.com/100x100.png?text=avatar";
    }
}
