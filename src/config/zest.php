<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auto-registro de presets
    |--------------------------------------------------------------------------
    |
    | Si es true, los presets definidos en la configuración serán registrados
    | automáticamente cuando se cargue el paquete. Si es false, deberás
    | registrarlos manualmente.
    |
    */

    'auto_register' => true,

    /*
    |--------------------------------------------------------------------------
    | Presets
    |--------------------------------------------------------------------------
    |
    | Aquí puedes definir presets para tu aplicación.
    | Se recomienda organizarlos por tipos de componentes usando prefijos.
    | Ejemplos: 'btn-primary', 'card-header', 'badge-success', etc.
    |
    */

    'presets' => [
        // Define tus propios presets aquí
        // 'ejemplo' => 'bg-gray-100 text-gray-800',
    ],

    /*
    |--------------------------------------------------------------------------
    | Directivas Blade
    |--------------------------------------------------------------------------
    |
    | Configura si deseas habilitar las directivas Blade para presets.
    |
    */

    'directives' => [
        'enabled' => true,
        'prefix' => 'preset', // Resultará en @preset() y @presetIf()
    ],
];
