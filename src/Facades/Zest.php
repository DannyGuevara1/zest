<?php

namespace Dannyguevara1\Zest\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see ZestManager
 */
class Zest extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'zest';
    }
}
