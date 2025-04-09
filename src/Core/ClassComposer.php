<?php

namespace Dannyguevara1\Zest\Core;

use Illuminate\Support\Arr;
use Stringable;

/**
 * Class ClassComposer
 *
 * Esta clase permite construir y manejar cadenas de clases CSS de manera fluida.
 */
class ClassComposer implements Stringable
{
    /**
     * Clases CSS pendientes de ser procesadas.
     *
     * @var array
     */
    protected array $pending = [];

    /**
     * Almacena los presets definidos globalmente.
     *
     * @var array
     */
    protected static array $presets = [];

    /**
     * Añade clases CSS a la colección.
     *
     * @param string|array $classes Las clases CSS a añadir
     * @return static Retorna la instancia actual para permitir encadenamiento
     */
    public function add($classes): static
    {
        $this->pending[] = Arr::toCssClasses($classes);

        return $this;
    }

    /**
     * Añade clases CSS condicionalmente.
     *
     * @param bool $condition La condición que determina si se añaden las clases
     * @param string|array $classes Las clases CSS a añadir si la condición es verdadera
     * @return static Retorna la instancia actual para permitir encadenamiento
     */
    public function addIf($condition, $classes): static
    {
        if ($condition) {
            $this->add($classes);
        }

        return $this;
    }

    /**
     * Aplica un preset previamente definido.
     *
     * @param string $name Nombre del preset a aplicar
     * @return static Retorna la instancia actual para permitir encadenamiento
     * @throws \InvalidArgumentException Si el preset no existe
     */
    public function preset(string $name): static
    {
        if (isset(static::$presets[$name])) {
            $preset = static::$presets[$name];

            if (is_callable($preset)) {
                $preset($this);
            } else {
                $this->add($preset);
            }

            return $this;
        }

        throw new \InvalidArgumentException("El preset '{$name}' no existe.");
    }

    /**
     * Aplica un preset condicionalmente.
     *
     * @param bool $condition La condición que determina si se aplica el preset
     * @param string $name Nombre del preset a aplicar
     * @return static Retorna la instancia actual para permitir encadenamiento
     */
    public function presetIf(bool $condition, string $name): static
    {
        if ($condition) {
            $this->preset($name);
        }

        return $this;
    }

    /**
     * Define un nuevo preset para usar globalmente.
     *
     * @param string $name Nombre del preset
     * @param string|array|callable $classes Las clases CSS o función que aplica las clases
     * @return void
     */
    public static function definePreset(string $name, $classes): void
    {
        // Aseguramos que si classes es un string o array, se convierte a formato CSS válido
        if (!is_callable($classes)) {
            $classes = Arr::toCssClasses($classes);
        }

        static::$presets[$name] = $classes;
    }

    /**
     * Define múltiples presets a la vez.
     *
     * @param array $presets Array asociativo de presets con formato [nombre => classes]
     * @return void
     */
    public static function definePresets(array $presets): void
    {
        foreach ($presets as $name => $classes) {
            static::definePreset($name, $classes);
        }
    }

    /**
     * Obtiene un preset global existente.
     *
     * @param string $name Nombre del preset
     * @return string|array|callable|null El preset o null si no existe
     */
    public static function getPreset(string $name)
    {
        return static::$presets[$name] ?? null;
    }

    /**
     * Convierte la colección de clases a una cadena.
     *
     * @return string Clases CSS combinadas con espacios
     */
    public function __toString(): string
    {
        return collect($this->pending)->join(' ');
    }
}
