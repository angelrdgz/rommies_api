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

/*Route::get('login', 'PassportController@login');*/

Route::prefix('v1')->group(function () {

	Route::post('login', 'PassportController@login');
	Route::post('/register', 'PassportController@register');
	Route::post('/register-roomie', 'PassportController@registerRoomie');
	 
	Route::middleware('auth:api')->group(function () {
	    Route::resource('tasks', 'TaskController');
	    Route::resource('shopping-lists', 'ShoppingListController');
	    Route::resource('shopping-list-items', 'ShoppingListItemController');

	    Route::post('shopping-list-complete', 'ShoppingListController@complete');
	    
	    Route::get('logout', 'PassportController@logout');
	});
 
});


