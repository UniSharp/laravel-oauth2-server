<?php

namespace Unisharp\Oauth2;

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
}