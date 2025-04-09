<?php

namespace Zest;

use Dannyguevara1\Zest\Core\ClassComposer;
use Dannyguevara1\Zest\Facades\Zest as ZestFacade;

if (!function_exists('Zest\\class_builder')) {
    /**
     * Crea una nueva instancia de ClassComposer.
     *
     * @param string|array|null $styles Clases CSS iniciales
     * @return \Dannyguevara1\Zest\Core\ClassComposer
     */
    function class_builder($styles = null): ClassComposer
    {
        return ZestFacade::classBuilder($styles);
    }
}

if (!function_exists('Zest\\define_preset')) {
    /**
     * Define un preset global para usar en toda la aplicación.
     *
     * @param string $name Nombre del preset
     * @param string|array|callable $classes Las clases CSS o función que aplica las clases
     * @return void
     */
    function define_preset(string $name, $classes): void
    {
        ZestFacade::definePreset($name, $classes);
    }
}

if (!function_exists('Zest\\define_presets')) {
    /**
     * Define múltiples presets globales de una vez.
     *
     * @param array $presets Array asociativo de presets con formato [nombre => classes]
     * @return void
     */
    function define_presets(array $presets): void
    {
        ZestFacade::definePresets($presets);
    }
}

if (!function_exists('Zest\\preset')) {
    /**
     * Crea un builder de clases y aplica un preset global.
     *
     * @param string $name Nombre del preset a aplicar
     * @return \Dannyguevara1\Zest\Core\ClassComposer
     */
    function preset(string $name): ClassComposer
    {
        return ZestFacade::preset($name);
    }
}

if (!function_exists('Zest\\presets')) {
    /**
     * Crea un builder de clases y aplica múltiples presets globales.
     *
     * @param array $presetNames Nombres de los presets a aplicar
     * @return \Dannyguevara1\Zest\Core\ClassComposer
     */
    function presets(array $presetNames): ClassComposer
    {
        return ZestFacade::presets($presetNames);
    }
}
