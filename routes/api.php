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

Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group(['middleware' => 'jwt.auth'], function ($router) {

    Route::group(['middleware' => 'isSuperAdmin'], function ($router) {
        Route::get('users', 'UsersController@index');
        Route::get('users/{user}', 'UsersController@show');
        Route::patch('users/{user}/update', 'UsersController@update');
        Route::post('users/new', 'UsersController@store');
        Route::delete('users/{user}', 'UsersController@destroy');
    });

    Route::group(['middleware' => ['restricted_access']], function ($router) {
        Route::get('customers', 'CustomersController@index');
        Route::get('customers/{customer}', 'CustomersController@show');
        Route::patch('customers/{customer}/update', 'CustomersController@update');
        Route::post('customers/new', 'CustomersController@store');
        Route::delete('customers/{customer}', 'CustomersController@destroy');
        
        Route::get('products', 'ProductController@index');
        Route::get('products/{product}', 'ProductController@show');
        Route::patch('products/{product}/update', 'ProductController@update');
        Route::patch('products/{product}/addstock', 'ProductController@addstock');
        Route::post('products/new', 'ProductController@store');
        Route::delete('products/{product}', 'ProductController@destroy');

        Route::get('transactions', 'TransactionController@index');
        Route::post('transactions', 'TransactionController@store');

    });

});
