<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refreshToken', 'App\Http\Controllers\AuthController@refreshToken');
    Route::get('checkToken', 'App\Http\Controllers\AuthController@checkToken');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'account'
], function ($router) {
    Route::get('users', 'App\Http\Controllers\UserController@index');
    Route::post('register', 'App\Http\Controllers\UserController@register');
    Route::get('users/{id}', 'App\Http\Controllers\UserController@show');
    Route::put('users/{id}', 'App\Http\Controllers\UserController@update');
    Route::delete('users/{id}', 'App\Http\Controllers\UserController@destroy');
    
    Route::post('users/getUserData', 'App\Http\Controllers\UserController@getUserData');

    Route::get('sausers', 'App\Http\Controllers\AdminController@index');
    
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'media'
], function ($router){
    Route::get('sites', 'App\Http\Controllers\SiteController@index');
    Route::post('sites', 'App\Http\Controllers\SiteController@store');
    Route::get('mySites', 'App\Http\Controllers\SiteController@getSitesForCurrentUser');
    Route::post('updateState', 'App\Http\Controllers\SiteController@updateState');
    Route::get('userSites/{id}', 'App\Http\Controllers\SiteController@getSites');
    Route::get('site/{id}', 'App\Http\Controllers\SiteController@show');
    Route::get('id/{url}', 'App\Http\Controllers\SiteController@getIdSite');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
