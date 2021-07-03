<?php

use Illuminate\Http\Request;

Route::group([

    'middleware' =>  ['api', 'cors'],

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('register', 'AuthController@register');
    Route::post('me', 'AuthController@me');
    Route::post('payload', 'AuthController@payload');
});


Route::group(['middleware' => 'api'], function () {
    Route::resource('role', 'RoleController');
});
