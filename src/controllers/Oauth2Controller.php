<?php

namespace Unisharp\Oauth2\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\OAuth2\Server\TokenType\Bearer;
use Unisharp\Oauth2\Client;

class Oauth2Controller extends Controller
{

    public function getAuthorize(Request $request)
    {
        $user = \Auth::user();
        $params = $request->input();
        $client = Client::find($params['client_id']);

        if (Client::isAuthorized($params['client_id'], $user->id) && config('oauth2.skip_authorized') === true) {
            return redirect(\Authorizer::issueAuthCode('user', $user->id, $params));
        }

        return view('oauth2::oauth.authorization-form', compact('params', 'user', 'client'));
    }

    public function postAuthorize()
    {
        $params = \Authorizer::getAuthCodeRequestParams();
        $params['user_id'] = \Auth::user()->id;
        $redirectUri = '';

        if (\Input::get('approve') !== null) {
            $redirectUri = \Authorizer::issueAuthCode('user', $params['user_id'], $params);
        }

        if (\Input::get('deny') !== null) {
            $redirectUri = \Authorizer::authCodeRequestDeniedRedirectUri();
        }

        return redirect($redirectUri);
    }

    public function getResourceOwner(Request $request)
    {
        $Bearer = new Bearer();
        if ($request->input('access_token')) {
            $access_token = $request->input('access_token');
        } else {
            $access_token = $Bearer->determineAccessTokenInHeader($request);
        }

        $user = Client::getUserByAccessToken($access_token);

        return response()->json($user);
    }
}
