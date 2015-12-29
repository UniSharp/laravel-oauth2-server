Laravel-OAuth2-Server
===================

### What is this package for? ###

* This package is for laravel 5.0/5.1, which may help you build an oauth2 server instantly.
* It's based on https://github.com/lucadegasperi/oauth2-server-laravel
* It implements `Access Token` + `Refresh Token` and a GUI-based client id/secret token generator.

## Setup

1. In `/config/app.php`, add the following to `providers`:
    ```
    Unisharp\Oauth2\Oauth2ServiceProvider::class,
    ```
2. Run `php artisan vendor:publish --force`.
   * Because this package will overwrite the config of lucadegasperi/oauth2-server-laravel (sharring the same config file)
3. In `/config/oath2.php`, here are the default settings
   * `auth_fields`: user authentication fields binding to your users table
   * `grant_types`: here, we implement the most common way in oauth2 (authorization_code + refresh token)

## Usage

* Client CRUD: you can manage your oauth clients info here - `/oauth2/client`
* API protection: just put the middleware `oauth` in the route you'd like to protect
* Routing reference:
    * `/oauth2/login`: a login interface for oauth2
    * `/oauth2/authorize`: for oauth2 process
    * `/oauth2/token`: for oauth2 process
    * `/oauth2/resource`: for oauth2 process
    * `/oauth2/client`: for CRUDing your clients info

> This package hasn't implemented scopes, you need to define your own scopes by yourself.

