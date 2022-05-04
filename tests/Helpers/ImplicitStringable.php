<?php

namespace Vendeka\Text\Tests\Helpers;

class ImplicitStringable
{
    public function __construct(public string $string)
    {        
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
