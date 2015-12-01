<?php

namespace Unisharp\Oauth2\Controllers;

use Illuminate\Http\Request;

use Unisharp\Oauth2\Client;
use Unisharp\Oauth2\EndPoint;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{

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
        return view('oauth2::clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = array();
        $client["name"] = $request->input('name');
        $client["id"] = uniqid();
        $client["secret"] = md5(uniqid());
        Client::create($client);

        $end_point = array();
        $end_point["client_id"] = $client["id"];
        $end_point["redirect_uri"] = $request->input('url');
        EndPoint::create($end_point);

        return redirect()->back()->withInput()->withError('A client has been created successfully');
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
