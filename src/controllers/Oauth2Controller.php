<?php

namespace Unisharp\Oauth2\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Oauth2Controller extends Controller
{
    public function client(Request $request)
    {
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'  => '565d228debe1b',
            'clientSecret' => '5a07583aa278e7cfec84337764aedcc8',
            'redirectUri' => 'http://localhost:8000/client',
            'urlAuthorize' => 'http://localhost:8000/oauth2/authorize',
            'urlAccessToken' => 'http://localhost:8000/access_token',
            'urlResourceOwnerDetails' => 'http://1localhost:8000/oauth2/resource'
        ]);

        // If we don't have an authorization code then get one
        if (!$request->input('code')) {

            // Fetch the authorization URL from the provider; this returns the
            // urlAuthorize option and generates and applies any necessary parameters
            // (e.g. state).
            $authorizationUrl = $provider->getAuthorizationUrl();

            // Get the state generated for you and store it to the session.
            session(['oauth2state' => $provider->getState()]);

            // Redirect the user to the authorization URL.
            return redirect($authorizationUrl);

        // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($request->input('code')) || ($request->input('state') !== session('oauth2state'))) {

            Session::forget('oauth2state');
            dd('Invalid state');

        } else {
            try {

                // Try to get an access token using the authorization code grant.
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $request->input('code')
                    ]);
                // We have an access token, which we may use in authenticated
                // requests against the service provider's API.
                echo $accessToken->getToken() . "\n";
                echo $accessToken->getRefreshToken() . "\n";
                echo $accessToken->getExpires() . "\n";
                echo ($accessToken->hasExpired() ? 'expired' : 'not expired') . "\n";

                /*// Using the access token, we may look up details about the
                // resource owner.
                $resourceOwner = $provider->getResourceOwner($accessToken);

                var_export($resourceOwner->toArray());

                // The provider provides a way to get an authenticated API request for
                // the service, using the access token; it returns an object conforming
                // to Psr\Http\Message\RequestInterface.
                $request = $provider->getAuthenticatedRequest(
                    'GET',
                    'http://brentertainment.com/oauth2/lockdin/resource',
                    $accessToken
                    );*/

            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

                // Failed to get the access token or user details.
                exit($e->getMessage());

            }

        }
    }

    public function getAuthorize(Request $request)
    {
        $user = \Auth::user();
        $params = $request->input();
        
        return \View::make('oauth2::oauth.authorization-form', ['params' => $params, 'user' => $user]);
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
        /*return \Redirect::to($redirectUri
                . '&grant_type=authorization_code'
                . '&client_id=123'
                . '&client_secret=123'
                . '&redirect_uri=' . route('oauth2.access_token.get'));*/
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
