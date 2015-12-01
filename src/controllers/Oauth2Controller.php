<?php

namespace Unisharp\Oauth2\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Oauth2Controller extends Controller
{
    public function getAuthorize()
    {
        $user = \Auth::user();
        $params['client_id'] = 123;//\App\Client::getClientId();
        $params['redirect_uri'] = 'http://localhost:8000';
        $params['response_type'] = 'code';
        $params['state'] = 1;

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
        return \Redirect::to($redirectUri
                . '&grant_type=authorization_code'
                . '&client_id=123'
                . '&client_secret=123'
                . '&redirect_uri=' . route('oauth2.access_token.get'));
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
