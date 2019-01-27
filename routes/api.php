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

/*
 * @TODO ADD Auth
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

/* Consumers CRUD routes */
Route::get('consumers', 'ConsumerCrudController@list');
Route::get('consumers/{id}', 'ConsumerCrudController@show');
Route::post('consumers', 'ConsumerCrudController@store');
Route::put('consumers/{id}', 'ConsumerCrudController@update');
Route::delete('consumers/{id}', 'ConsumerCrudController@delete');

