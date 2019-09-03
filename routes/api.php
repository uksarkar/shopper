<?php

use App\Menu;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/menu', function(Request $request, Menu $menu){
    $data_ = $request->all();
    $menu->storeMenu($data_);
    
    return response('Success', 200);
 });

 Route::get('/getshop', 'ApiController@returnShop');

 Route::post('cache_meta', 'ApiController@cacheMeta');

//  Route::post('/test', function(Illuminate\Http\Request $request){
//     return $request->all();
//  });
 