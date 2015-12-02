<?php

namespace Unisharp\Oauth2;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class EndPoint extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_client_endpoints';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['client_id', 'redirect_uri'];

    public static function createByInput(Array $input)
    {
        $end_point = array();
        $end_point["client_id"] = $input['client_id'];
        $end_point["redirect_uri"] = $input['url'];

        return EndPoint::create($end_point);
    }

    public static function getByClientId($id)
    {
        return EndPoint::where('client_id', $id)->first();
    }
}