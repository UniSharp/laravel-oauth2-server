<?php

namespace Unisharp\Oauth2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Client extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_clients';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'secret', 'name'];

    public static function createByInput(array $input)
    {
        $client = array();
        $client["name"] = $input['name'];
        $client["id"] = $input['client_id'];
        $client["secret"] = md5(bcrypt($client["id"]));

        return Client::create($client);
    }

    public static function isAuthorized($client_id, $user_id)
    {
        $session = \DB::table('oauth_sessions')
            ->where('owner_id', $user_id)
            ->where('client_id', $client_id)
            ->first();

        return $session ? true : false;
    }

    public static function getUserByAccessToken($token)
    {
        $user = \DB::table('oauth_sessions')
            ->join('oauth_access_tokens', 'oauth_sessions.id', '=', 'oauth_access_tokens.session_id')
            ->select('oauth_sessions.owner_id')
            ->where('oauth_access_tokens.id', $token)
            ->first();

        if (!$user) {
            return null;
        }

        $model = config('oauth2.user_model');
        $User = new $model();

        return $User->find($user->owner_id);
    }
}
