<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','location','phone', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function image(){
        return $this->morphOne('App\Image', 'imageable');
    }
    public function products(){
        return $this->hasMany("App\Product");
    }
    public function shops(){
        return $this->hasMany("App\Shop");
    }
    public function prices(){
        return $this->hasMany("App\Price");
    }
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }
    public function lastActive()
    {
        return Cache::has('user-active-time-' . $this->id) ? Cache::get('user-active-time-' . $this->id):false;
    }
    
    public function hasShops($product){
        $shops = $this->shops()->whereDoesntHave('products', function ($query) use($product) {
            $query->where('product_id','=', $product->id);
        })->get();
        return $shops;
    }



    
    //End of the controller
}
