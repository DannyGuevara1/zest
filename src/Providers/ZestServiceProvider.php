<?php

namespace Dannyguevara1\Zest\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Dannyguevara1\Zest\ZestManager;

class ZestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('zest', function ($app) {
            return new ZestManager();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publicar configuración
        $this->publishes([
            __DIR__.'/../config/zest.php' => config_path('zest.php'),
        ], 'zest-config');

        // Merge configuración
        $this->mergeConfigFrom(
            __DIR__.'/../config/zest.php', 'zest'
        );

        // Registrar directivas de Blade si están habilitadas
        if (config('zest.directives.enabled', true)) {
            $this->registerBladeDirectives();
        }
    }

    /**
     * Registra directivas Blade genéricas para Zest.
     *
     * @return void
     */
    protected function registerBladeDirectives(): void
    {
        $prefix = config('zest.directives.prefix', 'preset');

        // Directiva @preset: aplica un preset global
        Blade::directive($prefix, function ($expression) {
            return "<?php echo \Dannyguevara1\Zest\Facades\Zest::preset($expression); ?>";
        });

        // Directiva @presetIf: aplica un preset global condicionalmente
        Blade::directive($prefix.'If', function ($expression) {
            $parts = explode(',', $expression, 2);
            $condition = trim($parts[0]);
            $preset = trim($parts[1] ?? 'null');

            return "<?php if($condition): echo \Dannyguevara1\Zest\Facades\Zest::preset($preset); endif; ?>";
        });
    }
}
