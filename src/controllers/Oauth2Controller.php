<?php

namespace Unisharp\Oauth2\Controllers;

use Illuminate\Http\Request;
use Unisharp\Oauth2\Client;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class Oauth2Controller extends Controller
{
    public function test(Request $request)
    {
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'  => '565d228debe1b',
            'clientSecret' => '5a07583aa278e7cfec84337764aedcc8',
            'redirectUri' => 'http://localhost:8000/test',
            'urlAuthorize' => 'http://localhost:9000/oauth2/authorize',
            'urlAccessToken' => 'http://localhost:9000/oauth2/access_token',
            'urlResourceOwnerDetails' => 'http://localhost:9000/oauth2/resource'
        ]);

        // If we don't have an authorization code then get one
        if (!$request->input('code')) {
            $authorizationUrl = $provider->getAuthorizationUrl();

            // Get the state generated for you and store it to the session.
            session(['oauth2state' => $provider->getState()]);

            // Redirect the user to the authorization URL.
            return redirect($authorizationUrl);

        // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($request->input('code')) || ($request->input('state') !== session('oauth2state'))) {

            \Session::forget('oauth2state');
            throw new \Exception('Invalid Exception');

        } else {
            try {

                // Try to get an access token using the authorization code grant.
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $request->input('code')
                    ]);

                // Using the access token, we may look up details about the resource owner.
                $resourceOwner = $provider->getResourceOwner($accessToken);

                // The provider provides a way to get an authenticated API
                $request = $provider->getAuthenticatedRequest(
                    'GET',
                    'http://localhost:9000/api',
                    $accessToken
                    );

            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

                // Failed to get the access token or user details.
                dd($e->getMessage());

            }

        }
    }

    public function getAuthorize(Request $request)
    {
        $user = \Auth::user();
        $params = $request->input();
        $client = Client::find($params['client_id']);

        if (Client::isAuthorized($params['client_id'], $user->id)) {
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
}
