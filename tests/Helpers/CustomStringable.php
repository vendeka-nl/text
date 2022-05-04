<?php

namespace Vendeka\Text\Tests\Helpers;

class CustomStringable
{
    public function __construct(public string $string)
    {        
    }

    public function toString(): string
    {
        return $this->string;
    }
}
