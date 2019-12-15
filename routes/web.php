<?php

Route::get('/', 'HomeController@index')->name('home');
Route::get('admin', 'HomeController@admin')->name('admin');

Auth::routes();

// get products prices celled by axios in vue
Route::get("/getProductPrices", "HomeController@getAllPrices");
// search feck shops
Route::get('/feck-shops{q?}', 'HomeController@searchFeckShops')->where('q', '^[a-zA-Z0-9-_\/]+$');
Route::get('/feck-customers{q?}', 'HomeController@searchFeckUsers')->where('q', '^[a-zA-Z0-9-_\/]+$');
// view shop
Route::get('/shop/{shop}', 'HomeController@viewShop')->name('view-shop');
Route::get('/user/{user}', 'HomeController@viewUser')->name('view-customer');

//Logged Users routes______________________________________
Route::middleware('auth')->resource('review', 'ReviewController')->only('store');

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

      //getting the available shop of the user
      Route::get('/getShops', 'ApiController@returnShop');

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
   Route::post('config/menu', 'ConfigController@saveMenu')->name('config.saveMenu');

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
   Route::resource('photos', 'MediaController')->only('index', 'store', 'destroy');
   Route::get('get-photos', 'MediaController@getPhotos');

   //end of the route group
});
//End admin routes_________________________________________

//Products search route
Route::get('/search{slug?}', 'HomeController@search')->where('slug', '^[a-zA-Z0-9-_\/]+$')->name('search');

//Development only_________________________________________


Route::get('/roles', function () {
   $role = Spatie\Permission\Models\Role::findOrCreate('admin', 'web');
   //$permission = Spatie\Permission\Models\Permission::findOrCreate('create shop');
   // $permission = Spatie\Permission\Models\Permission::findOrCreate('view account');
   // $user = App\User::find(2);
   // $permission = Spatie\Permission\Models\Permission::create(['name'=>'create product']);

   // auth()->user()->revokePermissionTo($permission);
   //auth()->user()->givePermissionTo($permission);
   //$role = Spatie\Permission\Models\Role::find(2);
   // $role->givePermissionTo($permission);
   // $user->removeRole($role);

   auth()->user()->assignRole($role);
});

// End development routes_________________________________

//Find the content category or product, based on url slug
Route::get('{slug?}', 'CategoryController@index')->where('slug', '^[a-zA-Z0-9-_\/]+$')->name('dynamic');

// The end________________________--------------________________
