<?php

namespace Dannyguevara1\Zest;

use Dannyguevara1\Zest\Core\ClassComposer;

class ZestManager
{
    public function classes($styles = null): ClassComposer
    {
        $builder = new ClassComposer();

        return $styles ? $builder->add($styles) : $builder;
    }
}
