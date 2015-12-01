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
Route::get('/client', ['as' => 'oauth2.client', 'uses' => 'Unisharp\Oauth2\Controllers\Oauth2Controller@client']);



Route::group(['prefix' => 'oauth2'], function () {
	Route::get('/login', ['as' => 'oauth2.login.get', 'uses' => 'Unisharp\Oauth2\Controllers\Auth\AuthController@index']);
	Route::post('/login', ['as' => 'oauth2.login.post', 'uses' => 'Unisharp\Oauth2\Controllers\Auth\AuthController@authenticate']);
	
	Route::get('/authorize', ['as' => 'oauth2.authorize.get', 'middleware' => ['oauth-auth'], 'uses' => 'Unisharp\Oauth2\Controllers\Oauth2Controller@getAuthorize']);
	Route::post('/authorize', ['as' => 'oauth2.authorize.post', 'middleware' => ['oauth-auth', 'check-authorization-params'], 'uses' => 'Unisharp\Oauth2\Controllers\Oauth2Controller@postAuthorize']);
	Route::post('/access_token', ['as' => 'oauth2.access_token.get', function() {
		return '{"access_token":"GpQgXCwmgb5byJMFeAoKIL6IMqA4ZpPDCESFtXRN","token_type":"Bearer","expires_in":3600,"refresh_token":"tH0MDjlO3K3HjveI5hvSBp2FZBYDog58mxLeoJEl"}';
		//return Response::json(Authorizer::issueAccessToken());
	}]);

	Route::get('/client/create', ['as' => 'oauth2.client.create', 'uses' => 'Unisharp\Oauth2\Controllers\ClientController@create']);
	Route::post('/client/store', ['as' => 'oauth2.client.store', 'uses' => 'Unisharp\Oauth2\Controllers\ClientController@store']);
});
