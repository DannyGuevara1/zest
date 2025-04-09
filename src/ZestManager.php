<?php

namespace Dannyguevara1\Zest;

use Dannyguevara1\Zest\Core\ClassComposer;
use Illuminate\Support\Facades\Config;

class ZestManager
{
    /**
     * Constructor de ZestManager.
     */
    public function __construct()
    {
        $this->loadPresetsFromConfig();
    }

    /**
     * Carga los presets definidos en el archivo de configuración.
     *
     * @return void
     */
    protected function loadPresetsFromConfig(): void
    {
        if (Config::get('zest.auto_register', true)) {
            $presets = Config::get('zest.presets', []);

            foreach ($presets as $name => $classes) {
                ClassComposer::definePreset($name, $classes);
            }
        }
    }

    /**
     * Crea una nueva instancia de ClassComposer.
     *
     * @param string|array|null $styles Clases CSS iniciales
     * @return \Dannyguevara1\Zest\Core\ClassComposer
     */
    public function classBuilder($styles = null): ClassComposer
    {
        $builder = new ClassComposer();

        return $styles ? $builder->add($styles) : $builder;
    }

    /**
     * Define un preset global para usar en toda la aplicación.
     *
     * @param string $name Nombre del preset
     * @param string|array|callable $classes Las clases CSS o función que aplica las clases
     * @return void
     */
    public function definePreset(string $name, $classes): void
    {
        ClassComposer::definePreset($name, $classes);
    }

    /**
     * Define múltiples presets globales de una vez.
     *
     * @param array $presets Array asociativo de presets con formato [nombre => classes]
     * @return void
     */
    public function definePresets(array $presets): void
    {
        ClassComposer::definePresets($presets);
    }

    /**
     * Obtiene un preset global existente.
     *
     * @param string $name Nombre del preset
     * @return string|array|callable|null El preset o null si no existe
     */
    public function getPreset(string $name)
    {
        return ClassComposer::getPreset($name);
    }

    /**
     * Crea un builder de clases y aplica un preset global.
     *
     * @param string $name Nombre del preset a aplicar
     * @return \Dannyguevara1\Zest\Core\ClassComposer
     */
    public function preset(string $name): ClassComposer
    {
        return $this->classBuilder()->preset($name);
    }

    /**
     * Crea un builder de clases y aplica múltiples presets globales.
     *
     * @param array $presetNames Nombres de los presets a aplicar
     * @return \Dannyguevara1\Zest\Core\ClassComposer
     */
    public function presets(array $presetNames): ClassComposer
    {
        $builder = $this->classBuilder();

        foreach ($presetNames as $name) {
            $builder->preset($name);
        }

        return $builder;
    }
}
