<?php

namespace Unisharp\Oauth2;

use Illuminate\Support\ServiceProvider;

/**
 * This is the oauth2 service provider class.
 *
 */
class Oauth2ServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfigs();
        $this->setupFacades();
        $this->setupMigrations();
        $this->setupViews();
        $this->setupRoutes();
    }

    /**
     * Setup the migrations.
     *
     * @return void
     */
    protected function setupMigrations()
    {
        $this->publishes([
            realpath(__DIR__ . '/migrations') => $this->app->databasePath() . '/migrations',
            ]);
    }

    /**
     * Setup the configs.
     *
     * @return void
     */
    protected function setupConfigs()
    {
        $this->publishes([__DIR__ . '/config/oauth2.php' => config_path('oauth2.php', 'config'),], 'oauth2_config');
    }

    /**
     * Setup the views.
     *
     * @return void
     */
    protected function setupViews()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'oauth2');
        $this->publishes([
            __DIR__.'/../public/assets' => public_path('packages/unisharp/oauth2'),
        ], 'public');
    }

    /**
     * Setup the routes.
     *
     * @return void
     */
    protected function setupRoutes()
    {
        include __DIR__ . '/routes.php';
    }

    /**
     * Setup the facades.
     *
     * @return void
     */
    protected function setupFacades()
    {
        \App::bind('oauth2', function()
        {
            return new \Unisharp\Oauth2\Oauth2;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Register the service provider for the dependency.
         */
        $this->app->register('LucaDegasperi\OAuth2Server\Storage\FluentStorageServiceProvider');
        $this->app->register('LucaDegasperi\OAuth2Server\OAuth2ServerServiceProvider');

        /*
         * Create aliases for the dependency.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Authorizer', 'LucaDegasperi\OAuth2Server\Facades\Authorizer');

        /*
         * Register the middleware for the dependency.
         */
        $router = $this->app['router'];
        $router->middleware('oauth-auth', \Unisharp\Oauth2\Middleware\Authenticate::class);
        $router->middleware('oauth', \LucaDegasperi\OAuth2Server\Middleware\OAuthMiddleware::class);
        $router->middleware('oauth-user', \LucaDegasperi\OAuth2Server\Middleware\OAuthUserOwnerMiddleware::class);
        $router->middleware('oauth-client', \LucaDegasperi\OAuth2Server\Middleware\OAuthClientOwnerMiddleware::class);
        $router->middleware('check-authorization-params', \LucaDegasperi\OAuth2Server\Middleware\CheckAuthCodeRequestMiddleware::class);
    }

    /*
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

}