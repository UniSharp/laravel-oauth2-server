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
        $clients = Client::paginate();

        return view('oauth2::clients.index', compact('clients'));
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
        $input = $request->except('_token');
        $input['client_id'] = md5(uniqid());

        Client::createByInput($input);
        EndPoint::createByInput($input);

        return redirect()->back()->withInput()
            ->with('status', 'Created successfully');
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
        $client = Client::find($id);
        $end_point = EndPoint::getByClientId($id);
        if (!$client || !$end_point) {
            abort(404);
        }

        return view('oauth2::clients.edit', compact('client', 'end_point'));
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
        $client = Client::find($id);
        $end_point = EndPoint::getByClientId($id);
        if (!$client || !$end_point) {
            abort(404);
        }

        $client->name = $request->input('name');
        $client->update();

        $end_point->redirect_uri = $request->input('url');
        $end_point->update();
        
        return redirect()->back()->withInput()
            ->with('status', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        $end_point = EndPoint::getByClientId($id);
        if (!$client || !$end_point) {
            abort(404);
        }

       $client->delete();
       $end_point->delete();

        return redirect()->back()->withInput()
            ->with('status', 'Deleted successfully');
    }
}
