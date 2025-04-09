# Zest - Gestor de Clases CSS para Laravel

Zest es una herramienta minimalista para gestionar clases CSS en aplicaciones Laravel. Permite crear, organizar y reutilizar clases CSS mediante un sistema de presets, facilitando el mantenimiento y la consistencia del código.

## Características

- **Sistema de presets**: Define conjuntos reutilizables de clases CSS
- **API fluida**: Utiliza una interfaz de encadenamiento de métodos para construir clases
- **Directivas Blade**: Integración con Blade mediante directivas `@preset` y `@presetIf`
- **Sin opiniones de estilo**: Zest no impone ningún framework CSS o sistema de diseño
- **Liviano y enfocado**: Hace una cosa y la hace bien - gestionar clases CSS

## Instalación

```bash
composer require dannyguevara1/zest
```

Opcionalmente, publica el archivo de configuración:

```bash
php artisan vendor:publish --tag=zest-config
```

## Uso básico

### Definiendo presets

Define presets globales en el archivo de configuración o mediante código:

```php
// En config/zest.php
'presets' => [
    'btn' => 'inline-flex items-center justify-center font-medium rounded',
    'btn-primary' => 'bg-blue-600 text-white hover:bg-blue-700',
    'card' => 'bg-white rounded-lg shadow overflow-hidden',
],

// O mediante código
use Dannyguevara1\Zest\Facades\Zest;

Zest::definePreset('btn', 'inline-flex items-center justify-center font-medium rounded');
Zest::definePresets([
    'btn-primary' => 'bg-blue-600 text-white hover:bg-blue-700',
    'card' => 'bg-white rounded-lg shadow overflow-hidden',
]);
```

### Usando presets en vistas Blade

```blade
<button class="{{ Zest::preset('btn')->preset('btn-primary') }}">
    Enviar formulario
</button>
```

### Usando la API fluida para combinar clases

```blade
<div class="{{ Zest::classBuilder()
    ->add('flex items-center')
    ->preset('card')
    ->addIf($hasError, 'border-red-500')
    ->addIf($isActive, 'border-green-500') }}">
    Contenido
</div>
```

### Usando las directivas de Blade

```blade
<button class="@preset('btn') @presetIf($isPrimary, 'btn-primary')">
    Botón
</button>
```

## Organizando tus presets

Recomendamos organizar tus presets con prefijos claros según el tipo de componente:

```php
// Botones
'btn' => 'base-styles...',
'btn-primary' => 'variant-styles...',
'btn-sm' => 'size-styles...',

// Tarjetas
'card' => 'base-styles...',
'card-header' => 'part-styles...',
'card-body' => 'part-styles...',
```

## Integrando con tus componentes Blade

Zest es una herramienta excelente para usar en componentes Blade personalizados:

```blade
<!-- resources/views/components/button.blade.php -->
@props(['variant' => 'default', 'size' => 'md'])

<button {{ $attributes->class([
    Zest::preset('btn'),
    Zest::preset('btn-'.$variant),
    Zest::preset('btn-size-'.$size)
]) }}>
    {{ $slot }}
</button>
```

## API

### Facade Zest

- `Zest::classBuilder($initialClasses = null)`: Crea una nueva instancia de ClassComposer
- `Zest::definePreset($name, $classes)`: Define un preset global
- `Zest::definePresets($presetsArray)`: Define múltiples presets globales
- `Zest::getPreset($name)`: Obtiene un preset por su nombre
- `Zest::preset($name)`: Crea un ClassComposer y aplica un preset

### Clase ClassComposer

- `add($classes)`: Añade clases CSS
- `addIf($condition, $classes)`: Añade clases CSS condicionalmente
- `preset($name)`: Aplica un preset
- `presetIf($condition, $name)`: Aplica un preset condicionalmente

## Ejemplos avanzados

### Componente de botón

```php
// AppServiceProvider.php
public function boot()
{
    Zest::definePresets([
        'btn' => 'inline-flex items-center justify-center font-medium transition-colors rounded-md',
        'btn-primary' => 'bg-blue-600 text-white hover:bg-blue-700',
        'btn-secondary' => 'bg-gray-200 text-gray-800 hover:bg-gray-300',
        'btn-sm' => 'text-sm px-3 py-1.5',
        'btn-md' => 'px-4 py-2',
        'btn-lg' => 'text-lg px-5 py-3',
    ]);
}
```

```blade
<!-- button.blade.php -->
@props(['variant' => 'primary', 'size' => 'md'])

<button {{ $attributes->class([
    '@preset("btn")',
    '@preset("btn-'.$variant.'")',
    '@preset("btn-'.$size.'")',
]) }}>
    {{ $slot }}
</button>
```

### Componente de tabla

```php
// AppServiceProvider.php
public function boot()
{
    Zest::definePresets([
        'table' => 'min-w-full divide-y divide-gray-200',
        'table-head' => 'bg-gray-50',
        'table-th' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider',
        'table-body' => 'bg-white divide-y divide-gray-200',
        'table-td' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-500',
    ]);
}
```

```blade
<!-- table.blade.php -->
<table class="@preset('table')">
    <thead class="@preset('table-head')">
        <tr>
            @foreach($headers as $header)
                <th class="@preset('table-th')">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody class="@preset('table-body')">
        @foreach($rows as $row)
            <tr>
                @foreach($row as $cell)
                    <td class="@preset('table-td')">{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
```

## Licencia

MIT
