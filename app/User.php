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

    
    /**
     * Making relationship with one image
     * 
     * @return Collection
     */
    public function image(){
        return $this->morphOne('App\Image', 'imageable');
    }

    
    /**
     * Making relationship with many products
     * 
     * @return Collection
     */
    public function products(){
        return $this->hasMany("App\Product");
    }

    
    /**
     * Making relationship with many shops
     * 
     * @return Collection
     */
    public function shops(){
        return $this->hasMany("App\Shop");
    }

    
    /**
     * Making relationship with many prices
     * 
     * @return Collection
     */
    public function prices(){
        return $this->hasManyThrough(Price::class,Shop::class);
    }

    
    /**
     * Making relationship with many memberships
     * 
     * @return Collection
     */
    public function memberships(){
        return $this->belongsToMany(App\Membership::class);
    }

    
    /**
     * Make sure that if user is online now, (5min)
     * 
     * @return bool
     */
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    
    /**
     * Get the users last active time
     * 
     * @return bool
     * or
     * @return string
     */
    public function lastActive()
    {
        return Cache::has('user-active-time-' . $this->id) ? Cache::get('user-active-time-' . $this->id):false;
    }
    
    
    /**
     * only for development
     * 
     * @param App\Product $product
     * 
     * @return bool
     */
    public function hasShops($product){
        $shops = $this->shops()->whereDoesntHave('prices', function ($query) use($product) {
            $query->where('product_id','=', $product->id);
        })->get();
        return $shops;
    }

    
    /**
     * only for development
     * 
     * @param App\Product $product
     * 
     * @return bool
     */
    public function availableShops($id){
        $shops = $this->shops()->whereDoesntHave('prices', function ($query) use($id) {
            $query->where('product_id', $id);
        })->get();
        return $shops;
    }



    
    /**
     * End of the model
     * Shopper is developed by 
     * Utpal Sarkar
     * full stack web developer
     * https://github.com/uksarkar
     */
}
