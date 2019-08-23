<?php

use Illuminate\Http\Request;

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


Route::post('/menu', function(Illuminate\Http\Request $request, App\Menu $menu){
    $data_ = $request->all();
    $menu->storeMenu($data_);
    return response('Success', 200);
 });

 Route::post('/test', 'HomeController@test');
 Route::get('/test', 'HomeController@test');

//  Route::post('/test', function(Illuminate\Http\Request $request){
//     return $request->all();
//  });
 