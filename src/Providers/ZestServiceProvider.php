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
            // Si la expresión está completamente vacía o solo contiene espacios
            if (empty(trim($expression))) {
                return "<?php throw new \\InvalidArgumentException('La directiva @preset requiere un nombre de preset como argumento'); ?>";
            }
            return "<?php echo \Dannyguevara1\Zest\Facades\Zest::preset($expression); ?>";
        });

        // Directiva @presetIf: aplica un preset global condicionalmente
        Blade::directive($prefix.'If', function ($expression) {
            $parts = explode(',', $expression, 2);

            // Verificar que tenemos dos partes
            if (count($parts) < 2) {
                return "<?php throw new \\InvalidArgumentException('La directiva @presetIf requiere una condición y un nombre de preset'); ?>";
            }

            $condition = trim($parts[0]);
            $preset = trim($parts[1]);

            // Verificar que el nombre del preset no está vacío
            if (empty($preset)) {
                return "<?php if($condition): throw new \\InvalidArgumentException('El nombre de preset en @presetIf no puede estar vacío'); endif; ?>";
            }

            return "<?php if($condition): echo \Dannyguevara1\Zest\Facades\Zest::preset($preset); endif; ?>";
        });
    }
}
