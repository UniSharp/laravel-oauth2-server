<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::group(['prefix' => 'oauth2'], function () {
    Route::get('/login', ['as' => 'oauth2.login.get', 'middleware' => ['check-authorization-params'], 'uses' => 'Unisharp\Oauth2\Controllers\Auth\AuthController@index']);
    Route::post('/login', ['as' => 'oauth2.login.post', 'uses' => 'Unisharp\Oauth2\Controllers\Auth\AuthController@authenticate']);

    Route::get('/authorize', ['as' => 'oauth2.authorize.get', 'middleware' => ['oauth-auth', 'check-authorization-params'], 'uses' => 'Unisharp\Oauth2\Controllers\Oauth2Controller@getAuthorize']);
    Route::post('/authorize', ['as' => 'oauth2.authorize.post', 'middleware' => ['oauth-auth', 'check-authorization-params'], 'uses' => 'Unisharp\Oauth2\Controllers\Oauth2Controller@postAuthorize']);
    Route::any('/token', ['as' => 'oauth2.access_token.get', function () {
        return Response::json(Authorizer::issueAccessToken());
    }]);
    Route::any('/resource', ['as' => 'oauth2.resource.get', 'middleware' => ['oauth'], 'uses' => 'Unisharp\Oauth2\Controllers\Oauth2Controller@getResourceOwner']);

    Route::group(['prefix' => 'client', 'middleware' => config('client_middleware')], function () {
        Route::get('/', ['as' => 'oauth2.client.index', 'uses' => 'Unisharp\Oauth2\Controllers\ClientController@index']);
        Route::get('/edit/{id}', ['as' => 'oauth2.client.edit', 'uses' => 'Unisharp\Oauth2\Controllers\ClientController@edit']);
        Route::post('/update/{id}', ['as' => 'oauth2.client.update', 'uses' => 'Unisharp\Oauth2\Controllers\ClientController@update']);
        Route::get('/create', ['as' => 'oauth2.client.create', 'uses' => 'Unisharp\Oauth2\Controllers\ClientController@create']);
        Route::post('/store', ['as' => 'oauth2.client.store', 'uses' => 'Unisharp\Oauth2\Controllers\ClientController@store']);
        Route::get('/delete/{id}', ['as' => 'oauth2.client.delete', 'uses' => 'Unisharp\Oauth2\Controllers\ClientController@destroy']);
    });
});
