<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Imageplus\AuthScaffolding\ImageplusAuthScaffolding;

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
        ImageplusAuthScaffolding::useDefaultViews();
    }
}
