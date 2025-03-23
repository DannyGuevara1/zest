<?php

namespace Dannyguevara1\Zest\Providers;

use Illuminate\Support\ServiceProvider;
use Dannyguevara1\Zest\Facades\Zest;
use Dannyguevara1\Zest\ZestManager;

class ZestServiceProvider extends ServiceProvider
{

    public function register(): void {

        $this->app->alias(ZestManager::class, "zest");
        $this->app->singleton(ZestManager::class);
        $louder = \Illuminate\Foundation\AliasLoader::getInstance();
        $louder->alias("Zest", Zest::class);
    }
}
