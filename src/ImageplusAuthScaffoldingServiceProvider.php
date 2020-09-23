<?php

namespace Imageplus\AuthScaffolding;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Imageplus\AuthScaffolding\Http\Middleware\ShareInertiaData;

class ImageplusAuthScaffoldingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/imageplus-auth-scaffolding.php', 'imageplus-auth-scaffolding');

        $this->handleCommands();
        $this->handleRoutes();
        $this->configurePublishing();

        $this->appendMiddleware();
    }

    /**
     *  Handles discovery of packages within laravel
     */
    protected function handleCommands()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\InstallCommand::class,
        ]);
    }

    /**
     * Configure the resources publishable by the package.
     *
     */
    protected function configurePublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/imageplus-auth-scaffolding.php' => config_path('imageplus-auth-scaffolding.php'),
            ], 'imageplus-auth-scaffolding-config');

            $this->publishes([
                __DIR__ . '/../stubs/ImageplusAuthScaffoldingServiceProvider.php' => app_path('Providers/ImageplusAuthScaffoldingServiceProvider.php'),
            ], 'imageplus-auth-scaffolding-provider');
        }
    }

    /**
     * Handle the creation of the routes
     *
     */
    protected function handleRoutes()
    {
        Route::group([
            'namespace' => 'Imageplus\AuthScaffolding\Http\Controllers',
            'prefix' => config('imageplus-auth-scaffolding.prefix'),
            'name' => config('imageplus-auth-scaffolding.name'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
        });
    }

    /**
     * Add the ability to append the shared data for inertia
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function appendMiddleware(){
        $kernel = $this->app->make(Kernel::class);

        $kernel->appendMiddlewareToGroup('web', ShareInertiaData::class);
        $kernel->appendToMiddlewarePriority(ShareInertiaData::class);
    }
}
