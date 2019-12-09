<?php

namespace UniBen\CMS;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\View\View;
use UniBen\CMS\Models\Editable;

class ServiceProvider extends BaseServiceProvider
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
        $this->loadRoutesFrom(__DIR__.'/web.php');
    }
}
