<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('owner')->group(function() {
    Route::post('/register', 'Owner\AuthController@register');
    Route::post('/login', 'Owner\AuthController@login');

    //Kost controller
    Route::get('/kost/list', 'Owner\KostController@kostlist');
    Route::post('/kost/add', 'Owner\KostController@addkost');
    Route::put('/kost/update/{id}','Owner\KostController@updatekost');
    Route::delete('/kost/delete/{id}','Owner\KostController@deletekost');

});


Route::prefix('user')->group(function() {

    Route::post('/register', 'User\AuthController@register');
    Route::post('/login', 'User\AuthController@login');

    //Search controller
    Route::get('/search', 'User\SearchController@search');
    Route::get('/detail/kost/{slug}', 'User\SearchController@detailkost');

    //Ask controller
    Route::get('/ask/room', 'User\AskRoomController@askroom');
});
