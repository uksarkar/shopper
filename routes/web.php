<?php

use App\Product;
use App\ProductSearch\ProductSearch;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

Route::get('/', 'HomeController@index')->name('home');
Route::get('admin', 'HomeController@admin')->name('admin');

Auth::routes();

//Logged Users routes______________________________________
Route::group(
   [
      'middleware' => ['auth', 'role_or_permission:admin|view account'],
      'prefix' => 'account',
      'as' => 'home.'
   ],
   function () {
      Route::get('/', 'AccountController@index')->name('account.index');
      Route::get('shops', 'AccountController@shops')->name('account.shops');
      Route::get('products', 'AccountController@products')->name('account.products');

      //all the controller from User folder
      Route::namespace('User')->group(function () {

         //managing user's shops
         Route::resource('shops', 'ShopsController')->except('index');

         //managing user's products
         Route::post("products", "ProductsController@store")->name("products.store");
         Route::patch("products", "ProductsController@update")->name("products.update");
         Route::delete("products/{price}", "ProductsController@destroy")->name("products.destroy");

         //managing memberships
         Route::resource('memberships', 'MembershipController')->only('index', 'store');
      });
   }
);
//End logged users routes__________________________________

//Only admins routes_______________________________________
Route::prefix('admin')->middleware('auth', 'role_or_permission:admin|view admin')->namespace('Admin')->group(function () {
   Route::resource('products', 'ProductController');
   Route::resource('shops', 'ShopController');
   Route::resource('users', 'UsersController');
   Route::resource('price', 'PriceController')->only('store', 'update', 'destroy');

   Route::get('config', 'ConfigController@index')->name('config');
   Route::post('config/name', 'ConfigController@siteNameLogoUpdate')->name('config.siteNameLogoUpdate');
   Route::get('config/home', 'ConfigController@homeCustomization')->name('config.homeCustomization');
   Route::post('config/home/content', 'ConfigController@createContent')->name('config.createContent');
   Route::put('config/home/content/{content}', 'ConfigController@updateContent')->name('config.updateContent');
   Route::delete('config/home/content/{content}', 'ConfigController@deleteContent')->name('config.deleteContent');
   Route::post('config/home/content/category', 'ConfigController@addCategory')->name('config.addCategory');
   Route::delete('config/home/content/category/{content}', 'ConfigController@removeCategory')->name('config.removeCategory');
   Route::post('config/home/content/product', 'ConfigController@addProduct')->name('config.addProduct');
   Route::delete('config/home/content/product/{content}', 'ConfigController@removeProduct')->name('config.removeProduct');

   Route::get('category', 'CategoryController@customizeCategory')->name('config.category');
   Route::post('category', 'CategoryController@createCategory')->name('config.create.category');
   Route::get('category/{category}', 'CategoryController@editCategory')->name('config.edit.category');
   Route::put('category/{category}', 'CategoryController@updateCategory')->name('config.update.category');
   Route::delete('category/{category}', 'CategoryController@deleteCategory')->name('config.delete.category');

   //Storing meta data on cache
   Route::post('cache_meta', 'AdminContentController@cacheMeta')->name('admin.cache_meta');

   //Managing memberships
   Route::get('memberships', 'AdminContentController@membership')->name('admin.membership');
   Route::patch('memberships/{membership}', 'AdminContentController@membershipUpdate')->name('admin.membership.update');
   Route::post('memberships', 'AdminContentController@membershipStore')->name('admin.membership.store');
   Route::delete('memberships/{membership}', 'AdminContentController@membershipDelete')->name('admin.membership.delete');

   //managing membership request
   Route::get('membership/request', 'AdminContentController@membershipRequest')->name('admin.membership.request');
   Route::post('membership/request', 'AdminContentController@membershipRequestAction')->name('admin.membership.membershipRequestAction');

   // Product photos managing
   Route::resource('photos', 'MediaController')->only('index', 'store');
   Route::get('get-photos', 'MediaController@getPhotos');

   //end of the route group
});
//End admin routes_________________________________________

//Products search route
Route::get('/search{slug?}', 'HomeController@search')->where('slug', '^[a-zA-Z0-9-_\/]+$')->name('search');

//Development only_________________________________________

//getting the available shop of the user
Route::get('/getshop', 'ApiController@returnShop');



// Route::get('/test3', '');

Route::get('/test3', function (Request $request) {
   $p = Product::whereHas('prices', function($q) use($request){
      $q->where('user_id', $request->user()->id);
  })->with('prices','prices.shop');
   dd($p->toSql());
});





Route::get('/test2', function () {
   // $shops = auth()->user()->shops->count();
   // $memberships_count = auth()->user()->memberships()->wherePivot('status',1)->get()->sum('shop_limit');

   // dd($memberships_count);

   // return "Total shops: ".$shops." Total limit: ".$memberships_count;
   // Cache::putMany(['test'=>'testing','rr'=>"ee"]);
   // Cache::put('mSign', '$');
   // return Cache::get('mSign');

   $permission = Permission::findByName('create shop');
   auth()->user()->givePermissionTo($permission);
});
Route::view('/test', 'test');

Route::get('/test/{id}', function ($id) {
   return auth()->user()->availableShops($id);
});



// Route::get('{category}',"CategoryController@index");

Route::get('/roles', function () {
   $role = Spatie\Permission\Models\Role::findOrCreate('member', 'web');
   //$permission = Spatie\Permission\Models\Permission::findOrCreate('create shop');
   $permission = Spatie\Permission\Models\Permission::findOrCreate('view account');
   // $user = App\User::find(2);
   // $permission = Spatie\Permission\Models\Permission::create(['name'=>'create product']);

   // auth()->user()->revokePermissionTo($permission);
   //auth()->user()->givePermissionTo($permission);
   //$role = Spatie\Permission\Models\Role::find(2);
   // $role->givePermissionTo($permission);
   // $user->removeRole($role);

   // auth()->user()->assignRole($role);

});

//Find the content category or product, based on url slug
Route::get('{slug?}', 'CategoryController@index')->where('slug', '^[a-zA-Z0-9-_\/]+$')->name('dynamic');

// Route::get('get', function(){
//    return Cache::get('category_5');
// });

/*
 * package
 */
