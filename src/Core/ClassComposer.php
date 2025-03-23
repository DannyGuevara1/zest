<?php

namespace Dannyguevara1\Zest\Core;

use Illuminate\Support\Arr;
use Stringable;

class ClassComposer implements Stringable
{
    protected array $pending = [];

    public function add($classes): static
    {
        $this->pending[] = Arr::toCssClasses($classes);

        return $this;
    }

    public function __toString(): string
    {
        return collect($this->pending)->join(' ');
    }
}
