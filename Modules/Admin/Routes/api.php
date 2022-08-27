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

Route::middleware('auth:api')->get('/admin', function (Request $request) {
    return $request->user();
});

Route::get('/user/{id?}', function(Request $request,$id=1){
    return 'User的ID是'.$id;
});
// Route::prefix('lala')->group(function() {
//     Route::put('/save', 'AdminController@save');
// });
// Route::put('/save', 'AdminController@save');
Route::group(["prefix"=>'lala',"middleware"=>"AdminLala"],function(){
    Route::put('/save', 'AdminController@save');
    Route::delete('/delete', 'AdminController@delete');
});

Route::group(["prefix"=>'lala',"middleware"=>"AdminLala"],function(){
    Route::get('/test/{id?}', 'LalaController@test');
});