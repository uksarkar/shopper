<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public function metas(){
        return $this->hasMany('App\Meta_Text');
    }
}
