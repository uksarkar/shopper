<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'HomeController@index')->name('home');
Route::get('admin', 'HomeController@admin')->name('admin');

Auth::routes();

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
   Route::get('config', 'ConfigController@index')->name('config');
   Route::put('config/name', 'ConfigController@siteNameLogoUpdate')->name('config.siteNameLogoUpdate');
   Route::get('config/header', 'ConfigController@headerCustomization')->name('config.headerCustomization');
});
//End admin routes_________________________________________


//Development only_________________________________________

// Route::get('/test', function(App\Menu $menu){
//    $items 	= $menu->orderBy('priority')->get();
//    $output = $menu->getHTML($items);

//    return $menu->outputMenu();
// });








// Route::post('/test', function(App\Category $category){
//    $slug = 'some-category';
//    $posts = Post::whereHas('category', function ($query) use ($slug) {
//       $query->where('slug', $slug)
//          ->orWhereHas('children', function ($query) use ($slug) {
//                $query->where('slug', $slug);
//          });
//    })->with('category.children');

//    return $posts;
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
