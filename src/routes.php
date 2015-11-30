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
	Route::get('/authorize', ['as' => 'oauth2.authorize.get', 'middleware' => ['auth'], 'uses' => 'OauthController@getAuthorize']);
	Route::post('/authorize', ['as' => 'oauth2.authorize.post', 'middleware' => ['auth', 'check-authorization-params'], 'uses' => 'Oauth2Controller@postAuthorize']);
	Route::get('/access_token', ['as' => 'oauth2.access_token.get', function() {
		return Response::json(Authorizer::issueAccessToken());
	}]);
});
