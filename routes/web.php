<?php

use Illuminate\Support\Facades\Cache;

Route::get('/', 'HomeController@index')->name('home');
Route::get('admin', 'HomeController@admin')->name('admin');

Auth::routes();

//Category starting

Route::get('/category', 'CategoryController@index');

//Category End

//Logged Users routes______________________________________
Route::group(['middleware'=>['auth','role_or_permission:admin|view account'],'as'=>'home.'], function() {
   Route::get('/account', 'AccountController@index')->name('account.index');
   Route::get('/account/shops', 'AccountController@shops')->name('account.shops');
   Route::get('/account/products', 'AccountController@products')->name('account.products');
});
//End logged users routes__________________________________

//Only admins routes_______________________________________
Route::prefix('admin')->namespace('Admin')->group( function (){
   Route::resource('products', 'ProductController');
   Route::resource('shops', 'ShopController');
   Route::resource('users', 'UsersController');
   Route::resource('/price', 'PriceController')->only('store','update','destroy');
   Route::get('config', 'ConfigController@index')->name('config');
   Route::put('config/name', 'ConfigController@siteNameLogoUpdate')->name('config.siteNameLogoUpdate');
   Route::get('config/header', 'ConfigController@headerCustomization')->name('config.headerCustomization');
   Route::get('category', 'ConfigController@customizeCategory')->name('config.category');
   Route::post('category', 'ConfigController@createCategory')->name('config.create.category');
   Route::get('category/{category}', 'ConfigController@editCategory')->name('config.edit.category');
   Route::put('category/{category}', 'ConfigController@updateCategory')->name('config.update.category');
   Route::delete('category/{category}', 'ConfigController@deleteCategory')->name('config.delete.category');
});
//End admin routes_________________________________________


//Development only_________________________________________

// Route::get('/test','Admin\AdminContentController@index');

Route::get('/#test', function(App\Product $product){
   
   return "hello";
   
});

Route::view('test2', 'test');

// Route::get('{category}',"CategoryController@index");

// Route::any('{category}/{slug}', 'CategoryController@index')
// ->where('slug','^[a-zA-Z0-9-_\/]+$');

// Route::get('put', function(App\Category $category){
//    $categories = $category->all();

//    return $categories;
//    // Cache::put('categories', $categories);
//    // Cache::forget('categories');
//    // foreach ($categories as $key => $item) {
//    //    Cache::put('category_'.$item->id, $item, -1);
//    // }
// });

//Find the content category or product, based on url slug
Route::get('{slug?}', 'CategoryController@index')->where('slug', '^[a-zA-Z0-9-_\/]+$');

// Route::get('get', function(){
//    return Cache::get('category_5');
// });

// Route::get('/roles', function (){
//    $role = Spatie\Permission\Models\Role::create(['name'=>'admin']);
//    $permission = Spatie\Permission\Models\Permission::create(['name'=>'edit product']);

//    $role->givePermissionTo($permission);

//    auth()->user()->assignRole($role);

// });
/*
 * package
 */
