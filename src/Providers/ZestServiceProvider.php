<?php

namespace Dannyguevara1\Zest\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Dannyguevara1\Zest\Facades\Zest;
use Dannyguevara1\Zest\ZestManager;

class ZestServiceProvider extends ServiceProvider
{

    public function register(): void {
        $this->app->singleton('zest', function ($app) {
            return new ZestManager();
        });
        $this->app->alias('zest', ZestManager::class);
    }
}
