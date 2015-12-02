<?php

namespace Unisharp\Oauth2;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'secret', 'name'];

    public static function createByInput(Array $input)
    {
        $client = array();
        $client["name"] = $input['name'];
        $client["id"] = $input['client_id'];
        $client["secret"] = md5(bcrypt($client["id"]));

        return Client::create($client);
    }

    public static function isAuthorized($client_id, $user_id)
    {
        $session =  \DB::table('oauth_sessions')
            ->where('owner_id', $user_id)
            ->where('client_id', $client_id)
            ->first();

        return $session ? true : false;
    }
}